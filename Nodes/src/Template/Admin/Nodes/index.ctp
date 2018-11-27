<?php

use Cake\Utility\Hash;
use Vamshop\Core\Status;

echo var_dump($_SESSION['Flash']['flash'][0]);

$this->assign('title', __d('vamshop', 'Contents'));

$this->extend('Vamshop/Core./Common/admin_index');

$this->Vamshop->adminScript('Vamshop/Nodes.admin');

$this->Breadcrumbs
    ->add(__d('vamshop', 'Content'), $this->request->getUri()->getPath());

$this->append('action-buttons');
echo $this->Vamshop->adminAction(__d('vamshop', 'Create content'), ['action' => 'create'], ['button' => 'success']);
$this->end();

$this->append('search', $this->element('admin/nodes_search'));

$this->append('form-start', $this->Form->create(null, [
    'url' => ['action' => 'process'],
    'align' => 'inline',
]));

$this->start('table-heading');
echo $this->Html->tableHeaders([
    $this->Form->checkbox('checkAll', ['id' => 'NodesCheckAll']),
    $this->Paginator->sort('title', __d('vamshop', 'Title')),
    $this->Paginator->sort('type', __d('vamshop', 'Type')),
    $this->Paginator->sort('user_id', __d('vamshop', 'User')),
    $this->Paginator->sort('updated', __d('vamshop', 'Updated')),
    $this->Paginator->sort('status', __d('vamshop', 'Status')),
    '',
]);
$this->end();

$this->append('table-body');
?>
    <?php foreach ($nodes as $node): ?>
        <tr>
            <td><?= $this->Form->checkbox('Nodes.' . $node->id . '.id',
                    ['class' => 'row-select', 'id' => 'Nodes' . $node->id . 'Id']) ?></td>
            <td>
                <span>
                <?php
                echo $this->Html->link($this->Text->truncate($node->title, 40),
                    Hash::merge($node->url->getArrayCopy(), [
                        'prefix' => false,
                    ]),
                    ['target' => '_blank', 'title' => $node->title]
                );
                ?>
                </span>

                <?php if ($node->promote == 1): ?>
                    <span class="badge badge-info"><?= __d('vamshop', 'promoted') ?></span>
                <?php endif ?>

                <?php if ($node->status == Status::PREVIEW): ?>
                    <span class="badge badge-warning"><?= __d('vamshop', 'preview') ?></span>
                <?php endif ?>
            </td>
            <td>
                <?php
                echo $this->Html->link($node->type, [
                    'action' => 'index',
                    '?' => [
                        'type' => $node->type,
                    ],
                ]);
                ?>
            </td>
            <td>
                <?= $node->user->username ?>
            </td>
            <td>
                <?= $this->Time->i18nFormat($node->updated) ?>
            </td>
            <td>
                <?php
                echo $this->element('Vamshop/Core.admin/toggle', [
                    'id' => $node->id,
                    'status' => (int)$node->status,
                ]);
                ?>
            </td>
            <td>
                <div class="item-actions">
                    <?php
                    echo $this->Vamshop->adminRowActions($node->id);

                    if ($this->request->query('type')):
                        echo ' ' . $this->Vamshop->adminRowAction('', ['action' => 'move', $node->id, 'up'], [
                                'method' => 'post',
                                'icon' => $this->Theme->getIcon('move-up'),
                                'tooltip' => __d('vamshop', 'Move up'),
                            ]);
                        echo ' ' . $this->Vamshop->adminRowAction('', ['action' => 'move', $node->id, 'down'], [
                                'method' => 'post',
                                'icon' => $this->Theme->getIcon('move-down'),
                                'tooltip' => __d('vamshop', 'Move down'),
                            ]);
                    endif;

                    echo ' ' . $this->Vamshop->adminRowAction('', ['action' => 'edit', $node->id], [
                            'icon' => $this->Theme->getIcon('update'),
                            'tooltip' => __d('vamshop', 'Edit this item'),
                        ]);
                    echo ' ' . $this->Vamshop->adminRowAction('', '#Nodes' . $node->id . 'Id', [
                            'icon' => $this->Theme->getIcon('copy'),
                            'tooltip' => __d('vamshop', 'Create a copy'),
                            'rowAction' => 'copy',
                        ]);
                    echo ' ' . $this->Vamshop->adminRowAction('', '#Nodes' . $node->id . 'Id', [
                            'icon' => $this->Theme->getIcon('delete'),
                            'class' => 'delete',
                            'tooltip' => __d('vamshop', 'Remove this item'),
                            'rowAction' => 'delete',
                        ], __d('vamshop', 'Are you sure?'));
                    ?>
                </div>
            </td>
        </tr>
    <?php endforeach ?>
<?php
$this->end();

$this->start('bulk-action');
echo $this->Form->input('action', [
    'label' => __d('vamshop', 'Bulk actions'),
    'class' => 'c-select',
    'options' => [
        'publish' => __d('vamshop', 'Publish'),
        'unpublish' => __d('vamshop', 'Unpublish'),
        'promote' => __d('vamshop', 'Promote'),
        'unpromote' => __d('vamshop', 'Unpromote'),
        'delete' => __d('vamshop', 'Delete'),
        [
            'value' => 'copy',
            'text' => __d('vamshop', 'Copy'),
            'hidden' => true,
        ],
    ],
    'empty' => __d('vamshop', 'Bulk actions'),
]);

$jsVarName = uniqid('confirmMessage_');
echo $this->Form->button(__d('vamshop', 'Apply'), [
    'type' => 'button',
    'class' => 'bulk-process btn-outline-primary',
    'data-relatedElement' => '#action',
    'data-confirmMessage' => $jsVarName,
    'escape' => true,
]);

$this->Js->set($jsVarName, __d('vamshop', '%s selected items?'));
$this->Js->buffer("$('.bulk-process').on('click', Nodes.confirmProcess);");

$this->end();
