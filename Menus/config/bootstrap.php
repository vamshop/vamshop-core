<?php

use Cake\Core\Configure;
use Cake\Cache\Cache;
use Vamshop\Core\Vamshop;

Cache::config('vamshop_menus', array_merge(
    Configure::read('Vamshop.Cache.defaultConfig'),
    ['groups' => ['menus']]
));

Vamshop::hookComponent('*', 'Vamshop/Menus.Menu');

Vamshop::hookHelper('*', 'Vamshop/Menus.Menus');

Vamshop::translateModel('Vamshop/Menus.Links', [
    'fields' => [
        'title',
        'description',
    ],
]);
