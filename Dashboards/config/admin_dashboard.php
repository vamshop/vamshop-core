<?php

use Vamshop\Dashboards\VamshopDashboard;

$config = [
    'dashboards.blogfeed' => [
        'title' => __d('vamshop', 'VamShop News'),
        'cell' => 'Vamshop/Dashboards.BlogFeed::dashboard',
        'column' => VamshopDashboard::RIGHT,
        'access' => ['superadmin'],
    ],
];
