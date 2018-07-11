<?php

use \Cake\Utility\Inflector;

$this->extend('/Common/admin_edit');
$this->assign('title', sprintf(__d('vamshop', 'Translate content: %s (%s)'), $language->title, $language->native));
$this->set('className', 'translate');

$crumbLabel = $model == 'Nodes' ? __d('vamshop', 'Content') : Inflector::pluralize($model);

$this->Breadcrumbs
    ->add($crumbLabel)
    ->add($entity->get($displayField))
    ->add(
        __d('vamshop', 'Translations'),
        array(
            'plugin' => 'Vamshop/Translate',
            'controller' => 'Translate',
            'action' => 'index',
            '?' => [
                'id' => $id,
                'model' => $modelAlias,
            ],
        )
    )
    ->add(__d('vamshop', 'Translate (%s)', $language->title), $this->request->getRequestTarget());

$this->append('form-start', $this->Form->create($entity, array(
    'url' => array(
        'plugin' => 'Vamshop/Translate',
        'controller' => 'Translate',
        'action' => 'edit',
        $id,
        '?' => [
            'id' => $entity->id,
            'model' => $modelAlias,
            'locale' => $locale,
        ],
    )
)));

$this->append('tab-heading');
    echo $this->Vamshop->adminTab(__d('vamshop', 'Translate'), '#translate-main');
    echo $this->Vamshop->adminTab(__d('vamshop', 'Original'), '#translate-original');
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('translate-main');
        foreach ($fields as $field):
            $name = '_translations.' . $locale . '.' . $field;
            echo $this->Form->input($name, [
                'default' => $entity->get($field),
            ]);
        endforeach;
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('translate-original');
        foreach ($fields as $field):
            $name = '_original.' . $field;
            echo $this->Form->input($name, [
                'value' => $entity->$field,
                'readonly' => true,
            ]);
        endforeach;
    echo $this->Html->tabEnd();

$this->end();

$this->start('panels');
    echo $this->Html->beginBox(__d('vamshop', 'Publishing'));

    $out =
        $this->Form->button(__d('vamshop', 'Apply'), [
            'name' => 'apply',
            'class' => 'btn-outline-primary',
        ]) .
        $this->Form->button(__d('vamshop', 'Save'), [
            'class' => 'btn-outline-success',
        ]) .
        $this->Html->link(__d('vamshop', 'Cancel'), ['action' => 'index',
            '?' => [
                'id' => $this->request->query('id'),
                'model' => urldecode($this->request->query('model')),
            ],
        ], [
            'class' => 'cancel',
            'button' => 'outline-danger'
        ]);
    echo $this->Html->div('card-buttons d-flex justify-content-center', $out);
    echo $this->Html->endBox();
$this->end();
