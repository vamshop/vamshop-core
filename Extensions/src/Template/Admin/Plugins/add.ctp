<?php

$this->extend('/Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'Extensions'), $this->request->getRequestTarget())
    ->add(__d('vamshop', 'Plugins'),
        ['plugin' => 'Vamshop/Extensions', 'controller' => 'Plugins', 'action' => 'index'])
    ->add(__d('vamshop', 'Upload'), $this->request->getRequestTarget());

$this->append('form-start', $this->Form->create(null, [
    'url' => [
        'plugin' => 'Vamshop/Extensions',
        'controller' => 'Plugins',
        'action' => 'add',
    ],
    'type' => 'file',
]));

$this->append('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Upload'), '#plugins-upload');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('plugins-upload') . $this->Form->input('Plugin.file', [
        'type' => 'file',
        'class' => 'c-file'
    ]);
echo $this->Html->tabEnd();
$this->end();

$this->append('panels');
echo $this->Html->beginBox(__d('vamshop', 'Publishing')) .
    '<div class="clearfix"><div class="float-left">' .
    $this->Form->button(__d('vamshop', 'Upload'), ['button' => 'success']) .
    '</div><div class="float-right">' .
    $this->Html->link(__d('vamshop', 'Cancel'), ['action' => 'index'], ['button' => 'danger']) .
    '</div></div>';
echo $this->Html->endBox();
$this->end();

$this->append('form-end', $this->Form->end());
