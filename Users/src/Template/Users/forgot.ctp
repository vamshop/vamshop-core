<?php

$this->assign('title', __d('vamshop', 'Forgot Password'));

?>
<div class="users form">
    <h2><?= $this->fetch('title') ?></h2>
    <?= $this->Form->create('User', ['url' => ['controller' => 'users', 'action' => 'forgot']]);?>
        <fieldset>
        <?= $this->Form->input('username', [
            'label' => __d('vamshop', 'Username'),
            'required' => true,
        ]) ?>
        </fieldset>
        <?= $this->Form->submit(__d('vamshop', 'Submit')) ?>
    <?= $this->Form->end() ?>
</div>
