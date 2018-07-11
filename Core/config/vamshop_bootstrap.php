<?php

namespace Vamshop\Core\Config;

use Aura\Intl\Package;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Exception\MissingPluginException;
use Cake\I18n\I18n;
use Cake\I18n\MessagesFileLoader;
use Cake\Log\Log;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\Routing\DispatcherFactory;

use Vamshop\Core\Vamshop;
use Vamshop\Core\Event\EventManager;
use Vamshop\Core\Plugin;
use Vamshop\Settings\Configure\Engine\DatabaseConfig;

use function Vamshop\Core\timerStart;
use function Vamshop\Core\timerStop;

// Make sure that the Vamshop event manager is the global one
EventManager::instance();

\Vamshop\Core\time(function () {
    /**
     * Default Acl plugin.  Custom Acl plugin should override this value.
     */
    Configure::write('Site.acl_plugin', 'Vamshop/Acl');

    /**
     * Default API Route Prefix. This can be overriden in settings.
     */
    Configure::write('Vamshop.Api.path', 'api');

    /**
     * Admin theme
     */
    Configure::write('Site.admin_theme', 'Vamshop/Core');

    /**
     * Cache configuration
     */
    $defaultCacheConfig = Cache::config('default');
    $defaultEngine = $defaultCacheConfig['className'];
    $defaultPrefix = Hash::get($defaultCacheConfig, 'prefix', 'cake_');
    $cacheConfig = [
        'duration' => '+1 hour',
        'path' => CACHE . 'queries' . DS,
        'className' => $defaultEngine,
        'prefix' => $defaultPrefix,
    ] + $defaultCacheConfig;
    Configure::write('Vamshop.Cache.defaultEngine', $defaultEngine);
    Configure::write('Vamshop.Cache.defaultPrefix', $defaultPrefix);
    Configure::write('Vamshop.Cache.defaultConfig', $cacheConfig);

    $configured = Cache::configured();
    if (!in_array('cached_settings', $configured)) {
        Cache::config('cached_settings', array_merge(
            Configure::read('Vamshop.Cache.defaultConfig'),
            ['groups' => ['settings']]
        ));
    }

    /**
     * Settings
     */
    Configure::config('settings', new DatabaseConfig());
    try {
        Configure::load('settings', 'settings');
    }
    catch (\Exception $e) {
        Log::error($e->getMessage());
        Log::error('You can ignore the above error during installation');
    }

    /**
     * Locale
     */
    $siteLocale = Configure::read('Site.locale');
    Configure::write('App.defaultLocale', $siteLocale);
    I18n::setLocale($siteLocale);

    /**
     * Assets
     */
    if (Configure::check('Site.asset_timestamp')) {
        $timestamp = Configure::read('Site.asset_timestamp');
        Configure::write(
            'Asset.timestamp',
            is_numeric($timestamp) ? (bool)$timestamp : $timestamp
        );
        unset($timestamp);
    }

    /**
     * List of core plugins
     */
    $corePlugins = [
        'Vamshop/Settings', 'Vamshop/Acl', 'Vamshop/Blocks', 'Vamshop/Comments', 'Vamshop/Contacts', 'Vamshop/Menus', 'Vamshop/Meta',
        'Vamshop/Nodes', 'Vamshop/Taxonomy', 'Vamshop/Users', 'Vamshop/Wysiwyg', 'Vamshop/Ckeditor',  'Vamshop/Dashboards',
    ];
    Configure::write('Core.corePlugins', $corePlugins);
}, 'Setting base configuration');

/**
 * Use old translation format for the vamshop domain
 */
$siteLocale = Configure::read('App.defaultLocale');
I18n::config('vamshop', function ($domain, $locale) {
    $loader = new MessagesFileLoader($domain, $locale, 'po');
    $package = new Package('sprintf', 'default');
    $localePackage = $loader();
    if ($localePackage) {
        $package->setMessages($localePackage->getMessages());
    }
    return $package;
});

/**
 * Timezone
 */
$timezone = Configure::read('Site.timezone');
if (!$timezone) {
    $timezone = 'UTC';
}
date_default_timezone_set($timezone);

\Vamshop\Core\time(function () {
    /**
     * Load required plugins
     */
    if (!Plugin::loaded('Acl')) {
        Plugin::load('Acl', ['bootstrap' => true]);
    }
    if (!Plugin::loaded('BootstrapUI')) {
        Plugin::load('BootstrapUI');
    }

    /**
     * Extensions
     */
    Plugin::load(['Vamshop/Extensions' => [
        'autoload' => true,
        'bootstrap' => true,
        'routes' => true,
        'events' => true
    ]]);
}, 'Loading dependencies');

/**
 * Plugins
 */
$aclPlugin = Configure::read('Site.acl_plugin');
$pluginBootstraps = Configure::read('Hook.bootstraps');
$plugins = array_filter(explode(',', $pluginBootstraps));

if (!in_array($aclPlugin, $plugins)) {
    $plugins = Hash::merge((array)$aclPlugin, $plugins);
}
$themes = [Configure::read('Site.theme'), Configure::read('Site.admin_theme')];
\Vamshop\Core\time(function () use ($plugins, $themes) {
    $option = [
        'autoload' => true,
        'bootstrap' => true,
        'ignoreMissing' => true,
        'routes' => true,
        'events' => true
    ];
    foreach ($plugins as $plugin) {
        $plugin = Inflector::camelize($plugin);
        if (Plugin::loaded($plugin)) {
            continue;
        }

        try {
            Plugin::load($plugin, $option);
        } catch (MissingPluginException $e) {
            Log::error('Plugin not found during bootstrap: ' . $plugin);
            continue;
        }
    }


    foreach ($themes as $theme) {
        if ($theme && !Plugin::loaded($theme) && Plugin::available($theme)) {
            Plugin::load($theme, [
                'autoload' => true,
                'bootstrap' => true,
                'routes' => true,
                'events' => true,
                'ignoreMissing' => true
            ]);
        }
    }
}, 'plugins-loading-configured', 'Loading configured plugins: ' . implode(', ', $plugins + $themes));

DispatcherFactory::add('Vamshop/Core.HomePage');

\Vamshop\Core\time(function () {
    Plugin::events();

    EventManager::loadListeners();
}, 'Registering plugin listeners');


\Vamshop\Core\time(function () {
    Vamshop::dispatchEvent('Vamshop.bootstrapComplete');
}, 'event-Vamshop.bootstrapComplete', 'Event: Vamshop.bootstrapComplete');
