<?php
// @codingStandardsIgnoreFile

use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use Vamshop\Core\Plugin;

$findRoot = function () {
	$root = dirname(__DIR__);
	if (is_dir($root . '/vendor/cakephp/cakephp')) {
		return $root;
	}

	$root = dirname(dirname(__DIR__));
	if (is_dir($root . '/vendor/cakephp/cakephp')) {
		return $root;
	}

	$root = dirname(dirname(dirname(__DIR__)));
	if (is_dir($root . '/vendor/cakephp/cakephp')) {
		return $root;
	}
};

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

require ROOT . '/vendor/autoload.php';
require CORE_PATH . 'config/bootstrap.php';


Cake\Core\Configure::write('debug', true);

$TMP = new \Cake\Filesystem\Folder(TMP);
$TMP->create(TMP . 'cache/models', 0777);
$TMP->create(TMP . 'cache/persistent', 0777);
$TMP->create(TMP . 'cache/views', 0777);

$cache = [
	'default' => [
		'engine' => 'File'
	],
	'_cake_core_' => [
		'className' => 'File',
		'prefix' => 'vamshop_core_myapp_cake_core_',
		'path' => CACHE . 'persistent/',
		'serialize' => true,
		'duration' => '+10 seconds'
	],
	'_cake_model_' => [
		'className' => 'File',
		'prefix' => 'vamshop_core_my_app_cake_model_',
		'path' => CACHE . 'models/',
		'serialize' => 'File',
		'duration' => '+10 seconds'
	]
];

Cake\Cache\Cache::config($cache);
Cake\Core\Configure::write('Session', [
	'defaults' => 'php'
]);

Plugin::load('Vamshop/Core', ['bootstrap' => true, 'routes' => true]);
Plugin::load('Vamshop/Blocks', ['bootstrap' => true, 'routes' => true]);
Plugin::load('Vamshop/Settings', ['bootstrap' => true, 'routes' => true]);

//Cake\Routing\DispatcherFactory::add('Routing');
//Cake\Routing\DispatcherFactory::add('ControllerFactory');

//class_alias('Vamshop\Core\TestSuite\TestCase', 'Vamshop\Core\TestSuite\VamshopTestCase');
Router::defaultRouteClass(DashedRoute::class);
Plugin::routes();

