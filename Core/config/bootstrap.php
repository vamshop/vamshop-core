<?php

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Database\Type;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Vamshop\Core\Vamshop;

\Vamshop\Core\timerStart('Vamshop bootstrap');
$dbConfigExists = false;
$salted = Security::getSalt() !== '__SALT__';

if (file_exists(ROOT . DS . 'config' . DS . 'database.php')) {
    Configure::load('database', 'default');
    ConnectionManager::drop('default');
    ConnectionManager::config(Configure::consume('Datasources'));
}

try {
    $defaultConnection = ConnectionManager::get('default');
    $dbConfigExists = $defaultConnection->connect();
} catch (\Exception $e) {
    $dbConfigExists = false;
}

// Map our custom types
Type::map('params', 'Vamshop\Core\Database\Type\ParamsType');
Type::map('encoded', 'Vamshop\Core\Database\Type\EncodedType');
Type::map('link', 'Vamshop\Core\Database\Type\LinkType');

Configure::write(
    'DebugKit.panels',
    array_merge((array)Configure::read('DebugKit.panels'), [
        'Vamshop/Core.Plugins',
        'Vamshop/Core.ViewHelpers',
        'Vamshop/Core.Components',
    ])
);

Vamshop::hookComponent('*', [
    'Vamshop' => [
        'className' => 'Vamshop/Core.Vamshop',
        'priority' => 5
    ]
]);
Vamshop::hookComponent('*', 'Vamshop/Acl.Filter');
Vamshop::hookComponent('*', 'Security');
Vamshop::hookComponent('*', 'Csrf');
Vamshop::hookComponent('*', 'Acl.Acl');
Vamshop::hookComponent('*', 'Auth');
Vamshop::hookComponent('*', 'Flash');
Vamshop::hookComponent('*', 'RequestHandler');
Vamshop::hookComponent('*', 'Vamshop/Core.Theme');

require_once __DIR__ . DS . 'vamshop_bootstrap.php';

Vamshop::hookHelper('*', 'Vamshop/Core.Js');
Vamshop::hookHelper('*', 'Vamshop/Core.Layout');
\Vamshop\Core\timerStop('Vamshop bootstrap');

// Load Install plugin
if (!Configure::read('Vamshop.installed') || !$salted) {
    Plugin::load('Vamshop/Install', ['routes' => true, 'bootstrap' => true]);
}
