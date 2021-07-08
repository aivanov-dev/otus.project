<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        $this->exporter->getOrRegisterCounter(
            'request_count',
            'Count of requests',
            ['request_type', 'request_code', 'request_route', 'request_uri']
        )->inc([$request->method(), $response->getStatusCode(), $request->route()->uri(), $request->getRequestUri()]);

        $duration = sprintf("%.2f", microtime(true) - LARAVEL_START);
        $this->exporter->getOrRegisterHistogram(
            'response_time_seconds',
            'The response time of a request.',
            ['request_type', 'request_code', 'request_route', 'request_uri'],
        )->observe(
            (float)$duration,
            [$request->method(), $response->getStatusCode(), $request->route()->uri(), $request->getRequestUri()]
        );
        return $response;
    }
}
