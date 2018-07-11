<?php

use Cake\Core\Configure;
use Cake\Cache\Cache;
use Vamshop\Core\Vamshop;

$cacheConfig = array_merge(
    Configure::read('Vamshop.Cache.defaultConfig'),
    ['groups' => ['taxonomy']]
);
Cache::config('croogo_types', $cacheConfig);
Cache::config('croogo_vocabularies', $cacheConfig);

Vamshop::hookComponent('*', 'Vamshop/Taxonomy.Taxonomies');

Vamshop::hookHelper('*', 'Vamshop/Taxonomy.Taxonomies');

Vamshop::translateModel('Vamshop/Taxonomy.Terms', [
    'fields' => [
        'title',
        'description',
    ],
]);

Vamshop::translateModel('Vamshop/Taxonomy.Types', [
    'fields' => [
        'title',
        'description',
    ],
]);
