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
        $duration = sprintf("%.2f", microtime(true) - LARAVEL_START);
        $this->exporter->getOrRegisterHistogram(
            'response_time_seconds',
            'The response time of a request.',
            ['request_type'],
        )->observe((float)$duration, [$request->method()]);
        return $next($request);
    }
}
