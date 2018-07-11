<?php

use Cake\Utility\Inflector;
use Vamshop\Core\Status;

$this->Vamshop->adminscript('Vamshop/Menus.admin');

$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('croogo', 'Menus'), ['controller' => 'Menus', 'action' => 'index'])
    ->add(__d('croogo', $menu->title), $this->request->getRequestTarget());

$this->append('action-buttons');
echo $this->Vamshop->adminAction(__d('croogo', 'New link'), ['action' => 'add', 'menu_id' => $menu->id], ['button' => 'success']);
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
    __d('croogo', 'Title'),
    __d('croogo', 'Status'),
    __d('croogo', 'Actions'),
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
        'tooltip' => __d('croogo', 'Move up'),
    ]);
    $actions[] = $this->Vamshop->adminRowAction('', [
        'action' => 'moveDown',
        $linkId,
    ], [
        'icon' => $this->Theme->getIcon('move-down'),
        'tooltip' => __d('croogo', 'Move down'),
    ]);
    $actions[] = $this->Vamshop->adminRowActions($linkId);
    $actions[] = $this->Vamshop->adminRowAction('', [
        'action' => 'edit',
        $linkId,
    ], [
        'icon' => $this->Theme->getIcon('update'),
        'tooltip' => __d('croogo', 'Edit this item'),
    ]);
    $actions[] = $this->Vamshop->adminRowAction('', '#Link' . $linkId . 'Id', [
        'icon' => $this->Theme->getIcon('copy'),
        'tooltip' => __d('croogo', 'Create a copy'),
        'rowAction' => 'copy',
    ], __d('croogo', 'Create a copy of this Link?'));
    $actions[] = $this->Vamshop->adminRowAction('', '#Link' . $linkId . 'Id', [
        'icon' => $this->Theme->getIcon('delete'),
        'class' => 'delete',
        'tooltip' => __d('croogo', 'Delete this item'),
        'rowAction' => 'delete',
    ], __d('croogo', 'Are you sure?'));
    $actions = $this->Html->div('item-actions', implode(' ', $actions));
    if ($linksStatus[$linkId] == Status::PREVIEW) {
        $linkTitle .= ' ' . $this->Html->tag('span', __d('croogo', 'preview'), ['class' => 'label label-warning']);
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
    'label' => __d('croogo', 'Bulk actions'),
    'options' => [
        'publish' => __d('croogo', 'Publish'),
        'unpublish' => __d('croogo', 'Unpublish'),
        'delete' => __d('croogo', 'Delete'),
        [
            'value' => 'copy',
            'text' => __d('croogo', 'Copy'),
            'hidden' => true,
        ],
    ],
    'empty' => __d('croogo', 'Bulk actions'),
]);

echo $this->Form->button(__d('croogo', 'Apply'), [
    'type' => 'submit',
    'value' => 'submit',
    'class' => 'btn-outline-primary'
]);
$this->end();
