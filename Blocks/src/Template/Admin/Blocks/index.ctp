<?php

use Vamshop\Core\Status;

$this->Vamshop->adminScript('Vamshop/Blocks.admin');

$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('vamshop', 'Blocks'), $this->request->getUri()->getPath());

$this->append('form-start', $this->Form->create(null, [
    'url' => ['action' => 'process'],
    'align' => 'inline'
]));

$chooser = isset($this->request->query['chooser']);
$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders([
    $this->Form->checkbox('checkAll', ['id' => 'BlocksCheckAll']),
    $this->Paginator->sort('title', __d('vamshop', 'Title')),
    $this->Paginator->sort('alias', __d('vamshop', 'Alias')),
    $this->Paginator->sort('region_id', __d('vamshop', 'Region')),
    $this->Paginator->sort('updated', __d('vamshop', 'Updated')),
    $this->Paginator->sort('status', __d('vamshop', 'Status')),
    __d('vamshop', 'Actions'),
]);
echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
$rows = [];
foreach ($blocks as $block) {
    $actions = [];
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'moveUp', $block->id], [
            'icon' => $this->Theme->getIcon('move-up'),
            'tooltip' => __d('vamshop', 'Move up'),
            'method' => 'post',
        ]);
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'moveDown', $block->id], [
            'icon' => $this->Theme->getIcon('move-down'),
            'tooltip' => __d('vamshop', 'Move down'),
            'method' => 'post',
        ]);
    $actions[] = $this->Vamshop->adminRowActions($block->id);
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'edit', $block->id],
        ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('vamshop', 'Edit this item')]);
    $actions[] = $this->Vamshop->adminRowAction('', '#Blocks' . $block->id . 'Id', [
            'icon' => $this->Theme->getIcon('copy'),
            'tooltip' => __d('vamshop', 'Create a copy'),
            'rowAction' => 'copy',
        ], __d('vamshop', 'Create a copy of this Block?'));
    $actions[] = $this->Vamshop->adminRowAction('', '#Blocks' . $block->id . 'Id', [
            'icon' => $this->Theme->getIcon('delete'),
            'class' => 'delete',
            'tooltip' => __d('vamshop', 'Remove this item'),
            'rowAction' => 'delete',
        ], __d('vamshop', 'Are you sure?'));

    if ($chooser) {
        $checkbox = null;
        $actions = [
            $this->Vamshop->adminRowAction(__d('vamshop', 'Choose'), '#', [
                'class' => 'item-choose',
                'data-chooser-type' => 'Block',
                'data-chooser-id' => $block->id,
                'data-chooser-title' => $block->title,
            ]),
        ];
    } else {
        $checkbox = $this->Form->checkbox('Blocks.' . $block->id . '.id', [
            'class' => 'row-select',
            'id' => 'Blocks' . $block->id . 'Id',
        ]);
    }

    $actions = $this->Html->div('item-actions', implode(' ', $actions));
    $title = $this->Html->link($block->title, [
        'action' => 'edit',
        $block->id,
    ]);

    if ($block->status == Status::PREVIEW) {
        $title .= ' ' . $this->Html->tag('span', __d('vamshop', 'preview'), ['class' => 'label label-warning']);
    }

    $rows[] = [
        $checkbox,
        $title,
        $block->alias,
        $block->region->title,
        $block->updated,
        $this->element('Vamshop/Core.admin/toggle', [
            'id' => $block->id,
            'status' => (int)$block->status,
        ]),
        $actions,
    ];
}

echo $this->Html->tableCells($rows);
?>
    </table>
<?php
$this->end();
if (!$chooser):
    $this->start('bulk-action');
    echo $this->Form->input('action', [
        'label' => __d('vamshop', 'Bulk action'),
        'class' => 'c-select',
        'options' => [
            'publish' => __d('vamshop', 'Publish'),
            'unpublish' => __d('vamshop', 'Unpublish'),
            'delete' => __d('vamshop', 'Delete'),
            'copy' => __d('vamshop', 'Copy'),
        ],
        'empty' => __d('vamshop', 'Bulk action'),
    ]);
    echo $this->Form->button(__d('vamshop', 'Submit'), [
        'type' => 'submit',
        'value' => 'submit',
        'class' => 'btn-primary-ouline'
    ]);
    $this->end();
endif;
