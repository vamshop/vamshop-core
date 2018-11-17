<?php
$this->extend('Vamshop/Core./Common/admin_edit');

$this->assign('title', __d('vamshop', 'Settings'));

$this->Breadcrumbs
    ->add(__d('vamshop', 'Settings'), [
        'plugin' => 'Vamshop/Settings',
        'controller' => 'Settings',
        'action' => 'index',
    ]);

if ($this->request->param('action') == 'edit') {
    $this->Breadcrumbs->add($setting->key, $this->request->getRequestTarget());
}

if ($this->request->param('action') == 'add') {
    $this->Breadcrumbs->add(__d('vamshop', 'Add'), $this->request->getRequestTarget());
}

$this->append('form-start', $this->Form->create($setting, [
    'class' => 'protected-form',
]));

$this->start('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Settings'), '#setting-basic');
echo $this->Vamshop->adminTab(__d('vamshop', 'Misc'), '#setting-misc');
$this->end();

$this->start('tab-content');
echo $this->Html->tabStart('setting-basic') . $this->Form->input('key', [
        'help' => __d('vamshop', "e.g., 'Site.title'"),
        'label' => __d('vamshop', 'Key'),
    ]) . $this->Form->input('value', [
        'label' => __d('vamshop', 'Value'),
    ]) . $this->Html->tabEnd();

echo $this->Html->tabStart('setting-misc') . $this->Form->input('title', [
        'label' => __d('vamshop', 'Title'),
    ]) . $this->Form->input('description', [
        'label' => __d('vamshop', 'Description'),
    ]) . $this->Form->input('input_type', [
        'label' => __d('vamshop', 'Input Type'),
        'help' => __d('vamshop', "e.g., 'text' or 'textarea'"),
    ]) . $this->Form->input('editable', [
        'label' => __d('vamshop', 'Editable'),
    ]) . $this->Form->input('params', [
        'label' => __d('vamshop', 'Params'),
    ]) . $this->Html->tabEnd();

$this->end();
