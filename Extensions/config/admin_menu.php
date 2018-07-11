<?php

namespace Vamshop\Extensions\Config;

use Vamshop\Core\Nav;

Nav::add('sidebar', 'extensions', [
    'icon' => 'magic',
    'title' => __d('vamshop', 'Extensions'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Vamshop/Extensions',
        'controller' => 'Plugins',
        'action' => 'index',
    ],
    'weight' => 35,
    'children' => [
        'themes' => [
            'title' => __d('vamshop', 'Themes'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Extensions',
                'controller' => 'Themes',
                'action' => 'index',
            ],
            'weight' => 10,
        ],
        'locales' => [
            'title' => __d('vamshop', 'Locales'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Extensions',
                'controller' => 'Locales',
                'action' => 'index',
            ],
            'weight' => 20,
        ],
        'plugins' => [
            'title' => __d('vamshop', 'Plugins'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Extensions',
                'controller' => 'Plugins',
                'action' => 'index',
            ],
            'htmlAttributes' => [
                'class' => 'separator',
            ],
            'weight' => 30,
        ],
    ],
]);
