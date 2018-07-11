<?php

$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs
    ->add(__d('vamshop', 'Content'), ['plugin' => 'Vamshop/Nodes', 'controller' => 'Nodes', 'action' => 'index'])
    ->add(__d('vamshop', 'Types'), ['plugin' => 'Vamshop/Taxonomy', 'controller' => 'Types', 'action' => 'index']);

if ($this->request->params['action'] == 'edit') {
    $this->assign('title', __d('vamshop', 'Edit Type'));

    $this->Breadcrumbs->add($type->title, $this->request->getRequestTarget());
}

if ($this->request->params['action'] == 'add') {
    $this->Breadcrumbs->add(__d('vamshop', 'Add'), $this->request->getRequestTarget());
}

$this->append('form-start', $this->Form->create($type));

$this->start('tab-heading');
    echo $this->Vamshop->adminTab(__d('vamshop', 'Type'), '#type-main');
    echo $this->Vamshop->adminTab(__d('vamshop', 'Taxonomy'), '#type-taxonomy');
    echo $this->Vamshop->adminTab(__d('vamshop', 'Comments'), '#type-comments');
    echo $this->Vamshop->adminTab(__d('vamshop', 'Params'), '#type-params');
$this->end();

$this->start('tab-content');

    echo $this->Html->tabStart('type-main');
        echo $this->Form->input('title', [
            'label' => __d('vamshop', 'Title'),
            'data-slug' => '#alias',
        ]);
        echo $this->Form->input('alias', [
            'label' => __d('vamshop', 'Alias'),
            'label' => __d('vamshop', 'Permalink'),
            'prepend' => str_replace('_placeholder', '', $this->Url->build([
                'prefix' => false,
                'plugin' => 'Vamshop/Nodes',
                'controller' => 'Nodes',
                'action' => 'index',
                'type' => '_placeholder',
            ], ['fullbase' => true]))
        ]);
        echo $this->Form->input('description', [
            'label' => __d('vamshop', 'Description'),
        ]);
        echo $this->Html->tabEnd();
        echo $this->Html->tabStart('type-taxonomy');
        echo $this->Form->input('vocabularies._ids', [
            'class' => 'c-select',
            'multiple' => 'checkbox'
        ]);
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('type-comments');
        echo $this->Form->input('comment_status', [
            'type' => 'radio',
            'options' => [
                '0' => __d('vamshop', 'Disabled'),
                '1' => __d('vamshop', 'Read only'),
                '2' => __d('vamshop', 'Read/Write'),
            ],
            'default' => 2,
            'label' => __d('vamshop', 'Commenting'),
        ]);
        echo $this->Form->input('comment_approve', [
            'label' => 'Auto approve comments',
            'class' => false,
        ]);
        echo $this->Form->input('comment_spam_protection', [
            'label' => __d('vamshop', 'Spam protection (requires Akismet API key)'),
            'class' => false,
        ]);
        echo $this->Form->input('comment_captcha', [
            'label' => __d('vamshop', 'Use captcha? (requires Recaptcha API key)'),
            'class' => false,
        ]);
        echo $this->Html->link(__d('vamshop', 'You can manage your API keys here.'), [
            'plugin' => 'Vamshop/Settings',
            'controller' => 'Settings',
            'action' => 'prefix',
            'Service',
        ]);
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('type-params');
        echo $this->Form->input('params', [
            'type' => 'stringlist',
            'label' => __d('vamshop', 'Params'),
            'default' => 'routes=true',
        ]);
    echo $this->Html->tabEnd();

$this->end();

$this->start('panels');
echo $this->Html->beginBox(__d('vamshop', 'Publishing'));
    echo $this->element('Vamshop/Core.admin/buttons', ['type' => 'type']);
    echo $this->Form->input('format_show_author', [
        'label' => __d('vamshop', 'Show author\'s name'),
        'class' => false,
    ]);
    echo $this->Form->input('format_show_date', [
        'label' => __d('vamshop', 'Show date'),
        'class' => false,
    ]);
    echo $this->Form->input('format_use_wysiwyg', [
        'label' => __d('vamshop', 'Use rich editor'),
        'class' => false,
        'default' => true
    ]);
    echo $this->Html->endBox();
$this->end();
