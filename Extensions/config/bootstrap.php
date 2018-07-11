<?php

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Vamshop\Extensions\VamshopPlugin;

if (!Plugin::loaded('Migrations')) {
    Plugin::load('Migrations', ['autoload' => true, 'classBase' => false]);
}
if (!Plugin::loaded('Vamshop/Settings')) {
    Plugin::load('Vamshop/Settings', ['bootstrap' => true, 'routes' => true]);
}
if (!Plugin::loaded('Search')) {
    Plugin::load('Search', ['autoload' => true, 'classBase' => false]);
}

class_alias('Vamshop\Core\Plugin', 'Vamshop\Extensions\VamshopPlugin');
