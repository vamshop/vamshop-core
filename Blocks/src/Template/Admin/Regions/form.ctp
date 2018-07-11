<?php

$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'Blocks'), [
        'controller' => 'blocks',
        'action' => 'index',
    ])
    ->add(__d('vamshop', 'Regions'), [
        'controller' => 'regions',
        'action' => 'index',
    ]);

if ($this->request->params['action'] == 'edit') {
    $this->Breadcrumbs->add($region->title, $this->request->getRequestTarget());
}

if ($this->request->params['action'] == 'add') {
    $this->Breadcrumbs->add(__d('vamshop', 'Add'), $this->request->getRequestTarget());
}

$this->append('form-start', $this->Form->create($region));

$this->append('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Region'), '#region-main');
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('region-main') . $this->Form->input('title', [
        'label' => __d('vamshop', 'Title'),
        'data-slug' => '#alias'
    ]) . $this->Form->input('alias', [
        'label' => __d('vamshop', 'Alias'),
    ]);
echo $this->Html->tabEnd();
$this->end();
