<?php

use Cake\Routing\Router;

$this->assign('title', __d('vamshop', 'Edit file: %s', $path));

$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'File Manager'),
        ['plugin' => 'Vamshop/FileManager', 'controller' => 'fileManager', 'action' => 'browse'])
    ->add(basename($absolutefilepath), $this->request->getRequestTarget());

$this->start('page-heading');
echo $this->element('Vamshop/FileManager.admin/breadcrumbs');
$this->end();

$this->append('form-start', $this->Form->create(null));

$this->append('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Edit'), '#filemanager-edit');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('filemanager-edit') . $this->Form->input('content', [
        'type' => 'textarea',
        'value' => $content,
        'label' => false,
    ]);
echo $this->Html->tabEnd();
$this->end();

$this->append('panels');
echo $this->Html->beginBox(__d('vamshop', 'Publishing'));
echo $this->element('Vamshop/Core.admin/buttons', [
    'applyText' => false,
]);
echo $this->Html->endBox();
$this->end();
