<?php

$this->setLayout('admin_login');

echo $this->Form->create($user);

    echo $this->Form->input('password', [
        'type' => 'password',
        'placeholder' => __d('vamshop', 'New password'),
        'label' => false,
        'value' => '',
    ]);

    echo $this->Form->input('verify_password', [
        'type' => 'password',
        'placeholder' => __d('vamshop', 'Verify Password'),
        'label' => false,
        'value' => '',
    ]);

    echo $this->Form->input(__d('vamshop', 'Reset'), [
        'type' => 'submit',
        'class' => 'btn btn-primary',
        'templates' => [
            'submitContainer' => '<div class="float-right">{{content}}</div>',
        ],
    ]);

echo $this->Form->end();
