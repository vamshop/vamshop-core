<?php

use Cake\Routing\RouteBuilder;
use Vamshop\Core\Router;

Router::plugin('Vamshop/Nodes', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('admin', function (RouteBuilder $route) {
        $route->extensions(['json']);

        $route->scope('/nodes', [], function (RouteBuilder $route) {
            $route->fallbacks();
        });
    });

    $route->extensions(['rss']);
    $route->extensions(['json']);

    Router::build($route, '/', ['controller' => 'Nodes', 'action' => 'promoted']);
    Router::build($route, '/promoted/*', ['controller' => 'Nodes', 'action' => 'promoted']);
    Router::build($route, '/search', ['controller' => 'Nodes', 'action' => 'search']);

    // Content types
    Router::routableContentTypes($route);
    Router::contentType('_placeholder', $route);
});

Router::plugin('Vamshop/Nodes', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('api', function (RouteBuilder $route) {
        $route->prefix('v10', ['path' => '/v1.0'], function (RouteBuilder $route) {
            $route->extensions(['json']);

            $route->scope('/nodes', [], function (RouteBuilder $route) {
                $route->fallbacks();
            });
        });
    });
});
