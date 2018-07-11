<?php

namespace Vamshop\Menus\Config;

use Vamshop\Core\Nav;

Nav::add('sidebar', 'settings.children.meta', [
    'title' => __d('croogo', 'Meta'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Vamshop/Meta',
        'controller' => 'Meta',
        'action' => 'index',
    ],
    'weight' => 20,
]);
