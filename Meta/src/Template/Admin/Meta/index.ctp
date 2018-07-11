<?php

use Vamshop\Core\Status;

$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('croogo', 'Settings'), ['plugin' => 'Vamshop/Settings', 'controller' => 'Settings', 'action' => 'index']);
$this->Breadcrumbs->add(__d('croogo', 'Meta'), $this->request->getUri()->getPath());
