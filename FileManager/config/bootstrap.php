<?php

use Cake\Core\Configure;
use Vamshop\Core\Vamshop;
use Vamshop\Wysiwyg\Wysiwyg;

Configure::write('Wysiwyg.attachmentBrowseUrl', [
    'prefix' => 'admin',
    'plugin' => 'Vamshop/FileManager',
    'controller' => 'Attachments',
    'action' => 'browse',
]);

Wysiwyg::setActions([
    'Vamshop/FileManager.Admin/Attachments/browse' => [],
]);

Configure::write('FileManager', [
    'editablePaths' => [
        APP,
    ],
    'deletablePaths' => [
        APP . 'View' . DS . 'Themed' . DS,
        WWW_ROOT,
    ],
]);
