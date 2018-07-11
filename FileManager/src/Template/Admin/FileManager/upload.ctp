<?php

$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'File Manager'),
    ['plugin' => 'Vamshop/FileManager', 'controller' => 'fileManager', 'action' => 'browse'])
    ->add(__d('vamshop', 'Upload'), $this->request->getRequestTarget());

$this->start('page-heading');
echo $this->element('Vamshop/FileManager.admin/breadcrumbs');
$this->end();

$this->append('form-start', $this->Form->create(null, [
    'type' => 'file'
]));

$this->append('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Upload'), '#filemanager-upload');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('filemanager-upload');
echo $this->Form->input('file', [
    'type' => 'file',
    'label' => '',
    'class' => 'file'
]);
echo $this->Html->tabEnd();

$this->end();

$this->append('panels');
echo $this->Html->beginBox(__d('vamshop', 'Publishing'));
echo $this->element('Vamshop/Core.admin/buttons', [
    'saveText' => __d('vamshop', 'Upload file'),
    'applyText' => false,
]);
echo $this->Html->endBox();

echo $this->Vamshop->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());
