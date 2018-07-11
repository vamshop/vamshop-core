<?php

use Cake\Utility\Inflector;
use Vamshop\Core\Status;

$this->Vamshop->adminscript('Vamshop/Menus.admin');

$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('vamshop', 'Menus'), ['controller' => 'Menus', 'action' => 'index'])
    ->add(__d('vamshop', $menu->title), $this->request->getRequestTarget());

$this->append('action-buttons');
echo $this->Vamshop->adminAction(__d('vamshop', 'New link'), ['action' => 'add', 'menu_id' => $menu->id], ['button' => 'success']);
$this->end();

$this->append('form-start', $this->Form->create(null, [
    'align' => 'inline',
    'url' => [
        'action' => 'process',
        $menu->id,
    ],
]));

$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders([
    $this->Form->checkbox('checkAll', ['id' => 'LinksCheckAll']),
    __d('vamshop', 'Title'),
    __d('vamshop', 'Status'),
    __d('vamshop', 'Actions'),
]);
echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
$rows = [];
foreach ($linksTree as $linkId => $linkTitle):
    $actions = [];
    $actions[] = $this->Vamshop->adminRowAction('', [
        'action' => 'moveUp',
        $linkId,
    ], [
        'icon' => $this->Theme->getIcon('move-up'),
        'tooltip' => __d('vamshop', 'Move up'),
    ]);
    $actions[] = $this->Vamshop->adminRowAction('', [
        'action' => 'moveDown',
        $linkId,
    ], [
        'icon' => $this->Theme->getIcon('move-down'),
        'tooltip' => __d('vamshop', 'Move down'),
    ]);
    $actions[] = $this->Vamshop->adminRowActions($linkId);
    $actions[] = $this->Vamshop->adminRowAction('', [
        'action' => 'edit',
        $linkId,
    ], [
        'icon' => $this->Theme->getIcon('update'),
        'tooltip' => __d('vamshop', 'Edit this item'),
    ]);
    $actions[] = $this->Vamshop->adminRowAction('', '#Link' . $linkId . 'Id', [
        'icon' => $this->Theme->getIcon('copy'),
        'tooltip' => __d('vamshop', 'Create a copy'),
        'rowAction' => 'copy',
    ], __d('vamshop', 'Create a copy of this Link?'));
    $actions[] = $this->Vamshop->adminRowAction('', '#Link' . $linkId . 'Id', [
        'icon' => $this->Theme->getIcon('delete'),
        'class' => 'delete',
        'tooltip' => __d('vamshop', 'Delete this item'),
        'rowAction' => 'delete',
    ], __d('vamshop', 'Are you sure?'));
    $actions = $this->Html->div('item-actions', implode(' ', $actions));
    if ($linksStatus[$linkId] == Status::PREVIEW) {
        $linkTitle .= ' ' . $this->Html->tag('span', __d('vamshop', 'preview'), ['class' => 'label label-warning']);
    }
    $rows[] = [
        $this->Form->checkbox('Links.' . $linkId . '.id', ['class' => 'row-select', 'id' => 'Link' . $linkId . 'Id']),
        $linkTitle,
        $this->element('Vamshop/Core.admin/toggle', [
            'id' => $linkId,
            'status' => (int)$linksStatus[$linkId],
        ]),
        $actions,
    ];
endforeach;

echo $this->Html->tableCells($rows);

$this->end();

$this->start('bulk-action');

echo $this->Form->input('action', [
    'class' => 'c-select',
    'label' => __d('vamshop', 'Bulk actions'),
    'options' => [
        'publish' => __d('vamshop', 'Publish'),
        'unpublish' => __d('vamshop', 'Unpublish'),
        'delete' => __d('vamshop', 'Delete'),
        [
            'value' => 'copy',
            'text' => __d('vamshop', 'Copy'),
            'hidden' => true,
        ],
    ],
    'empty' => __d('vamshop', 'Bulk actions'),
]);

echo $this->Form->button(__d('vamshop', 'Apply'), [
    'type' => 'submit',
    'value' => 'submit',
    'class' => 'btn-outline-primary'
]);
$this->end();
