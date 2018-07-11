<?php

use Vamshop\Core\Status;

$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'Blocks'), ['action' => 'index']);

if ($this->request->params['action'] == 'edit') {
    $this->Breadcrumbs->add($block->title, $this->request->getRequestTarget());
}
if ($this->request->params['action'] == 'add') {
    $this->Breadcrumbs->add(__d('vamshop', 'Add'), $this->request->getRequestTarget());
}

$this->append('form-start', $this->Form->create($block, [
    'class' => 'protected-form',
]));

$this->append('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Block'), '#block-basic');
echo $this->Vamshop->adminTab(__d('vamshop', 'Visibilities'), '#block-visibilities');
echo $this->Vamshop->adminTab(__d('vamshop', 'Params'), '#block-params');
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('block-basic') . $this->Form->input('title', [
        'label' => __d('vamshop', 'Title'),
        'data-slug' => '#alias',
    ]) . $this->Form->input('alias', [
        'label' => __d('vamshop', 'Alias'),
        'help' => __d('vamshop', 'unique name for your block'),
    ]) . $this->Form->input('region_id', [
        'label' => __d('vamshop', 'Region'),
        'help' => __d('vamshop', 'if you are not sure, choose \'none\''),
        'class' => 'c-select',
    ]) . $this->Form->input('body', [
        'label' => __d('vamshop', 'Body'),
    ]) . $this->Form->input('class', [
        'label' => __d('vamshop', 'Class'),
    ]) . $this->Form->input('element', [
        'label' => __d('vamshop', 'Element'),
    ]) . $this->Form->input('cell', [
        'label' => __d('vamshop', 'Cell'),
    ]);
echo $this->Html->tabEnd();

echo $this->Html->tabStart('block-visibilities') . $this->Form->input('visibility_paths', [
        'type' => 'stringlist',
        'label' => __d('vamshop', 'Visibility Paths'),
        'help' => __d('vamshop', 'Enter one URL per line. Leave blank if you want this Block to appear in all pages.'),
    ]);
echo $this->Html->tabEnd();

echo $this->Html->tabStart('block-params') . $this->Form->input('params', [
        'type' => 'stringlist',
        'label' => __d('vamshop', 'Params'),
    ]);
echo $this->Html->tabEnd();

$this->end();

$this->append('panels');
echo $this->Html->beginBox(__d('vamshop', 'Publishing'));
echo $this->element('Vamshop/Core.admin/buttons', ['type' => 'block']);
echo $this->element('Vamshop/Core.admin/publishable');
echo $this->Form->input('show_title', [
    'label' => __d('vamshop', 'Show title ?'),
]);
echo $this->Html->endBox();

echo $this->Html->beginBox(__d('vamshop', 'Access control'));
echo $this->Form->input('visibility_roles', [
    'class' => 'c-select',
    'options' => $roles,
    'multiple' => true,
    'label' => false,
]);
echo $this->Html->endBox();

echo $this->Vamshop->adminBoxes();
$this->end();
