<?php

use Croogo\Dashboards\CroogoDashboard;

$config = [
    'dashboards.blogfeed' => [
        'title' => __d('croogo', 'VamShop News'),
        'cell' => 'Croogo/Dashboards.BlogFeed::dashboard',
        'column' => CroogoDashboard::RIGHT,
        'access' => ['superadmin'],
    ],
];
