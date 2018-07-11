<?php

use Cake\Routing\RouteBuilder;
use Vamshop\Core\Router;

Router::plugin('Vamshop/Contacts', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('admin', function (RouteBuilder $route) {
        $route->extensions(['json']);

        $route->scope('/contacts', [], function (RouteBuilder $route) {
            $route->fallbacks();
        });
    });

    Router::build($route, '/contact', ['controller' => 'Contacts', 'action' => 'view', 'contact']);
    Router::build($route, '/contact/*', ['controller' => 'Contacts', 'action' => 'view']);
});
