<?php

use Cake\Core\Configure;
use Cake\Cache\Cache;
use Vamshop\Core\Vamshop;

Vamshop::hookApiComponent('Vamshop/Users.Users', 'Users.UserApi');

/**
 * Failed login attempts
 *
 * Default is 5 failed login attempts in every 5 minutes
 */
$cacheConfig = array_merge(
    Configure::read('Vamshop.Cache.defaultConfig'),
    ['groups' => ['users']]
);
$failedLoginDuration = 300;
Configure::write('User.failed_login_limit', 5);
Configure::write('User.failed_login_duration', $failedLoginDuration);
Cache::config('users_login', array_merge($cacheConfig, [
    'duration' => '+' . $failedLoginDuration . ' seconds',
    'groups' => ['users'],
]));

Vamshop::hookAdminRowAction('Vamshop/Users.Admin/Users/index', 'Reset Password', [
    'prefix:admin/plugin:Vamshop%2fUsers/controller:users/action:reset_password/:id' => [
        'title' => false,
        'options' => [
            'icon' => 'unlock',
            'tooltip' => [
                'data-title' => __d('croogo', 'Reset password'),
            ],
        ],
    ],
]);

Vamshop::hookComponent('*', 'Vamshop/Users.LoggedInUser');
