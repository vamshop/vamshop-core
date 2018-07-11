<?php

namespace Vamshop\Taxonomy\Config;

use Vamshop\Core\Nav;

Nav::add('sidebar', 'content.children.content_types', [
    'title' => __d('vamshop', 'Content Types'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Vamshop/Taxonomy',
        'controller' => 'Types',
        'action' => 'index',
    ],
    'weight' => 30,
]);

Nav::add('sidebar', 'content.children.taxonomy', [
    'title' => __d('vamshop', 'Taxonomy'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Vamshop/Taxonomy',
        'controller' => 'Vocabularies',
        'action' => 'index',
    ],
    'weight' => 40,
    'children' => [
        'list' => [
            'title' => __d('vamshop', 'List'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Taxonomy',
                'controller' => 'Vocabularies',
                'action' => 'index',
            ],
            'weight' => 10,
        ],
        'add_new' => [
            'title' => __d('vamshop', 'Add new'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Taxonomy',
                'controller' => 'Vocabularies',
                'action' => 'add',
            ],
            'weight' => 20,
            'htmlAttributes' => ['class' => 'separator'],
        ]
    ]
]);
