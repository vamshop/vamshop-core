<?php

$this->Vamshop->adminScript('Vamshop/Comments.admin');

$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('vamshop', 'Content'), ['plugin' => 'Vamshop/Nodes', 'controller' => 'Nodes', 'action' => 'index']);

if (isset($criteria['Comment.status'])) {
    $this->Breadcrumbs->add(__d('vamshop', 'Comments'), ['action' => 'index']);
    if ($criteria['Comment.status'] == '1') {
        $this->Breadcrumbs->add(__d('vamshop', 'Published'), $this->request->getRequestTarget());
        $this->assign('title', __d('vamshop', 'Comments: Published'));
    } else {
        $this->Breadcrumbs->add(__d('vamshop', 'Awaiting approval'), $this->request->getRequestTarget());
        $this->assign('title', __d('vamshop', 'Comments: Published'));
    }
} else {
    $this->Breadcrumbs->add(__d('vamshop', 'Comments'), $this->request->getRequestTarget());
}

$this->append('table-footer', $this->element('Vamshop/Core.admin/modal', array(
    'id' => 'comment-modal',
    'class' => 'hide',
    )));

$this->append('action-buttons');
echo $this->Vamshop->adminAction(
    __d('vamshop', 'Published'),
    ['action' => 'index', '?' => ['status' => '1']],
    ['class' => 'btn btn-secondary']
);
echo $this->Vamshop->adminAction(
    __d('vamshop', 'Awaiting approval'),
    ['action' => 'index', '?' => ['status' => '0']],
    ['class' => 'btn btn-secondary']
);
$this->end();
