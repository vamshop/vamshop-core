<?php

use Cake\Core\Configure;
use Cake\Cache\Cache;
use Vamshop\Core\Vamshop;

Cache::config('croogo_blocks', array_merge(
    Cache::config('default'),
    ['groups' => ['blocks']]
));

Vamshop::hookComponent('*', [
    'BlocksHook' => [
        'className' => 'Vamshop/Blocks.Blocks',
        'priority' => 9,
    ]
]);

Vamshop::hookHelper('*', 'Vamshop/Blocks.Regions');

Vamshop::translateModel('Vamshop/Blocks.Blocks', [
    'fields' => [
        'title',
        'body',
    ],
    'allowEmptyTranslations' => false,
]);
