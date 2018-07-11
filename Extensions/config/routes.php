<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin('Vamshop/Extensions', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('admin', function (RouteBuilder $route) {
        $route->extensions(['json']);

        $route->scope('/extensions', [], function (RouteBuilder $route) {
            $route->fallbacks();
        });
    });
});
