<?php

$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('vamshop', 'Settings'),
    ['plugin' => 'Vamshop/Settings', 'controller' => 'Settings', 'action' => 'prefix', 'Site'])
    ->add(__d('vamshop', 'Languages'), $this->request->getUri()->getPath());

$tableHeaders = $this->Html->tableHeaders([
    $this->Paginator->sort('title', __d('vamshop', 'Title')),
    $this->Paginator->sort('native', __d('vamshop', 'Native')),
    $this->Paginator->sort('alias', __d('vamshop', 'Alias')),
    $this->Paginator->sort('locale', __d('vamshop', 'Locale')),
    $this->Paginator->sort('status', __d('vamshop', 'Status')),
    __d('vamshop', 'Actions'),
]);
$this->append('table-heading', $tableHeaders);

$rows = [];
foreach ($languages as $language) {
    $actions = [];
    $actions[] = $this->Vamshop->adminRowActions($language->id);
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'moveUp', $language->id],
        ['icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('vamshop', 'Move up')]);
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'moveDown', $language->id],
        ['icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('vamshop', 'Move down')]);
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'edit', $language->id],
        ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('vamshop', 'Edit this item')]);
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'delete', $language->id],
        ['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('vamshop', 'Remove this item')],
        __d('vamshop', 'Are you sure?'));

    $actions = $this->Html->div('item-actions', implode(' ', $actions));

    $rows[] = [
        $language->title,
        $language->native,
        $language->alias,
        $language->locale,
        $this->Html->status($language->status),
        $actions,
    ];
}

$this->append('table-body', $this->Html->tableCells($rows));
