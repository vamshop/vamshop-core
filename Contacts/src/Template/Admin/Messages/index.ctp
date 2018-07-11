<?php

$this->Vamshop->adminScript('Vamshop/Contacts.admin');

$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('vamshop', 'Contacts'), ['controller' => 'contacts', 'action' => 'index']);

$status = $this->request->query('status');

if (isset($status)) {
    $this->Breadcrumbs->add(__d('vamshop', 'Messages'), ['action' => 'index']);
    if ($status == '1') {
        $this->Breadcrumbs->add(__d('vamshop', 'Read'), $this->request->getUri()->getPath());
        $this->assign('title', __d('vamshop', 'Messages: Read'));
    } else {
        $this->Breadcrumbs->add(__d('vamshop', 'Unread'), $this->request->getUri()->getPath());
        $this->assign('title', __d('vamshop', 'Messages: Unread'));
    }
} else {
    $this->Breadcrumbs->add(__d('vamshop', 'Messages'), $this->request->getUri()->getPath());
}

$this->append('table-footer', $this->element('admin/modal', [
        'id' => 'comment-modal',
    ]));

$this->append('action-buttons');
echo $this->Vamshop->adminAction(__d('vamshop', 'Unread'), [
    'action' => 'index',
    '?' => [
        'status' => '0',
    ],
]);
echo $this->Vamshop->adminAction(__d('vamshop', 'Read'), [
    'action' => 'index',
    '?' => [
        'status' => '1',
    ],
]);
$this->end();

$this->append('form-start', $this->Form->create(null, [
    'url' => ['action' => 'process'],
    'align' => 'inline',
]));

$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders([
    $this->Form->checkbox('checkAll', ['id' => 'MessagesCheckAll']),
    $this->Paginator->sort('contact_id', __d('vamshop', 'Contact')),
    $this->Paginator->sort('name', __d('vamshop', 'Name')),
    $this->Paginator->sort('email', __d('vamshop', 'Email')),
    $this->Paginator->sort('title', __d('vamshop', 'Title')),
    $this->Paginator->sort('created', __d('vamshop', 'Created')),
    __d('vamshop', 'Actions'),
]);
echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
$commentIcon = $this->Html->icon($this->Theme->getIcon('comment'));
$rows = [];
foreach ($messages as $message) {
    $actions = [];

    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'view', $message->id],
        ['icon' => $this->Theme->geticon('read'), 'tooltip' => __d('vamshop', 'View this item')]);
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'edit', $message->id],
        ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('vamshop', 'Edit this item')]);
    $actions[] = $this->Vamshop->adminRowAction('', '#Message' . $message->id . 'Id', [
        'icon' => $this->Theme->getIcon('delete'),
        'class' => 'delete',
        'tooltip' => __d('vamshop', 'Remove this item'),
        'rowAction' => 'delete',
    ], __d('vamshop', 'Are you sure?'));
    $actions[] = $this->Vamshop->adminRowActions($message->id);

    $actions = $this->Html->div('item-actions', implode(' ', $actions));

    $rows[] = [
        $this->Form->checkbox('Messages.' . $message->id . '.id', [
            'class' => 'row-select',
            'id' => 'Messages'. $message->id . 'Id',
        ]),
        $message->contact->title,
        $message->name,
        $message->email,
        $commentIcon . ' ' . $this->Html->link($message->title, '#', [
            'class' => 'comment-view',
            'data-target' => '#comment-modal',
            'data-title' => $message->title,
            'data-content' => $message->body,
        ]),
        $this->Time->i18nFormat($message->created),
        $actions,
    ];
}
echo $this->Html->tableCells($rows);
$this->end();

$this->start('bulk-action');
echo $this->Form->input('action', [
    'label' => __d('vamshop', 'Bulk action'),
    'class' => 'c-select',
    'options' => [
        'read' => __d('vamshop', 'Mark as read'),
        'unread' => __d('vamshop', 'Mark as unread'),
        'delete' => __d('vamshop', 'Delete'),
    ],
    'empty' => __d('vamshop', 'Bulk action'),
]);
echo $this->Form->button(__d('vamshop', 'Apply'), [
    'type' => 'submit',
    'value' => 'submit',
    'class' => 'bulk-process btn-outline-primary',
]);
$this->end();
