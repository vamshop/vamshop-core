<div class="users form">
    <h2><?= $this->fetch('title'); ?></h2>
    <?= $this->Form->create($user); ?>
    <fieldset>
        <?= $this->Form->input('password', ['label' => __d('vamshop', 'New password'), 'value' => '']); ?>
        <?= $this->Form->input('verify_password', ['type' => 'password', 'label' => __d('vamshop', 'Verify Password')]); ?>
    </fieldset>
    <?= $this->Form->submit(__d('vamshop', 'Reset')); ?>
    <?= $this->Form->end(); ?>
</div>
