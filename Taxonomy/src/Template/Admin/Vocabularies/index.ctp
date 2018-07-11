<?php

$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('vamshop', 'Content'),
        ['plugin' => 'Vamshop/Nodes', 'controller' => 'Nodes', 'action' => 'index'])
    ->add(__d('vamshop', 'Vocabularies'), $this->request->getRequestTarget());

$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders([
    $this->Paginator->sort('title', __d('vamshop', 'Title')),
    $this->Paginator->sort('alias', __d('vamshop', 'Alias')),
    $this->Paginator->sort('plugin', __d('vamshop', 'Plugin')),
    __d('vamshop', 'Actions'),
]);

echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
$rows = [];
foreach ($vocabularies as $vocabulary) :
    $actions = [];
    $actions[] = $this->Vamshop->adminRowAction('', ['controller' => 'Terms', 'action' => 'index', '?' => ['vocabulary_id' => $vocabulary->id]],
        ['icon' => $this->Theme->getIcon('view'), 'tooltip' => __d('vamshop', 'View terms')]);
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'moveUp', $vocabulary->id],
        ['icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('vamshop', 'Move up'), 'method' => 'post']);
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'moveDown', $vocabulary->id],
        ['icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('vamshop', 'Move down'), 'method' => 'post']);
    $actions[] = $this->Vamshop->adminRowActions($vocabulary->id);
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'edit', $vocabulary->id],
        ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('vamshop', 'Edit this item')]);
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'delete', $vocabulary->id],
        ['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('vamshop', 'Remove this item')],
        __d('vamshop', 'Are you sure?'));
    $actions = $this->Html->div('item-actions', implode(' ', $actions));
    $rows[] = [
        $this->Html->link($vocabulary->title, ['controller' => 'Terms', 'action' => 'index', '?' => ['vocabulary_id' => $vocabulary->id]]),
        $vocabulary->alias,
        $vocabulary->plugin,
        $actions,
    ];
endforeach;

echo $this->Html->tableCells($rows);

$this->end();
