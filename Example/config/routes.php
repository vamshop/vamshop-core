<?php

use Cake\Routing\RouteBuilder;
use Vamshop\Core\Router;

Router::plugin('Vamshop/Example', ['path' => '/'], function (RouteBuilder $routeBuilder) {
    $routeBuilder->prefix('admin', function (RouteBuilder $routeBuilder) {
        $routeBuilder->extensions(['json']);

        $routeBuilder->connect('/example/admin/route/here', [
            'plugin' => 'Vamshop/Example',
            'controller' => 'Example',
            'action' => 'index',
        ]);

        $routeBuilder->fallbacks();
    });

    Router::build($routeBuilder, '/example/route/here', [
        'plugin' => 'Vamshop/Example',
        'controller' => 'example',
        'action' => 'index',
    ]);

    $routeBuilder->fallbacks();
});
