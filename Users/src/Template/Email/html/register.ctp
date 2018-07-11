<?php

use Cake\Routing\Router;

?>
<p>
<?= __d('vamshop', 'Hello %s', $user->name); ?>,
</p>

<p>
<?= __d('vamshop', 'Please visit this link to activate your account: %s', Router::url(['prefix' => false, 'plugin' => 'Vamshop/Users', 'controller' => 'Users', 'action' => 'activate', $user->username, $user->activation_key], true));
?>
</p>
