<?php
$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs
    ->add(__d('croogo', 'Users'), ['plugin' => 'Vamshop/Users', 'controller' => 'Users', 'action' => 'index'])
    ->add(__d('croogo', 'Roles'), $this->request->getUri()->getPath());
