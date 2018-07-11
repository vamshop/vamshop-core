<?php
$this->assign('title', __d('vamshop', 'Step 2: Build database'));
?>

<div class="install">
    <h2><?= $this->fetch('title') ?></h2>

    <p>
        <?php
        echo __d('vamshop', 'Create tables and load initial data');
        ?>
    </p>
</div>
<div class="form-actions">
    <?php
    echo $this->Html->link(__d('vamshop', 'Build database'), [
        'plugin' => 'Vamshop/Install',
        'controller' => 'install',
        'action' => 'data',
        '?' => ['run' => 1],
    ], [
        'tooltip' => [
            'data-title' => __d('vamshop', 'Click here to build your database'),
            'data-placement' => 'left',
        ],
        'button' => 'success',
        'icon' => 'none',
    ]);
    ?>
</div>
