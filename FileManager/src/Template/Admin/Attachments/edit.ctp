<?php

$this->assign('title', __d('vamshop', 'Edit Attachment'));
$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'Attachments'),
        ['plugin' => 'Vamshop/FileManager', 'controller' => 'attachments', 'action' => 'index'])
    ->add($attachment->title, $this->request->getRequestTarget());

$this->append('form-start', $this->Form->create($attachment));

$this->append('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Attachment'), '#attachment-main');
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('attachment-main') . $this->Form->input('title', [
        'label' => __d('vamshop', 'Title'),
    ]) . $this->Form->input('excerpt', [
        'label' => __d('vamshop', 'Caption'),
    ]) . $this->Form->input('file_url', [
        'label' => __d('vamshop', 'File URL'),
        'value' => $this->Url->build($attachment->path, true),
        'readonly' => 'readonly',
    ]) . $this->Form->input('file_type', [
            'label' => __d('vamshop', 'Mime Type'),
            'value' => $attachment->mime_type,
            'readonly' => 'readonly',
        ]);
echo $this->Html->tabEnd();
$this->end();

$this->append('panels');
$redirect = ['action' => 'index'];
$session = $this->request->session();
if ($session->check('Wysiwyg.redirect')) {
    $redirect = $session->read('Wysiwyg.redirect');
}
echo $this->Html->beginBox(__d('vamshop', 'Publishing'));
    echo $this->element('Vamshop/Core.admin/buttons', ['cancelUrl' => $redirect]);
echo $this->Html->endBox();

$fileType = explode('/', $attachment->mime_type);
$fileType = $fileType['0'];
if ($fileType == 'image'):
    $imgUrl = $this->Image->resize('/uploads/' . $attachment->slug, 200, 300, true);
else:
    $imgUrl = $this->Html->thumbnail('Vamshop/Core./img/icons/' .
        $this->Filemanager->mimeTypeToImage($attachment->mime_type)) .
        ' ' . $attachment->mime_type;
endif;
$preview = $this->Html->link($imgUrl, $attachment->path, [
    'data-toggle' => 'lightbox',
]);
echo $this->Html->beginBox(__d('vamshop', 'Preview')) . $preview;
echo $this->Html->endBox();

$this->end();
