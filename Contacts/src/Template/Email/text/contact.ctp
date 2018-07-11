<?php
$url = \Cake\Routing\Router::url([
    'controller' => 'contacts',
    'action' => 'view',
    $contact['Contact']['alias'],
], true);
echo __d('vamshop', 'You have received a new message at: %s', $url) . "\n \n";
echo __d('vamshop', 'Name: %s', $message->name) . "\n";
echo __d('vamshop', 'Email: %s', $message->email) . "\n";
echo __d('vamshop', 'Subject: %s', $message->title) . "\n";
echo __d('vamshop', 'IP Address: %s', $_SERVER['REMOTE_ADDR']) . "\n";
echo __d('vamshop', 'Message: %s', $message->body) . "\n";
