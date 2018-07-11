<?php

use Cake\Core\Configure;
use Cake\Cache\Cache;
use Vamshop\Core\Vamshop;

Configure::write(
    'DebugKit.panels',
    array_merge((array)Configure::read('DebugKit.panels'), [
        'Vamshop/Settings.Settings',
    ])
);

Vamshop::hookComponent('*', [
    'SettingsComponent' => [
        'className' => 'Vamshop/Settings.Settings'
    ]
]);
