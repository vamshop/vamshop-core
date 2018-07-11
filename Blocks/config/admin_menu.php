<?php

namespace Vamshop\Blocks\Config;

use Vamshop\Core\Nav;

Nav::add('sidebar', 'blocks', [
    'icon' => 'columns',
    'title' => __d('vamshop', 'Blocks'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Vamshop/Blocks',
        'controller' => 'Blocks',
        'action' => 'index',
    ],
    'weight' => 30,
    'children' => [
        'blocks' => [
            'title' => __d('vamshop', 'Blocks'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Blocks',
                'controller' => 'Blocks',
                'action' => 'index',
            ],
        ],
        'regions' => [
            'title' => __d('vamshop', 'Regions'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Blocks',
                'controller' => 'Regions',
                'action' => 'index',
            ],
        ],
    ],
]);
