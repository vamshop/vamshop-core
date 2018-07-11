<?php

$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'Settings'),
    ['plugin' => 'Vamshop/Settings', 'controller' => 'settings', 'action' => 'prefix', 'Site'])
    ->add(__d('vamshop', 'Language'),
        ['plugin' => 'Vamshop/Settings', 'controller' => 'languages', 'action' => 'index']);

if ($this->request->params['action'] == 'edit') {
    $this->Breadcrumbs->add($language->title);
}

if ($this->request->params['action'] == 'add') {
    $this->Breadcrumbs->add(__d('vamshop', 'Add'), $this->request->getRequestTarget());
}

$this->append('form-start', $this->Form->create($language));

$this->start('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Language'), '#language-main');
$this->end();

$this->start('tab-content');
echo $this->Html->tabStart('language-main');
echo $this->Form->input('title', [
    'label' => __d('vamshop', 'Title'),
]);
echo $this->Form->input('native', [
    'label' => __d('vamshop', 'Native'),
]);
echo $this->Form->input('locale', [
    'label' => __d('vamshop', 'Locale'),
]);
echo $this->Form->input('alias', [
    'label' => __d('vamshop', 'Alias'),
    'help' => __d('vamshop', 'Locale alias, typically a two letter country/locale code'),
]);
echo $this->Html->tabEnd();
$this->end();

$this->start('panels');
echo $this->Html->beginBox(__d('vamshop', 'Publishing'));
echo $this->element('Vamshop/Core.admin/buttons', ['type' => 'language']);
echo $this->Form->input('status', [
    'label' => __d('vamshop', 'Status'),
]);
echo $this->Html->endBox();
$this->end();
