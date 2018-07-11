<?php
use Cake\Core\Configure;

$this->assign('title', __d('vamshop', 'Login'));

echo $this->Form->create(false, ['url' => ['action' => 'login']]);
$this->Form->templates([
    'label' => false,
    'textContainer' => '<div class="input-prepend {{type}}"><span class="add-on"><i class="icon-user"></i></span>{{content}}</div>',
    'passwordContainer' => '<div class="input-prepend {{type}}"><span class="add-on"><i class="icon-key"></i></span>{{content}}</div>',
]);
echo $this->Form->input('username', [
    'placeholder' => __d('vamshop', 'Username'),
    'label' => false,
    'prepend' => $this->Html->icon('user', ['class' => 'fa-fw']),
]);
echo $this->Form->input('password', [
    'placeholder' => __d('vamshop', 'Password'),
    'label' => false,
    'prepend' => $this->Html->icon('key', ['class' => 'fa-fw']),
]);
if (Configure::read('Access Control.autoLoginDuration')):
    echo $this->Form->input('remember', [
        'label' => __d('vamshop', 'Remember me?'),
        'type' => 'checkbox',
        'default' => false,
    ]);
endif;
echo $this->Form->button(__d('vamshop', 'Log In'), ['class' => 'btn btn-primary']);
echo $this->Html->link(__d('vamshop', 'Forgot password?'), [
    'prefix' => 'admin',
    'plugin' => 'Vamshop/Users',
    'controller' => 'Users',
    'action' => 'forgot',
], [
    'class' => 'forgot',
]);
echo $this->Form->end();
