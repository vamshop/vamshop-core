<?php
$this->Vamshop->adminScript('Vamshop/Taxonomy.vocabularies');

$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'Content'),
    ['plugin' => 'Vamshop/Nodes', 'controller' => 'Nodes', 'action' => 'index']);

if ($this->request->params['action'] == 'edit') {
    $this->assign('title', __d('vamshop', 'Edit Vocabulary'));

    $this->Breadcrumbs->add(__d('vamshop', 'Vocabularies'), ['action' => 'index', $vocabulary->id])
        ->add($vocabulary->title);
}

if ($this->request->params['action'] == 'add') {
    $this->assign('title', __d('vamshop', 'Add Vocabulary'));

    $this->Breadcrumbs->add(__d('vamshop', 'Vocabularies'), ['action' => 'index'])
        ->add(__d('vamshop', 'Add'), $this->request->getRequestTarget());
}

$this->append('form-start', $this->Form->create($vocabulary, [
    'class' => 'protected-form',
]));

$this->start('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Vocabulary'), '#vocabulary-basic');
$this->end();

$this->start('tab-content');
echo $this->Html->tabStart('vocabulary-basic');
echo $this->Form->input('title', [
    'label' => __d('vamshop', 'Title'),
    'data-slug' => '#alias',
]);
echo $this->Form->input('alias', [
    'label' => __d('vamshop', 'Alias'),
    'class' => 'slug',
]);
echo $this->Form->input('description', [
    'label' => __d('vamshop', 'Description'),
]);
echo $this->Form->input('types._ids', [
    'label' => __d('vamshop', 'Content types'),
    'class' => 'c-select',
    'help' => __d('vamshop', 'Select which content types will use this vocabulary')
]);
echo $this->Html->tabEnd();
$this->end();

$this->start('panels');
echo $this->Html->beginBox();
echo $this->element('Vamshop/Core.admin/buttons', ['type' => __d('vamshop', 'vocabulary')]);
echo $this->Html->endBox();

echo $this->Html->beginBox(__d('vamshop', 'Options'));
echo $this->Form->input('required', [
    'label' => __d('vamshop', 'Required'),
    'class' => false,
    'help' => __d('vamshop', 'Required to select a term from the vocabulary.'),
]);
echo $this->Form->input('multiple', [
    'label' => __d('vamshop', 'Multiple selections'),
    'class' => false,
    'help' => __d('vamshop', 'Allow multiple terms to be selected.'),
]);
echo $this->Form->input('tags', [
    'label' => __d('vamshop', 'Freetags'),
    'class' => false,
    'help' => __d('vamshop', 'Allow free-typing of terms/tags.'),
]);
echo $this->Html->endBox();
$this->end();
