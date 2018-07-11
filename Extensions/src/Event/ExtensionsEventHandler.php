<?php

namespace Vamshop\Extensions\Event;

use Cake\Core\Plugin;
use Cake\Event\EventListenerInterface;
use Vamshop\Extensions\VamshopPlugin;

/**
 * ExtensionsEventHandler
 *
 * @package  Vamshop.Extensions.Event
 * @author   Rachman Chavik <rchavik@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class ExtensionsEventHandler implements EventListenerInterface
{

/**
 * implementedEvents
 */
    public function implementedEvents()
    {
        return [
            'Vamshop.bootstrapComplete' => [
                'callable' => 'onBootstrapComplete',
            ],
            'Vamshop.beforeSetupAdminData' => [
                'callable' => 'onBeforeSetupAdminData',
            ],
            'Vamshop.setupAdminData' => [
                'callable' => 'onSetupAdminData',
            ],
        ];
    }

/**
 * Before Setup admin data
 */
    public function onBeforeSetupAdminData($event)
    {
        $plugins = Plugin::loaded();
        $config = 'config' . DS . 'admin.php';
        foreach ($plugins as $plugin) {
            $file = Plugin::path($plugin) . $config;
            if (file_exists($file)) {
                require $file;
            }
        }
    }

/**
 * Setup admin data
 */
    public function onSetupAdminData($event)
    {
        $plugins = Plugin::loaded();
        $config = 'config' . DS . 'admin_menu.php';
        foreach ($plugins as $plugin) {
            $file = Plugin::path($plugin) . $config;
            if (file_exists($file)) {
                require $file;
            }
        }
    }

/**
 * onBootstrapComplete
 */
    public function onBootstrapComplete($event)
    {
        VamshopPlugin::cacheDependencies();
    }
}
