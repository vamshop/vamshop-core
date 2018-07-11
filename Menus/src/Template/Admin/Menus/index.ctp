<?php

use Vamshop\Core\Status;

$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('vamshop', 'Menus'), $this->request->getUri()->getPath());

$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders([
    $this->Paginator->sort('title', __d('vamshop', 'Title')),
    $this->Paginator->sort('alias', __d('vamshop', 'Alias')),
    $this->Paginator->sort('link_count', __d('vamshop', 'Link Count')),
    $this->Paginator->sort('status', __d('vamshop', 'Status')),
    __d('vamshop', 'Actions'),
]);
echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->start('table-body');
$rows = [];
foreach ($menus as $menu):
    $actions = [];
    $actions[] = $this->Vamshop->adminRowAction('',
        ['controller' => 'Links', 'action' => 'index', '?' => ['menu_id' => $menu->id]],
        ['icon' => $this->Theme->getIcon('inspect'), 'tooltip' => __d('vamshop', 'View links')]);
    $actions[] = $this->Vamshop->adminRowActions($menu->id);
    $actions[] = $this->Vamshop->adminRowAction('', ['controller' => 'Menus', 'action' => 'edit', $menu->id],
        ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('vamshop', 'Edit this item')]);
    $actions[] = $this->Vamshop->adminRowAction('', ['controller' => 'Menus', 'action' => 'delete', $menu->id],
        ['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('vamshop', 'Remove this item')],
        __d('vamshop', 'Are you sure?'));
    $actions = $this->Html->div('item-actions', implode(' ', $actions));

    $title = $this->Html->link($menu->title, [
        'controller' => 'Links',
        '?' => [
            'menu_id' => $menu->id,
        ],
    ]);

    if ($menu->status === Status::PREVIEW) {
        $title .= ' ' . $this->Html->tag('span', __d('vamshop', 'preview'), ['class' => 'label label-warning']);
    }

    $status = $this->element('Vamshop/Core.admin/toggle', [
        'id' => $menu->id,
        'status' => $menu->status,
    ]);

    $rows[] = [
        $title,
        $menu->alias,
        $menu->link_count,
        $status,
        $this->Html->div('item-actions', $actions),
    ];
endforeach;

echo $this->Html->tableCells($rows);

$this->end();
