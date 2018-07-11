<?php

/**
 * Dashboard URL
 */

use Cake\Core\Configure;
use Vamshop\Dashboards\Configure\DashboardsConfigReader;
use Vamshop\Core\Utility\StringConverter;

if (!Configure::check('Site.dashboard_url')) {
    $converter = new StringConverter();
    Configure::write('Site.dashboard_url', $converter->urlToLinkString([
        'prefix' => 'admin',
        'plugin' => 'Vamshop/Dashboards',
        'controller' => 'Dashboards',
        'action' => 'dashboard',
    ]));
}

Configure::config('dashboards', new DashboardsConfigReader());
