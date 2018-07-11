<?php

namespace Vamshop\Users\Config;

use Vamshop\Core\Nav;

Nav::add('sidebar', 'users', [
    'icon' => 'user',
    'title' => __d('croogo', 'Users'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Vamshop/Users',
        'controller' => 'Users',
        'action' => 'index',
    ],
    'weight' => 50,
    'children' => [
        'users' => [
            'title' => __d('croogo', 'Users'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Users',
                'controller' => 'Users',
                'action' => 'index',
            ],
            'weight' => 10,
        ],
        'roles' => [
            'title' => __d('croogo', 'Roles'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Users',
                'controller' => 'Roles',
                'action' => 'index',
            ],
            'weight' => 20,
        ],
    ],
]);
