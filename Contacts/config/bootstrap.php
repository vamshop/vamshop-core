<?php

use Cake\Core\Configure;
use Cake\Cache\Cache;
use Vamshop\Core\Vamshop;
use Vamshop\Wysiwyg\Wysiwyg;

Cache::config('contacts_view', array_merge(
    Configure::read('Vamshop.Cache.defaultConfig'),
    ['groups' => ['contacts']]
));

Vamshop::translateModel('Vamshop/Contacts.Contacts', [
    'fields' => [
        'title',
        'body',
    ],
]);

// Configure Wysiwyg
Wysiwyg::setActions([
    'Vamshop/Contacts.Admin/Contacts/add' => [
        [
            'elements' => 'body',
        ],
    ],
    'Vamshop/Contacts.Admin/Contacts/edit' => [
        [
            'elements' => 'body',
        ],
    ],
]);
