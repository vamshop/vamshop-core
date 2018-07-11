<?php
$this->extend('Vamshop/Core./Common/admin_edit');
$this->Breadcrumbs
    ->add(__d('vamshop', 'Users'), ['plugin' => 'Vamshop/Users', 'controller' => 'Users', 'action' => 'index'])
    ->add(__d('vamshop', 'Roles'), ['plugin' => 'Vamshop/Users', 'controller' => 'Roles', 'action' => 'index']);

if ($this->request->param('action') == 'edit') {
    $this->Breadcrumbs->add($role->title, $this->request->getRequestTarget());
}

if ($this->request->param('action') == 'add') {
    $this->Breadcrumbs->add(__d('vamshop', 'Add'), $this->request->getRequestTarget());
}

$this->assign('form-start', $this->Form->create($role));

$this->start('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Role'), '#role-main');
$this->end();

$this->start('tab-content');
echo $this->Html->tabStart('role-main');
echo $this->Form->input('title', [
    'label' => __d('vamshop', 'Title'),
    'data-slug' => '#alias'
]);
echo $this->Form->input('alias', [
    'label' => __d('vamshop', 'Alias'),
]);
echo $this->Html->tabEnd();
$this->end();
