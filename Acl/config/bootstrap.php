<?php

use Cake\Cache\Cache;
use Cake\Core\App;
use Cake\Core\Configure;
use Vamshop\Core\Vamshop;

if (Configure::read('Site.acl_plugin') == 'Vamshop/Acl') {
    // activate AclFilter component only until after a succesfull install
    if (Configure::read('Vamshop.installed')) {
        Vamshop::hookComponent('*', 'Vamshop/Acl.Filter');
        Vamshop::hookComponent('*', 'Vamshop/Acl.Access');
    }

    Vamshop::hookBehavior('Vamshop/Users.Users', 'Vamshop/Acl.UserAro', ['priority' => 20]);
    Vamshop::hookBehavior('Vamshop/Users.Roles', 'Vamshop/Acl.RoleAro', ['priority' => 20]);

    $defaultCacheConfig = Configure::read('Vamshop.Cache.defaultConfig');
    Cache::config('permissions', [
        'duration' => '+1 hour',
        'path' => CACHE . 'acl' . DS,
        'groups' => ['acl']
    ] + $defaultCacheConfig);

    if (Configure::read('Access Control.multiRole')) {
        Configure::write('Acl.classname', App::className('Vamshop/Acl.HabtmDbAcl', 'Adapter'));
    }
}
