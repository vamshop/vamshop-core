<?php
echo $this->Form->create(null, [
    'align' => 'inline',
]);

$this->Form->templates([
    'label' => false,
    'submitContainer' => '{{content}}',
]);

echo $this->Form->input('filter', [
    'title' => __d('vamshop', 'Search'),
    'placeholder' => __d('vamshop', 'Search...'),
    'tooltip' => false,
    'default' => $this->request->query('filter'),
]);

if (!isset($this->request->query['chooser'])):

    echo $this->Form->input('type', [
        'options' => $nodeTypes,
        'empty' => __d('vamshop', 'Type'),
        'class' => 'c-select',
        'default' => $this->request->query('type'),
    ]);

    echo $this->Form->input('status', [
        'options' => [
            '1' => __d('vamshop', 'Published'),
            '0' => __d('vamshop', 'Unpublished'),
        ],
        'empty' => __d('vamshop', 'Status'),
        'class' => 'c-select',
        'default' => $this->request->query('status'),
    ]);

    echo $this->Form->input('promote', [
        'options' => [
            '1' => __d('vamshop', 'Yes'),
            '0' => __d('vamshop', 'No'),
        ],
        'empty' => __d('vamshop', 'Promoted'),
        'class' => 'c-select',
        'default' => $this->request->query('promote'),
    ]);

endif;

echo $this->Form->submit(__d('vamshop', 'Filter'), [
    'class' => 'btn-outline-success',
]);
echo $this->Html->link('Reset', [
    'action' => 'index',
], [
    'class' => 'btn btn-outline-secondary',
]);
echo $this->Form->end();
