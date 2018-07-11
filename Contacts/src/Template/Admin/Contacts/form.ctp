<?php

$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'Contacts'), ['controller' => 'contacts', 'action' => 'index']);

if ($this->request->params['action'] == 'edit') {
    $this->Breadcrumbs->add($contact->title, $this->request->getRequestTarget());
}

if ($this->request->params['action'] == 'add') {
    $this->Breadcrumbs->add(__d('vamshop', 'Add'), $this->request->getRequestTarget());
}

$this->append('form-start', $this->Form->create($contact));

$this->append('tab-heading');
echo $this->Vamshop->adminTab(__d('vamshop', 'Contact'), '#contact-basic');
echo $this->Vamshop->adminTab(__d('vamshop', 'Details'), '#contact-details');
echo $this->Vamshop->adminTab(__d('vamshop', 'Message'), '#contact-message');
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('contact-basic') . $this->Form->input('id') . $this->Form->input('title', [
        'label' => __d('vamshop', 'Title'),
        'data-slug' => '#alias',
    ]) . $this->Form->input('alias', [
        'label' => __d('vamshop', 'Alias'),
    ]) . $this->Form->input('email', [
        'label' => __d('vamshop', 'Email'),
    ]) . $this->Form->input('body', [
        'label' => __d('vamshop', 'Body'),
    ]);
echo $this->Html->tabEnd();

echo $this->Html->tabStart('contact-details') . $this->Form->input('name', [
        'label' => __d('vamshop', 'Name'),
    ]) . $this->Form->input('position', [
        'label' => __d('vamshop', 'Position'),
    ]) . $this->Form->input('address', [
        'label' => __d('vamshop', 'Address'),
    ]) . $this->Form->input('address2', [
        'label' => __d('vamshop', 'Address2'),
    ]) . $this->Form->input('state', [
        'label' => __d('vamshop', 'State'),
    ]) . $this->Form->input('country', [
        'label' => __d('vamshop', 'Country'),
    ]) . $this->Form->input('postcode', [
        'label' => __d('vamshop', 'Post Code'),
    ]) . $this->Form->input('phone', [
        'label' => __d('vamshop', 'Phone'),
    ]) . $this->Form->input('fax', [
        'label' => __d('vamshop', 'Fax'),
    ]);
echo $this->Html->tabEnd();

echo $this->Html->tabStart('contact-message') . $this->Form->input('message_status', [
        'label' => __d('vamshop', 'Let users leave a message'),
    ]) . $this->Form->input('message_archive', [
        'label' => __d('vamshop', 'Save messages in database'),
    ]) . $this->Form->input('message_notify', [
        'label' => __d('vamshop', 'Notify by email instantly'),
    ]) . $this->Form->input('message_spam_protection', [
        'label' => __d('vamshop', 'Spam protection (requires Akismet API key)'),
    ]) . $this->Form->input('message_captcha', [
        'label' => __d('vamshop', 'Use captcha? (requires Recaptcha API key)'),
    ]);

echo $this->Html->link(__d('vamshop', 'You can manage your API keys here.'), [
    'plugin' => 'Vamshop/Settings',
    'controller' => 'Settings',
    'action' => 'prefix',
    'Service',
]);
echo $this->Html->tabEnd();
$this->end();

$this->append('panels');
echo $this->Html->beginBox(__d('vamshop', 'Publishing'));
echo $this->element('Vamshop/Core.admin/buttons', ['type' => 'contact']);
echo $this->Form->input('status', [
        'label' => __d('vamshop', 'Published'),
    ]);
echo $this->Html->endBox();
$this->end();
