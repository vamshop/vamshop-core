<?php
$this->Breadcrumbs->add(__d('croogo', 'Content'),
        ['plugin' => 'Vamshop/Nodes', 'controller' => 'Nodes', 'action' => 'index'])
    ->add(__d('croogo', 'Types'), $this->request->getRequestTarget());

$this->extend('Vamshop/Core./Common/admin_index');
