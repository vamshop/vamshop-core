<?php

$this->assign('title', __d('croogo', 'Add Attachment'));
$this->extend('Croogo/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('croogo', 'Attachments'),
        ['plugin' => 'Croogo/FileManager', 'controller' => 'attachments', 'action' => 'index'])
    ->add(__d('croogo', 'Upload'), $this->request->getRequestTarget());

$this->append('form-start', $this->Form->create($attachment, [
    'type' => 'file',
]));

$this->append('tab-heading');
echo $this->Croogo->adminTab(__d('croogo', 'Upload'), '#attachment-upload');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('attachment-upload');
echo $this->Form->input('file', [
        'type' => 'file',
        'label' => false,
    ]);
echo $this->Html->tabEnd();

$this->end();

$this->start('buttons');
echo $this->Html->beginBox(__d('croogo', 'Publishing'));
echo $this->element('Croogo/Core.admin/buttons', [
    'saveText' => __d('croogo', 'Upload file'),
    'applyText' => false,
]);
echo $this->Html->endBox();
$this->end();
