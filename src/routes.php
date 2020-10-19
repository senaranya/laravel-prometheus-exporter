<?php

/** @var Route $route */

use Aranyasen\LaravelPrometheusExporter\MetricsController;
use Illuminate\Routing\Route;

$route = Route::get(
    config('prometheus.metrics_route_path'),
    MetricsController::class . '@getMetrics'
);

if ($name = config('prometheus.metrics_route_name')) {
    $route->name($name);
}

$middleware = config('prometheus.metrics_route_middleware');

if ($middleware) {
    $route->middleware(explode(',', $middleware));
}
