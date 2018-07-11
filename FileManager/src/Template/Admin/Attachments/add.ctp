<?php

$this->assign('title', __d('vamshop', 'Add Attachment'));
$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'Attachments'),
        ['plugin' => 'Vamshop/FileManager', 'controller' => 'attachments', 'action' => 'index'])
    ->add(__d('vamshop', 'Upload'), $this->request->getRequestTarget());

$this->append('form-start', $this->Form->create($attachment, [
    'type' => 'file',
]));

$this->append('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Upload'), '#attachment-upload');
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
echo $this->Html->beginBox(__d('vamshop', 'Publishing'));
echo $this->element('Vamshop/Core.admin/buttons', [
    'saveText' => __d('vamshop', 'Upload file'),
    'applyText' => false,
]);
echo $this->Html->endBox();
$this->end();
