<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin('Vamshop/Dashboards', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('admin', function (RouteBuilder $route) {
        $route->extensions(['json']);

        $route->scope('/dashboards', [], function (RouteBuilder $route) {
            $route->fallbacks();
        });
    });
});
