<?php

use Vamshop\Core\Status;

$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'Settings'), ['plugin' => 'Vamshop/Settings', 'controller' => 'Settings', 'action' => 'index']);
$this->Breadcrumbs->add(__d('vamshop', 'Meta'), ['action' => 'index']);

if ($this->request->params['action'] == 'edit') {
    $this->Breadcrumbs->add($$viewVar->key, $this->request->getRequestTarget());

    $this->assign('title', __d('vamshop', 'Edit Meta'));
}

if ($this->request->params['action'] == 'add') {
    $this->Breadcrumbs->add(__d('vamshop', 'Add'), $this->request->getRequestTarget());

    $this->assign('title', __d('vamshop', 'Add Meta'));
}
