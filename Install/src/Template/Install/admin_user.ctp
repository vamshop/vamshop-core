<?php
$this->assign('title', __d('vamshop', 'Admin user'));

$this->assign('before', $this->Form->create($user, [
    'align' => ['left' => 4, 'middle' => 8, 'right' => 0],
]));
?>
<?php
echo $this->Form->input('username', [
    'placeholder' => __d('vamshop', 'Username'),
    'prepend' => $this->Html->icon('user'),
    'label' => __d('vamshop', 'Username'),
]);
echo $this->Form->input('password', [
    'placeholder' => __d('vamshop', 'New Password'),
    'value' => '',
    'prepend' => $this->Html->icon('key'),
    'label' => __d('vamshop', 'New Password'),
]);
echo $this->Form->input('verify_password', [
    'placeholder' => __d('vamshop', 'Verify Password'),
    'type' => 'password',
    'value' => '',
    'prepend' => $this->Html->icon('key'),
    'label' => __d('vamshop', 'Verify Password'),
]);
?>
<?php
$this->assign('buttons', $this->Form->button(__d('vamshop', 'Finalize installation'), ['class' => 'success']));
$this->assign('after', $this->Form->end());
?>
