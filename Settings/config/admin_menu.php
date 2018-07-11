<?php

namespace Vamshop\Settings\Config;

use Vamshop\Core\Nav;

Nav::add('sidebar', 'settings', [
    'icon' => 'cog',
    'title' => __d('vamshop', 'Settings'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Vamshop/Settings',
        'controller' => 'Settings',
        'action' => 'prefix',
        'Site',
    ],
    'weight' => 60,
    'children' => [
        'site' => [
            'title' => __d('vamshop', 'Site'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Site',
            ],
            'weight' => 10,
        ],

        'theme' => [
            'title' => __d('vamshop', 'Theme'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Theme',
            ],
            'weight' => 15,
        ],

        'reading' => [
            'title' => __d('vamshop', 'Reading'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Reading',
            ],
            'weight' => 30,
        ],

        'writing' => [
            'title' => __d('vamshop', 'Writing'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Writing',
            ],
            'weight' => 40,
        ],

        'comment' => [
            'title' => __d('vamshop', 'Comment'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Comment',
            ],
            'weight' => 50,
        ],

        'service' => [
            'title' => __d('vamshop', 'Service'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Service',
            ],
            'weight' => 60,
        ],

        'languages' => [
            'title' => __d('vamshop', 'Languages'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Settings',
                'controller' => 'Languages',
                'action' => 'index',
            ],
            'weight' => 70,
        ],

        'cache' => [
            'title' => __d('vamshop', 'Cache'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Settings',
                'controller' => 'Caches',
                'action' => 'index',
            ],
            'weight' => 70,
        ],

    ],
]);
