<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin('Vamshop/Settings', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('admin', function (RouteBuilder $route) {
        $route->extensions(['json']);

        $route->scope('/settings', [], function (RouteBuilder $route) {
            $route->fallbacks();
        });
    });
});
