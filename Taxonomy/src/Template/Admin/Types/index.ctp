<?php
$this->Breadcrumbs->add(__d('vamshop', 'Content'),
        ['plugin' => 'Vamshop/Nodes', 'controller' => 'Nodes', 'action' => 'index'])
    ->add(__d('vamshop', 'Types'), $this->request->getRequestTarget());

$this->extend('Vamshop/Core./Common/admin_index');
