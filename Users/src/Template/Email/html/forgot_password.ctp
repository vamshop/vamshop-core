<p>
<?= __d('vamshop', 'Hello %s', $user->name); ?>,
</p>

<p>
<?php
    $url = $this->Url->build([
        'plugin' => 'Vamshop/Users',
        'controller' => 'Users',
        'action' => 'reset',
        $user->username,
        $user->activation_key,
    ], true);
    echo __d('vamshop', 'Please visit this link to reset your password: %s', $url);
?>
</p>

<p>
    <?= __d('vamshop', 'If you did not request a password reset, then please ignore this email.'); ?>
</p>

<p>
    <?= __d('vamshop', 'IP Address: %s', $_SERVER['REMOTE_ADDR']); ?>
</p>
