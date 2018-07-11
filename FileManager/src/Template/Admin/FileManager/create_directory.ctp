<?php

use Cake\Routing\Router;

$this->assign('title', __d('vamshop', 'Create Directory'));
$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'File Manager'),
    ['plugin' => 'Vamshop/FileManager', 'controller' => 'fileManager', 'action' => 'browse'])
    ->add(__d('vamshop', 'Create Directory'), $this->request->getRequestTarget());

$this->append('form-start', $this->Form->create(null));

$this->start('page-heading');
echo $this->element('Vamshop/FileManager.admin/breadcrumbs');
$this->end();

$this->start('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Directory'), '#filemanager-createdir');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('filemanager-createdir') . $this->Form->input('name', [
        'type' => 'text',
        'label' => __d('vamshop', 'Directory name'),
        'prepend' => $path,
    ]);
echo $this->Html->tabEnd();
$this->end();

$this->start('panels');
echo $this->Html->beginBox(__d('vamshop', 'Publishing'));
echo $this->element('Vamshop/Core.admin/buttons', [
    'saveText' => __d('vamshop', 'Create directory'),
    'applyText' => false,
]);
echo $this->Html->endBox();

echo $this->Vamshop->adminBoxes();
$this->end();
