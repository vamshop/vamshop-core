<?php

namespace Vamshop\Contacts\Config;

use Vamshop\Core\Nav;

Nav::add('sidebar', 'contacts', [
    'icon' => 'comments',
    'title' => __d('vamshop', 'Contacts'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Vamshop/Contacts',
        'controller' => 'Contacts',
        'action' => 'index',
    ],
    'weight' => 50,
    'children' => [
        'contacts' => [
            'title' => __d('vamshop', 'Contacts'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Contacts',
                'controller' => 'Contacts',
                'action' => 'index',
            ],
        ],
        'messages' => [
            'title' => __d('vamshop', 'Messages'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Contacts',
                'controller' => 'Messages',
                'action' => 'index',
            ],
        ],
    ],
]);
