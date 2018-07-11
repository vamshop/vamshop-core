<?php

namespace Vamshop\Comments\Config;

use Vamshop\Core\Nav;

Nav::add('sidebar', 'content.children.comments', [
    'title' => __d('vamshop', 'Comments'),
    'url' => [
        'admin' => true,
        'plugin' => 'Vamshop/Comments',
        'controller' => 'Comments',
        'action' => 'index',
    ],
    'children' => [
        'published' => [
            'title' => __d('vamshop', 'Published'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Comments',
                'controller' => 'Comments',
                'action' => 'index',
                '?' => [
                    'status' => '1',
                ],
            ],
        ],
        'approval' => [
            'title' => __d('vamshop', 'Approval'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Comments',
                'controller' => 'Comments',
                'action' => 'index',
                '?' => [
                    'status' => '0',
                ],
            ],
        ],
    ],
]);
