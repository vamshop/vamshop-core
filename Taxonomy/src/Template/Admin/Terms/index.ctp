<?php

$this->assign('title', __d('vamshop', 'Vocabulary: %s', $vocabulary->title));

$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('vamshop', 'Content'),
        ['plugin' => 'Vamshop/Nodes', 'controller' => 'Nodes', 'action' => 'index'])
    ->add(__d('vamshop', 'Vocabularies'),
        ['plugin' => 'Vamshop/Taxonomy', 'controller' => 'Vocabularies', 'action' => 'index'])
    ->add($vocabulary->title, $this->request->getRequestTarget());

$this->append('action-buttons');
echo $this->Vamshop->adminAction(__d('vamshop', 'Create term'), [
    'action' => 'add',
    'vocabulary_id' => $vocabulary->id,
], [
    'class' => 'btn btn-success',
]);
$this->end();

$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders([
    __d('vamshop', 'Title'),
    __d('vamshop', 'Slug'),
    __d('vamshop', 'Actions'),
]);
echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
$rows = [];

foreach ($terms as $term):
    $actions = [];
    $actions[] = $this->Vamshop->adminRowActions($term->id);
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'moveUp', $term->id, $vocabulary->id],
        ['icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('vamshop', 'Move up'), 'method' => 'post']);
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'moveDown', $term->id, $vocabulary->id],
        ['icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('vamshop', 'Move down'), 'method' => 'post']);
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'edit', $term->id, 'vocabulary_id' => $vocabulary->id],
        ['icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('vamshop', 'Edit this item')]);
    $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'delete', $term->id, $vocabulary->id],
        ['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('vamshop', 'Remove this item')],
        __d('vamshop', 'Are you sure?'));
    $actions = $this->Html->div('item-actions', implode(' ', $actions));

    // Title Column
    $titleCol = $term->title;
    if (isset($defaultType['alias'])) {
        $titleCol = $this->Html->link($term->title, [
            'prefix' => false,
            'plugin' => 'Vamshop/Nodes',
            'controller' => 'Nodes',
            'action' => 'term',
            'type' => $defaultType->alias,
            'slug' => $term->slug,
        ], [
            'target' => '_blank',
        ]);
    }

    if (!empty($term['Term']['indent'])):
        $titleCol = str_repeat('&emsp;', $term['Term']['indent']) . $titleCol;
    endif;

    // Build link list
    $typeLinks = $this->Taxonomies->generateTypeLinks($vocabulary->types, $term);
    if (!empty($typeLinks)) {
        $titleCol .= $this->Html->tag('small', $typeLinks);
    }

    $rows[] = [
        $titleCol,
        $term->slug,
        $actions,
    ];
endforeach;
echo $this->Html->tableCells($rows);
$this->end();
