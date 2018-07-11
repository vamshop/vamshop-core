<?php

$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'File Manager'),
    ['plugin' => 'Vamshop/FileManager', 'controller' => 'fileManager', 'action' => 'browse'])
    ->add(__d('vamshop', 'Rename'), $this->request->getRequestTarget());

$this->start('page-heading');
echo $this->element('Vamshop/FileManager.admin/breadcrumbs');
$this->end();

$this->append('form-start', $this->Form->create(null));

$this->append('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'File'), '#filemanager-rename');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('filemanager-rename');
echo $this->Form->input('name', [
    'type' => 'text',
    'label' => __d('vamshop', 'New name'),
]);
echo $this->Html->tabEnd();

$this->end();

$this->append('panels');
echo $this->Html->beginBox(__d('vamshop', 'Publishing'));
echo $this->element('Vamshop/Core.admin/buttons', [
    'saveText' => __d('vamshop', 'Rename file'),
    'applyText' => false,
]);
echo $this->Html->endBox();
$this->end();
