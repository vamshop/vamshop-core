<?php
use Cake\Core\Configure;

$this->setLayout('admin_login');

$title = __d('vamshop', 'Forgot Password');
$this->assign('title', $title);
echo $this->Form->create('Users', [
    'url' => [
        'controller' => 'Users',
        'action' => 'forgot',
    ]
]);

    echo $this->Form->input('username', [
        'label' => false,
        'placeholder' => __d('vamshop', 'Username/Email'),
        'prepend' => $this->Html->icon('user', ['class' => 'fa-fw']),
        'required' => true,
    ]);
    echo $this->Form->input(__d('vamshop', 'Submit'), [
        'type' => 'submit',
        'class' => 'btn btn-primary',
        'templates' => [
            'submitContainer' => '<div class="float-right">{{content}}</div>',
        ],
    ]);

echo $this->Form->end();
