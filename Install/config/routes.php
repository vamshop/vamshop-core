<?php

use Cake\Routing\Router;

Router::connect('/', []);

Router::scope('/install', ['plugin' => 'Vamshop/Install', 'controller' => 'Install'], function (\Cake\Routing\RouteBuilder $routeBuilder) {
    $routeBuilder->connect('/', ['action' => 'index']);
    $routeBuilder->connect('/:action');
});
