<?php

namespace Vamshop\Dashboards\Event;

use Cake\Event\EventListenerInterface;
use Cake\Core\Plugin;
use Cake\Core\Configure;

/**
 * DashboardsEventHandler
 *
 * @package  Vamshop.Dashboards.Event
 * @author   Walther Lalk <emailme@waltherlalk.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class DashboardsEventHandler implements EventListenerInterface
{

/**
 * implementedEvents
 */
    public function implementedEvents()
    {
        return [
            'Vamshop.setupAdminDashboardData' => [
                'callable' => 'onSetupAdminDashboardData',
            ],
        ];
    }

/**
 * Setup admin data
 */
    public function onSetupAdminDashboardData($event)
    {
        $plugins = Plugin::loaded();
        $config = 'config' . DS . 'admin_dashboard.php';
        foreach ($plugins as $plugin) {
            $file = Plugin::path($plugin) . $config;
            if (file_exists($file)) {
                Configure::load($plugin .'.' . 'admin_dashboard', 'dashboards');
            }
        }
    }
}
