<?php

$this->assign('title', __d('croogo', 'Create File'));
$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('croogo', 'File Manager'),
        ['plugin' => 'Vamshop/FileManager', 'controller' => 'FileManager', 'action' => 'browse'])
    ->add(__d('croogo', 'Create File'), $this->request->getRequestTarget());

$this->start('page-heading');
echo $this->element('Vamshop/FileManager.admin/breadcrumbs');
$this->end();

$this->append('form-start', $this->Form->create(null));

$this->append('tab-heading');
echo $this->Vamshop->adminTab(__d('croogo', 'File'), '#filemanager-createfile');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('filemanager-createfile');
echo $this->Form->input('name', [
        'type' => 'text',
        'label' => __d('croogo', 'Filename'),
        'prepend' => $path,
    ]);
echo $this->Form->input('content', [
    'type' => 'textarea',
    'label' => __d('croogo', 'Content')
]);
echo $this->Html->tabEnd();
$this->end();

$this->append('panels');
echo $this->Html->beginBox(__d('croogo', 'Publishing'));
echo $this->element('Vamshop/Core.admin/buttons', [
    'saveText' => __d('croogo', 'Create file'),
    'applyText' => false,
]);
echo $this->Html->endBox();
$this->end();
