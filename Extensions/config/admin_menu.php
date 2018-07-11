<?php

namespace Vamshop\Extensions\Config;

use Vamshop\Core\Nav;

Nav::add('sidebar', 'extensions', [
    'icon' => 'magic',
    'title' => __d('croogo', 'Extensions'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Vamshop/Extensions',
        'controller' => 'Plugins',
        'action' => 'index',
    ],
    'weight' => 35,
    'children' => [
        'themes' => [
            'title' => __d('croogo', 'Themes'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Extensions',
                'controller' => 'Themes',
                'action' => 'index',
            ],
            'weight' => 10,
        ],
        'locales' => [
            'title' => __d('croogo', 'Locales'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Extensions',
                'controller' => 'Locales',
                'action' => 'index',
            ],
            'weight' => 20,
        ],
        'plugins' => [
            'title' => __d('croogo', 'Plugins'),
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
