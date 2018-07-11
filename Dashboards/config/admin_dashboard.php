<?php

use Vamshop\Dashboards\VamshopDashboard;

$config = [
    'dashboards.blogfeed' => [
        'title' => __d('croogo', 'VamShop News'),
        'cell' => 'Vamshop/Dashboards.BlogFeed::dashboard',
        'column' => VamshopDashboard::RIGHT,
        'access' => ['superadmin'],
    ],
];
