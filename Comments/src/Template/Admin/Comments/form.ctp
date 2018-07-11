<?php

$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs
    ->add(__d('vamshop', 'Comments'), ['action' => 'index']);

$this->append('form-start', $this->Form->create($comment));

$this->append('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Comment'), '#comment-main');

$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('comment-main') . $this->Form->input('id') . $this->Form->input('title', [
        'label' => __d('vamshop', 'Title'),
    ]) . $this->Form->input('body', [
        'label' => __d('vamshop', 'Body'),
    ]);
echo $this->Html->tabEnd();
$this->end();

$this->start('panels');
echo $this->Html->beginBox(__d('vamshop', 'Publishing'));
echo $this->element('Vamshop/Core.admin/buttons', ['type' => 'comments']);
echo $this->Html->endBox();

echo $this->Html->beginBox(__d('vamshop', 'Contact'));
echo $this->Form->input('name', ['label' => __d('vamshop', 'Name')]);
echo $this->Form->input('email', ['label' => __d('vamshop', 'Email')]);
echo $this->Form->input('website', ['label' => __d('vamshop', 'Website')]);
echo $this->Form->input('ip', [
    'disabled' => 'disabled',
    'label' => __d('vamshop', 'Ip'),
]);
echo $this->Html->endBox();

$this->end();
