<?php
$this->extend('Vamshop/Core./Common/admin_index');
$this->Breadcrumbs->add(__d('vamshop', 'Blocks'), ['controller' => 'blocks', 'action' => 'index'])
    ->add(__d('vamshop', 'Regions'), $this->request->getUri()->getPath());
?>
