<?php

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Cache\Cache;
use Vamshop\Core\Vamshop;
use Vamshop\Wysiwyg\Wysiwyg;

$cacheConfig = array_merge(
    Configure::read('Vamshop.Cache.defaultConfig'),
    ['groups' => ['nodes']]
);
Cache::config('nodes', $cacheConfig);
Cache::config('nodes_view', $cacheConfig);
Cache::config('nodes_promoted', $cacheConfig);
Cache::config('nodes_term', $cacheConfig);
Cache::config('nodes_index', $cacheConfig);

Vamshop::hookApiComponent('Vamshop/Nodes.Nodes', 'Nodes.NodeApi');
Vamshop::hookComponent('*', [
    'NodesHook' => [
        'className' => 'Vamshop/Nodes.Nodes'
    ]
]);

Vamshop::hookHelper('*', 'Vamshop/Nodes.Nodes');

// Configure Wysiwyg
Wysiwyg::setActions([
    'Vamshop/Nodes.Admin/Nodes/add' => [
        [
            'elements' => 'NodeBody',
        ],
    ],
    'Vamshop/Nodes.Admin/Nodes/edit' => [
        [
            'elements' => 'NodeBody',
        ],
    ],
    'Vamshop/Translate.Admin/Translate/edit' => [
        [
            'elements' => 'NodeBody',
        ],
    ],
]);

Vamshop::translateModel('Vamshop/Nodes.Nodes', [
    'fields' => [
        'title',
        'excerpt',
        'body',
    ],
]);
