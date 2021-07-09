<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Superbalist\LaravelPrometheusExporter\PrometheusExporter;

class RequestAnalyst
{
    public function __construct(
        private PrometheusExporter $exporter
    )
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /**@var \Illuminate\Http\Response $response */
        $response = $next($request);
        if (!$this->isMetricPage($request)) {
            $this->incRequestCount($request, $response);
            $this->observeResponseTime($request, $response);
        }

        return $response;
    }


    private function isMetricPage(Request $request): bool
    {
        return config('prometheus.metrics_route_path') === $request->path();
    }

    private function incRequestCount(Request $request, SymfonyResponse $response): void
    {
        $this->exporter->getOrRegisterCounter(
            'request_count',
            'Count of requests',
            ['method', 'code', 'route', 'uri']
        )->inc([$request->method(), $response->getStatusCode(), $request->route()?->uri(), $request->getRequestUri()]);
    }

    private function observeResponseTime(Request $request, SymfonyResponse $response): void
    {
        $duration = sprintf("%.2f", microtime(true) - LARAVEL_START);
        $this->exporter->getOrRegisterHistogram(
            'response_time_seconds',
            'The response time of a request.',
            ['method', 'code', 'route', 'uri'],
        )->observe(
            (float)$duration,
            [$request->method(), $response->getStatusCode(), $request->route()?->uri(), $request->getRequestUri()]
        );
    }
}
