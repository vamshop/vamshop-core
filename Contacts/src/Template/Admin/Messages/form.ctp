<?php
$this->assign('title', __d('vamshop', 'Edit Message'));
$this->extend('/Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'Contacts'),
    ['plugin' => 'Vamshop/Contacts', 'controller' => 'Contacts', 'action' => 'index'])
    ->add(__d('vamshop', 'Messages'),
        ['plugin' => 'Vamshop/Contacts', 'controller' => 'Messages', 'action' => 'index']);

if ($this->request->params['action'] == 'edit') {
    $this->Breadcrumbs->add($message->title, $this->request->getRequestTarget());
}

$this->append('form-start', $this->Form->create($message));

$this->append('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Message'), '#message-main');
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('message-main') . $this->Form->input('name', [
        'label' => __d('vamshop', 'Name'),
    ]) . $this->Form->input('email', [
        'label' => __d('vamshop', 'Email'),
    ]) . $this->Form->input('title', [
        'label' => __d('vamshop', 'Title'),
    ]) . $this->Form->input('body', [
        'label' => __d('vamshop', 'Body'),
    ]) . $this->Form->input('phone', [
        'label' => __d('vamshop', 'Phone'),
    ]) . $this->Form->input('address', [
        'label' => __d('vamshop', 'Address'),
    ]);
echo $this->Html->tabEnd();
$this->end();
