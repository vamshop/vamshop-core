<?php

use Vamshop\Core\Status;

$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'Menus'), ['action' => 'index']);

if ($this->request->params['action'] == 'edit') {
    $this->Breadcrumbs->add($menu->title, $this->request->getRequestTarget());

    $this->assign('title', __d('vamshop', 'Edit Menu'));
}

if ($this->request->params['action'] == 'add') {
    $this->Breadcrumbs->add(__d('vamshop', 'Add'), $this->request->getRequestTarget());

    $this->assign('title', __d('vamshop', 'Add Menu'));
}

$this->append('form-start', $this->Form->create($menu));

$this->append('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Menu'), '#menu-basic');
echo $this->Vamshop->adminTab(__d('vamshop', 'Misc.'), '#menu-misc');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('menu-basic');
echo $this->Form->input('title', [
    'label' => __d('vamshop', 'Title'),
    'data-slug' => '#alias'
]);
echo $this->Form->input('alias', [
    'label' => __d('vamshop', 'Alias'),
]);
echo $this->Form->input('description', [
    'label' => __d('vamshop', 'Description'),
]);
echo $this->Html->tabEnd();
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('menu-misc');
echo $this->Form->input('params', [
    'label' => __d('vamshop', 'Params'),
]);
echo $this->Html->tabEnd();

$this->end();

$this->start('panels');
echo $this->Html->beginBox('Publishing');
echo $this->element('Vamshop/Core.admin/buttons', ['type' => 'menu']);
echo $this->element('Vamshop/Core.admin/publishable');
echo $this->Html->endBox();
$this->end();
