<?php
$this->extend('Vamshop/Core./Common/admin_edit');

$this->assign('title', __d('vamshop', 'Reset password: %s', $user->username));
$this->Breadcrumbs
    ->add(__d('vamshop', 'Users'), ['plugin' => 'Vamshop/Users', 'controller' => 'Users', 'action' => 'index'])
    ->add($user->name, [
        'action' => 'edit',
        $user->id,
    ])
    ->add(__d('vamshop', 'Reset Password'), $this->request->getRequestTarget());
$this->assign('form-start', $this->Form->create($user));

$this->start('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Reset Password'), '#reset-password');
$this->end();

$this->start('tab-content');
echo $this->Html->tabStart('reset-password');
echo $this->Form->input('password', ['label' => __d('vamshop', 'New Password'), 'value' => '']);
echo $this->Form->input('verify_password',
    ['label' => __d('vamshop', 'Verify Password'), 'type' => 'password', 'value' => '']);
echo $this->Html->tabEnd();
$this->end();
