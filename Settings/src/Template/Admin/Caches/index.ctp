<?php

use Cake\Core\App;
$this->extend('Vamshop/Core./Common/admin_index');

$clearUrl = [
    'prefix' => 'admin',
    'plugin' => 'Vamshop/Settings',
    'controller' => 'Caches',
    'action' => 'clear',
];

$this->Breadcrumbs->add(__d('vamshop', 'Settings'),
    ['plugin' => 'Vamshop/Settings', 'controller' => 'Settings', 'action' => 'prefix', 'Site'])
    ->add(__d('vamshop', 'Caches'), $this->request->getUri()->getPath());

$this->append('action-buttons');
    echo $this->Vamshop->adminAction(__d('vamshop', 'Clear All'), array_merge(
            $clearUrl, ['config' => 'all']
        ), [
        'method' => 'post',
        'tooltip' => [
            'data-title' => __d('vamshop', 'Clear all cache'),
            'data-placement' => 'left',
        ],
    ]);
$this->end();

$tableHeaders = $this->Html->tableHeaders([
    $this->Paginator->sort('title', __d('vamshop', 'Cache')),
    __d('vamshop', 'Engine'),
    __d('vamshop', 'Duration'),
    __d('vamshop', 'Actions')
]);
$this->append('table-heading', $tableHeaders);

$rows = [];
foreach ($caches as $cache => $engine):
    $actions = [];
    $actions[] = $this->Vamshop->adminAction('',
        array_merge($clearUrl, ['config' => $cache]), [
        'button' => false,
        'class' => 'red',
        'icon' => 'delete',
        'method' => 'post',
        'tooltip' => [
            'data-title' => __d('vamshop', 'Clear cache: %s', $cache),
            'data-placement' => 'left',
        ],
    ]);
    $actions = $this->Html->div('item-actions', implode(' ', $actions));

    $rows[] = [
        $cache,
        App::shortName(get_class($engine), 'Cache/Engine', 'Engine'),
        $engine->config('duration'),
        $actions,
    ];
endforeach;

$this->append('table-body', $this->Html->tableCells($rows));
