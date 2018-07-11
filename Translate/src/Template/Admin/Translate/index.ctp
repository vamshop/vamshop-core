<?php

use Cake\Core\Configure;
use Cake\Utility\Inflector;

$this->extend('Vamshop/Core./Common/admin_index');

$plugin = 'Vamshop/Nodes'; $controller = 'Nodes';
$modelPath = $this->request->query('model');
list($plugin, $model) = pluginSplit($modelPath);
$controller = $model;

$crumbLabel = $model == 'Nodes' ? __d('vamshop', 'Content') : Inflector::pluralize($model);

$this->Breadcrumbs
    ->add(
        $crumbLabel,
        array(
            'plugin' => Inflector::underscore($plugin),
            'controller' => Inflector::underscore($controller),
            'action' => 'index',
        )
    )
    ->add(
        $record->get($displayField),
        array(
            'plugin' => Inflector::underscore($plugin),
            'controller' =>  Inflector::underscore($controller),
            'action' => 'edit',
            $record->id,
        )
    )
    ->add(__d('vamshop', 'Translations'), $this->request->getRequestTarget());

$this->start('action-buttons');
    $translateButton = $this->Html->link(
        __d('vamshop', 'Translate in a new language'),
        array(
            'plugin' => 'Vamshop/Settings',
            'controller' => 'Languages',
            'action' => 'select',
            '?' => [
                'id' => $record->id,
                'model' => $modelAlias,
            ],
        ),
        array(
            'button' => 'secondary',
            'class' => 'dropdown-toggle',
            'data-toggle' => 'dropdown',
        )
    );
    if (!empty($languages)):
        $out = null;
        foreach ($languages as $languageAlias => $languageDisplay):
            if ($languageAlias == Configure::read('App.defaultLocale')):
                continue;
            endif;
            $out .= $this->Vamshop->adminAction($languageDisplay, array(
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Translate',
                'controller' => 'Translate',
                'action' => 'edit',
                '?' => [
                    'id' => $id,
                    'model' => $modelAlias,
                    'locale' => $languageAlias,
                ],
            ), array(
                'button' => false,
                'list' => true,
                'class' => 'dropdown-item',
            ));
        endforeach;
        echo $this->Html->div('btn-group',
            $translateButton .
            $this->Html->tag('ul', $out, array('class' => 'dropdown-menu'))
        );
    endif;
$this->end();

if (count(array($translations)) == 0):
    echo $this->Html->para(null, __d('vamshop', 'No translations available.'));
    return;
endif;

$this->append('table-heading');
    $tableHeaders = $this->Html->tableHeaders(array(
        '',
        __d('vamshop', 'Original'),
        __d('vamshop', 'Title'),
        __d('vamshop', 'Locale'),
        __d('vamshop', 'Actions'),
    ));
    echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
    $rows = array();
    foreach ($translations->_translations as $locale => $entity):
        $actions = array();
        $actions[] = $this->Vamshop->adminRowAction('', array(
            'action' => 'edit',
            '?' => [
                'id' => $id,
                'model' => $modelAlias,
                'locale' => $locale,
            ],
        ), array(
            'icon' => $this->Theme->getIcon('update'),
            'tooltip' => __d('vamshop', 'Edit this item'),
        ));
        $actions[] = $this->Vamshop->adminRowAction('', array(
            'action' => 'delete',
            $id,
            urlencode($modelAlias),
            $locale,
        ), array(
            'icon' => $this->Theme->getIcon('delete'),
            'tooltip' => __d('vamshop', 'Remove this item'),
            'method' => 'post',
        ), __d('vamshop', 'Are you sure?'));

        $actions = $this->Html->div('item-actions', implode(' ', $actions));
        $rows[] = array(
            '',
            $record->title,
            $entity->title,
            $locale,
            $actions,
        );
    endforeach;

    echo $this->Html->tableCells($rows);
$this->end();
