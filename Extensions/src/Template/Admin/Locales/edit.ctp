<?php

$this->extend('/Common/admin_edit');

$this->Breadcrumbs
    ->add(__d('vamshop', 'Extensions'), array('plugin' => 'Vamshop/Extensions', 'controller' => 'Plugins', 'action' => 'index'))
    ->add(__d('vamshop', 'Locales'), array('plugin' => 'Vamshop/Extensions', 'controller' => 'Locales', 'action' => 'index'))
    ->add($this->request->params['pass'][0], $this->request->getRequestTarget());

$this->append('form-start', $this->Form->create($locale, array(
    'url' => array(
        'plugin' => 'Vamshop/Extensions',
        'controller' => 'Locales',
        'action' => 'edit',
        $locale['locale'],
    ),
)));

$this->append('tab-heading');
    echo $this->Vamshop->adminTab(__d('vamshop', 'Content'), '#locale-content');
$this->end();

$this->append('tab-content');
    echo $this->Html->tabStart('locale-content') .
        $this->Form->input('content', array(
            'label' => __d('vamshop', 'Content'),
            'data-placement' => 'top',
            'value' => $content,
            'type' => 'textarea',
        ));
    echo $this->Html->tabEnd();

$this->end();

$this->append('panels');
    echo $this->Html->beginBox(__d('vamshop', 'Actions')) .
        $this->Form->button(__d('vamshop', 'Save')) .
        $this->Html->link(__d('vamshop', 'Cancel'),
            array('action' => 'index'),
            array('button' => 'danger')
        );
    echo $this->Html->endBox();

    echo $this->Vamshop->adminBoxes();
$this->end();
