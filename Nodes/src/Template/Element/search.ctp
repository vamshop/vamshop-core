<?php

$this->Form->unlockField('q');

echo $this->Form->create(false, [
    'url' => [
        'prefix' => false,
        'plugin' => 'Vamshop/Nodes',
        'controller' => 'Nodes',
        'action' => 'search'
    ],
]);
?>
<div class="input-group">

    <?=
        $this->Form->input('q', [
            'label' => false,
            'default' => $this->request->query('q'),
            'templates' => [
                'inputContainer' => '{{content}}',
            ],
        ]);
    ?>

    <span class="input-group-btn">
        <?=
            $this->Form->button(__d('vamshop', 'Search'), [
                'class' => 'btn btn-secondary',
            ])
        ?>
    </span>
</div>
<?= $this->Form->end(); ?>
