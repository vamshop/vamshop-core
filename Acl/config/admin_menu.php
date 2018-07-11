<?php

namespace Vamshop\Acl\Config;

use Vamshop\Core\Nav;

Nav::add('sidebar', 'users.children.permissions', [
    'title' => __d('vamshop', 'Permissions'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Vamshop/Acl',
        'controller' => 'Permissions',
        'action' => 'index',
    ],
    'weight' => 30,
]);

Nav::add('sidebar', 'settings.children.acl', [
    'title' => __d('vamshop', 'Access Control'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Vamshop/Settings',
        'controller' => 'Settings',
        'action' => 'prefix',
        'Access Control',
    ],
]);
