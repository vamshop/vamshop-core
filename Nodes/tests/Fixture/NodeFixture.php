<?php

namespace Vamshop\Nodes\Test\Fixture;

use Vamshop\Core\TestSuite\VamshopTestFixture;

class NodeFixture extends VamshopTestFixture
{

    public $name = 'Node';

    public $fields = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null],
        'parent_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 20],
        'user_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20],
        'title' => ['type' => 'string', 'null' => false, 'default' => null],
        'slug' => ['type' => 'string', 'null' => false, 'default' => null],
        'body' => ['type' => 'text', 'null' => true, 'default' => null],
        'excerpt' => ['type' => 'text', 'null' => true, 'default' => null],
        'status' => ['type' => 'integer', 'length' => 1, 'null' => false, 'default' => '0'],
        'mime_type' => ['type' => 'string', 'null' => true, 'default' => null, 'length' => 100],
        'comment_status' => ['type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1],
        'comment_count' => ['type' => 'integer', 'null' => true, 'default' => '0'],
        'promote' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
        'path' => ['type' => 'string', 'null' => true, 'default' => null],
        'terms' => ['type' => 'text', 'null' => true, 'default' => null],
        'sticky' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
        'lft' => ['type' => 'integer', 'null' => true, 'default' => null],
        'rght' => ['type' => 'integer', 'null' => true, 'default' => null],
        'visibility_roles' => ['type' => 'text', 'null' => true, 'default' => null],
        'type' => ['type' => 'string', 'null' => false, 'default' => 'node', 'length' => 100],
        'publish_start' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'publish_end' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
            'slug' => ['type' => 'unique', 'columns' => 'slug']
        ],
        '_options' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB']
    ];

    public $records = [
        [
            'id' => 1,
            'parent_id' => null,
            'user_id' => 1,
            'title' => 'Hello World',
            'slug' => 'hello-world',
            'body' => '<p>Welcome to Vamshop. This is your first post. You can edit or delete it from the admin panel.</p>',
            'excerpt' => null,
            'status' => 1,
            'mime_type' => null,
            'comment_status' => 2,
            'comment_count' => 1,
            'promote' => 1,
            'path' => '/blog/hello-world',
            'terms' => '{\"1\":\"uncategorized\"}',
            'sticky' => 0,
            'lft' => 1,
            'rght' => 2,
            'visibility_roles' => null,
            'type' => 'blog',
            'updated' => '2018-12-25 11:00:00',
            'created' => '2018-12-25 11:00:00'
        ],
        [
            'id' => 2,
            'parent_id' => null,
            'user_id' => 1,
            'title' => 'About',
            'slug' => 'about',
            'body' => '<p>This is an example of a Vamshop page, you could edit this to put information about yourself or your site.</p>',
            'excerpt' => null,
            'status' => 1,
            'mime_type' => null,
            'comment_status' => 0,
            'comment_count' => 0,
            'promote' => 0,
            'path' => '/about',
            'terms' => null,
            'sticky' => 0,
            'lft' => 1,
            'rght' => 2,
            'visibility_roles' => null,
            'type' => 'page',
            'updated' => '2018-12-25 22:00:00',
            'created' => '2018-12-25 22:00:00'
        ],
        [
            'id' => 3,
            'parent_id' => null,
            'user_id' => 1,
            'title' => 'Protected',
            'slug' => 'protected',
            'body' => '<p>This page is only visible to admin</p>',
            'excerpt' => null,
            'status' => 1,
            'mime_type' => null,
            'comment_status' => 0,
            'comment_count' => 0,
            'promote' => 1,
            'path' => '/page/protected',
            'terms' => null,
            'sticky' => 0,
            'lft' => 3,
            'rght' => 4,
            'visibility_roles' => '["1"]',
            'type' => 'page',
            'updated' => '2018-09-12 20:00:00',
            'created' => '2018-09-12 20:00:00'
        ],
    ];
}
