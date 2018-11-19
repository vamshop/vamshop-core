<?php
/**
 * @var \Vamshop\Core\View\VamshopView $this
 */

$this->assign('title', __d('vamshop', 'Attachments'));
$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('vamshop', 'Attachments'), $this->request->getUri()->getPath());

$this->Vamshop->adminScript('Vamshop/FileManager.admin');
$this->Html->script([
    'Vamshop/FileManager.lib/dropzone',
    'Vamshop/FileManager.attachments/index'
], ['block' => 'scriptBottom']);

$this->start('body-footer');
    echo $this->element('Vamshop/FileManager.admin/dropzone_setup', ['type' => 'table']);
$this->end();

$this->append('form-start', $this->Form->create(null, [
    'url' => ['action' => 'process'],
    'align' => 'inline',
]));

$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders([
    $this->Form->checkbox('checkAll', ['id' => 'AttachmentsCheckAll']),
    $this->Paginator->sort('id', __d('vamshop', 'Id')),
    '&nbsp;',
    $this->Paginator->sort('title', __d('vamshop', 'Title')),
    __d('vamshop', 'URL'),
    __d('vamshop', 'Actions'),
]);
echo $tableHeaders;
$this->end();

$this->append('table-body');
$rows = [];
foreach ($attachments as $attachment) {
    $actions = [];
    $actions[] = $this->Vamshop->adminRowActions($attachment->id);
    $actions[] = $this->Vamshop->adminRowAction('', ['controller' => 'Attachments', 'action' => 'edit', $attachment->id],
        ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('vamshop', 'Edit this item')]);
    $actions[] = $this->Vamshop->adminRowAction('',
        ['controller' => 'attachments', 'action' => 'delete', $attachment->id],
        [
            'icon' => $this->Theme->getIcon('delete'),
            'tooltip' => __d('vamshop', 'Remove this item'),
            'method' => 'post',
        ],
        __d('vamshop', 'Are you sure?'));

    $mimeType = explode('/', $attachment->mime_type);
    $imageType = $mimeType['1'];
    $mimeType = $mimeType['0'];
    $imagecreatefrom = ['gif', 'jpeg', 'png', 'string', 'wbmp', 'webp', 'xbm', 'xpm'];
    if ($mimeType == 'image' && in_array($imageType, $imagecreatefrom)) {
        $imgUrl = $this->Image->resize('/uploads/' . $attachment->slug, 200, 100, true, ['alt' => $attachment->title]);
        $thumbnail = $this->Html->link($imgUrl, $attachment->path, [
            'escape' => false,
            'class' => 'img-thumbnail',
            'title' => $attachment->title,
            'data-toggle' => 'lightbox',
        ]);
    } else {
        $thumbnail = $this->Html->thumbnail('/vamshop/core/img/icons/page_white.png', ['alt' => $attachment->mime_type]) .
            ' ' .
            $attachment->mime_type .
            ' (' .
            $this->Filemanager->filename2ext($attachment->slug) .
            ')';
    }

    $actions = $this->Html->div('item-actions', implode(' ', $actions));

    $rows[] = [
        $this->Form->checkbox('Attachments.' . $attachment->id . '.id', ['class' => 'row-select']),
        $attachment->id,
        $thumbnail,
        $this->Html->tag('div', $attachment->title, ['class' => 'ellipsis']),
        $this->Html->tag('div',
            $this->Html->link($this->Url->build($attachment->path, true), $attachment->path, ['target' => '_blank']),
            ['class' => 'ellipsis']),
        $actions,
    ];
}
echo $this->Html->tableCells($rows);
$this->end();

$this->start('bulk-action');
echo $this->Form->input('action', [
    'label' => __d('vamshop', 'Bulk actions'),
    'class' => 'c-select',
    'options' => [
        'delete' => __d('vamshop', 'Delete'),
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
$this->Js->buffer("$('.bulk-process').on('click', Attachments.confirmProcess);");

$this->end();
