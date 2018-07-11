<?php

namespace Vamshop\Menus\Config;

use Vamshop\Core\Nav;

Nav::add('sidebar', 'menus', [
    'icon' => 'sitemap',
    'title' => __d('croogo', 'Menus'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Vamshop/Menus',
        'controller' => 'Menus',
        'action' => 'index',
    ],
    'weight' => 20,
    'children' => [
        'menus' => [
            'title' => __d('croogo', 'Menus'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Menus',
                'controller' => 'Menus',
                'action' => 'index',
            ],
            'weight' => 10,
        ],
    ],
]);
