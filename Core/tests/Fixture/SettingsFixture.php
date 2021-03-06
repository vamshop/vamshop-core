<?php

namespace Vamshop\Core\Test\Fixture;

use Vamshop\Core\TestSuite\VamshopTestFixture;

class SettingsFixture extends VamshopTestFixture
{
    public $fields = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null],
        'key' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64],
        'value' => ['type' => 'text', 'null' => false, 'default' => null],
        'title' => ['type' => 'string', 'null' => false, 'default' => null],
        'description' => ['type' => 'string', 'null' => false, 'default' => null],
        'input_type' => ['type' => 'string', 'null' => false, 'default' => 'text'],
        'editable' => ['type' => 'boolean', 'null' => false, 'default' => '1'],
        'weight' => ['type' => 'integer', 'null' => true, 'default' => null],
        'params' => ['type' => 'text', 'null' => false, 'default' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
            'key' => ['type' => 'unique', 'columns' => 'key']
        ],
        '_options' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB']
    ];

    public $records = [
        [
            'id' => 6,
            'key' => 'Site.title',
            'value' => 'Vamshop - Test',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => 1,
            'weight' => 1,
            'params' => ''
        ],
        [
            'id' => 7,
            'key' => 'Site.tagline',
            'value' => 'A CakePHP powered Content Management System.',
            'title' => '',
            'description' => '',
            'input_type' => 'textarea',
            'editable' => 1,
            'weight' => 2,
            'params' => ''
        ],
        [
            'id' => 8,
            'key' => 'Site.email',
            'value' => 'you@your-site.com',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => 1,
            'weight' => 3,
            'params' => ''
        ],
        [
            'id' => 9,
            'key' => 'Site.status',
            'value' => '1',
            'title' => '',
            'description' => '',
            'input_type' => 'checkbox',
            'editable' => 1,
            'weight' => 5,
            'params' => ''
        ],
        [
            'id' => 12,
            'key' => 'Meta.robots',
            'value' => 'index, follow',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => 1,
            'weight' => 6,
            'params' => ''
        ],
        [
            'id' => 13,
            'key' => 'Meta.keywords',
            'value' => 'vamshop, Vamshop',
            'title' => '',
            'description' => '',
            'input_type' => 'textarea',
            'editable' => 1,
            'weight' => 7,
            'params' => ''
        ],
        [
            'id' => 14,
            'key' => 'Meta.description',
            'value' => 'Vamshop - A CakePHP powered Content Management System',
            'title' => '',
            'description' => '',
            'input_type' => 'textarea',
            'editable' => 1,
            'weight' => 8,
            'params' => ''
        ],
        [
            'id' => 15,
            'key' => 'Meta.generator',
            'value' => 'Vamshop - Content Management System',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => 0,
            'weight' => 9,
            'params' => ''
        ],
        [
            'id' => 16,
            'key' => 'Service.akismet_key',
            'value' => 'your-key',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => 1,
            'weight' => 11,
            'params' => ''
        ],
        [
            'id' => 17,
            'key' => 'Service.recaptcha_public_key',
            'value' => 'your-public-key',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => 1,
            'weight' => 12,
            'params' => ''
        ],
        [
            'id' => 18,
            'key' => 'Service.recaptcha_private_key',
            'value' => 'your-private-key',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => 1,
            'weight' => 13,
            'params' => ''
        ],
        [
            'id' => 19,
            'key' => 'Service.akismet_url',
            'value' => 'http://your-blog.com',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => 1,
            'weight' => 10,
            'params' => ''
        ],
        [
            'id' => 20,
            'key' => 'Site.theme',
            'value' => 'Vamshop/Core',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => 0,
            'weight' => 14,
            'params' => ''
        ],
        [
            'id' => 21,
            'key' => 'Site.feed_url',
            'value' => '',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => 0,
            'weight' => 15,
            'params' => ''
        ],
        [
            'id' => 22,
            'key' => 'Reading.nodes_per_page',
            'value' => '5',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => 1,
            'weight' => 16,
            'params' => ''
        ],
        [
            'id' => 23,
            'key' => 'Writing.wysiwyg',
            'value' => '1',
            'title' => 'Enable WYSIWYG editor',
            'description' => '',
            'input_type' => 'checkbox',
            'editable' => 1,
            'weight' => 17,
            'params' => ''
        ],
        [
            'id' => 24,
            'key' => 'Comment.level',
            'value' => '1',
            'title' => '',
            'description' => 'levels deep (threaded comments)',
            'input_type' => '',
            'editable' => 1,
            'weight' => 18,
            'params' => ''
        ],
        [
            'id' => 25,
            'key' => 'Comment.feed_limit',
            'value' => '10',
            'title' => '',
            'description' => 'number of comments to show in feed',
            'input_type' => '',
            'editable' => 1,
            'weight' => 19,
            'params' => ''
        ],
        [
            'id' => 26,
            'key' => 'Site.locale',
            'value' => 'eng',
            'title' => '',
            'description' => '',
            'input_type' => 'text',
            'editable' => 0,
            'weight' => 20,
            'params' => ''
        ],
        [
            'id' => 27,
            'key' => 'Reading.date_time_format',
            'value' => 'D, M d Y H:i:s',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => 1,
            'weight' => 21,
            'params' => ''
        ],
        [
            'id' => 28,
            'key' => 'Comment.date_time_format',
            'value' => 'M d, Y',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => 1,
            'weight' => 22,
            'params' => ''
        ],
        [
            'id' => 29,
            'key' => 'Site.timezone',
            'value' => '0',
            'title' => '',
            'description' => 'zero (0) for GMT',
            'input_type' => '',
            'editable' => 1,
            'weight' => 4,
            'params' => ''
        ],
        [
            'id' => 32,
            'key' => 'Hook.bootstraps',
            'value' => 'Vamshop/Settings,Vamshop/Comments,Vamshop/Contacts,Vamshop/Nodes,Vamshop/Meta,Vamshop/Menus,Vamshop/Users,Vamshop/Blocks,Vamshop/Taxonomy,Vamshop/FileManager',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => 0,
            'weight' => 23,
            'params' => ''
        ],
        [
            'id' => 33,
            'key' => 'Comment.email_notification',
            'value' => '1',
            'title' => 'Enable email notification',
            'description' => '',
            'input_type' => 'checkbox',
            'editable' => 1,
            'weight' => 24,
            'params' => ''
        ],
        [
            'id' => 34,
            'key' => 'Site.acl_plugin',
            'value' => 'Vamshop/Acl',
            'title' => 'Acl Plugin',
            'description' => '',
            'input_type' => '',
            'editable' => 0,
            'weight' => 25,
            'params' => ''
        ],
        [
            'id' => 35,
            'key' => 'Vamshop.installed',
            'value' => '1',
            'title' => 'Whether Vamshop is installed',
            'description' => '',
            'input_type' => '',
            'editable' => 0,
            'weight' => 26,
            'params' => ''
        ],
        [
            'id' => 36,
            'key' => 'Site.admin_theme',
            'value' => 'Vamshop/Core',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => 0,
            'weight' => 14,
            'params' => ''
        ],
    ];
}
