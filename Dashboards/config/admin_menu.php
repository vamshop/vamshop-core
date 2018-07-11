<?php

use Vamshop\Core\Nav;

Nav::add('sidebar', 'dashboard', [
    'icon' => 'home',
    'title' => __d('croogo', 'Dashboard'),
    'url' => '/admin',
    'weight' => 0,
]);

Nav::add('sidebar', 'settings.children.dashboard', [
    'title' => __d('croogo', 'Dashboard'),
    'url' => [
        'plugin' => 'Vamshop/Dashboards',
        'controller' => 'Dashboards',
        'action' => 'index',
    ],
]);
