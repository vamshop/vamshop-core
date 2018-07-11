<?php use Cake\Routing\Router;

echo __d('vamshop', 'Hello %s', $user->name); ?>,

<?php
echo __d('vamshop', 'Please visit this link to activate your account: %s', Router::url(['prefix' => false, 'plugin' => 'Vamshop/Users', 'controller' => 'Users', 'action' => 'activate', $user->username, $user->activation_key], true));
