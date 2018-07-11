<?php
$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs
    ->add(__d('vamshop', 'Users'), ['plugin' => 'Vamshop/Users', 'controller' => 'Users', 'action' => 'index'])
    ->add(__d('vamshop', 'Roles'), $this->request->getUri()->getPath());
