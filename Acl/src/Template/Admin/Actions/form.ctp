<?php
$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs
    ->add(__d('vamshop', 'Users'), array('plugin' => 'Vamshop/Users', 'controller' => 'Users', 'action' => 'index'))
    ->add(__d('vamshop', 'Permissions'), array('plugin' => 'Vamshop/Acl', 'controller' => 'Permissions'))
    ->add(__d('vamshop', 'Actions'), array('plugin' => 'Vamshop/Acl', 'controller' => 'Actions', 'action' => 'index'));

if ($this->request->param('action') == 'edit') {
    $this->Breadcrumbs->add($aco->id . ': ' . $aco->alias, $this->request->getRequestTarget());
}

if ($this->request->param('action') == 'add') {
    $this->Breadcrumbs->add(__d('vamshop', 'Add'), $this->request->getRequestTarget());
}

$this->assign('form-start', $this->Form->create($aco));

$this->append('tab-heading');
    echo $this->Vamshop->adminTab(__d('vamshop', 'Action'), '#action-main');
$this->end();

$this->append('tab-content');

    echo $this->Form->input('parent_id', array(
        'options' => $acos,
        'empty' => true,
        'label' => __d('vamshop', 'Parent'),
    ));
    $this->Form->templates(array(
        'class' => 'span10',
    ));
    echo $this->Form->input('alias', array(
        'label' => __d('vamshop', 'Alias'),
    ));

$this->end();
