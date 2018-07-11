<?php

use Cake\Routing\RouteBuilder;
use Vamshop\Core\Router;

Router::addUrlFilter(function ($params, $request) {
    if ($request->getParam('lang') && !isset($params['lang'])) {
        $params['lang'] = $request->getParam('lang');
    }
    return $params;
});

Router::plugin('Vamshop/Translate', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('admin', function (RouteBuilder $route) {
        $route->scope('/translate', [], function(RouteBuilder $route) {
            $route->fallbacks();
        });
    });
});
