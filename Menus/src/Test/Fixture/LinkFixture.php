<?php

namespace Vamshop\Menus\Test\Fixture;

use Vamshop\Core\TestSuite\VamshopTestFixture;

class LinkFixture extends VamshopTestFixture
{

    public $name = 'Link';

    public $fields = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 20],
        'parent_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 20],
        'menu_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 20],
        'title' => ['type' => 'string', 'null' => false, 'default' => null],
        'class' => ['type' => 'string', 'null' => false, 'default' => null],
        'description' => ['type' => 'text', 'null' => true, 'default' => null],
        'link' => ['type' => 'string', 'null' => false, 'default' => null],
        'target' => ['type' => 'string', 'null' => true, 'default' => null],
        'rel' => ['type' => 'string', 'null' => true, 'default' => null],
        'status' => ['type' => 'integer', 'length' => 1, 'null' => false, 'default' => '1'],
        'lft' => ['type' => 'integer', 'null' => true, 'default' => null],
        'rght' => ['type' => 'integer', 'null' => true, 'default' => null],
        'visibility_roles' => ['type' => 'text', 'null' => true, 'default' => null],
        'params' => ['type' => 'text', 'null' => true, 'default' => null],
        'publish_start' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'publish_end' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
        '_options' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB']
    ];

    public $records = [
        [
            'id' => 5,
            'parent_id' => null,
            'menu_id' => 4,
            'title' => 'About',
            'class' => 'about',
            'description' => '',
            'link' => 'plugin:Vamshop/Nodes|controller:Nodes|action:view|type:page|slug:about',
            'target' => '',
            'rel' => '',
            'status' => 1,
            'lft' => 3,
            'rght' => 4,
            'visibility_roles' => '',
            'params' => '',
            'updated' => '2018-10-06 23:14:21',
            'created' => '2018-08-19 12:23:33'
        ],
        [
            'id' => 6,
            'parent_id' => null,
            'menu_id' => 4,
            'title' => 'Contact',
            'class' => 'contact',
            'description' => '',
            'link' => 'plugin:Vamshop/Contacts|controller:Contacts|action:view|contact',
            'target' => '',
            'rel' => '',
            'status' => 1,
            'lft' => 5,
            'rght' => 6,
            'visibility_roles' => '',
            'params' => '',
            'updated' => '2018-10-06 23:14:45',
            'created' => '2018-08-19 12:34:56'
        ],
        [
            'id' => 7,
            'parent_id' => null,
            'menu_id' => 3,
            'title' => 'Home',
            'class' => 'home',
            'description' => '',
            'link' => '/',
            'target' => '',
            'rel' => '',
            'status' => 1,
            'lft' => 1,
            'rght' => 2,
            'visibility_roles' => '',
            'params' => '',
            'updated' => '2018-10-06 21:17:06',
            'created' => '2018-09-06 21:32:54'
        ],
        [
            'id' => 8,
            'parent_id' => null,
            'menu_id' => 3,
            'title' => 'About',
            'class' => 'about',
            'description' => '',
            'link' => '/about',
            'target' => '',
            'rel' => '',
            'status' => 1,
            'lft' => 3,
            'rght' => 6,
            'visibility_roles' => '',
            'params' => '',
            'updated' => '2018-09-12 03:45:53',
            'created' => '2018-09-06 21:34:57'
        ],
        [
            'id' => 9,
            'parent_id' => 8,
            'menu_id' => 3,
            'title' => 'Child link',
            'class' => 'child-link',
            'description' => '',
            'link' => '#',
            'target' => '',
            'rel' => '',
            'status' => 0,
            'lft' => 4,
            'rght' => 5,
            'visibility_roles' => '',
            'params' => '',
            'updated' => '2018-10-06 23:13:06',
            'created' => '2018-09-12 03:52:23'
        ],
        [
            'id' => 10,
            'parent_id' => null,
            'menu_id' => 5,
            'title' => 'Site Admin',
            'class' => 'site-admin',
            'description' => '',
            'link' => '/admin',
            'target' => '',
            'rel' => '',
            'status' => 1,
            'lft' => 1,
            'rght' => 2,
            'visibility_roles' => '',
            'params' => '',
            'updated' => '2018-09-12 06:34:09',
            'created' => '2018-09-12 06:34:09'
        ],
        [
            'id' => 11,
            'parent_id' => null,
            'menu_id' => 5,
            'title' => 'Log out',
            'class' => 'log-out',
            'description' => '',
            'link' => '/users/logout',
            'target' => '',
            'rel' => '',
            'status' => 1,
            'lft' => 7,
            'rght' => 8,
            'visibility_roles' => '[\"1\",\"2\"]',
            'params' => '',
            'updated' => '2018-09-12 06:35:22',
            'created' => '2018-09-12 06:34:41'
        ],
        [
            'id' => 12,
            'parent_id' => null,
            'menu_id' => 6,
            'title' => 'Vamshop',
            'class' => 'vamshop',
            'description' => '',
            'link' => 'http://www.vamshop.com',
            'target' => '',
            'rel' => '',
            'status' => 1,
            'lft' => 3,
            'rght' => 4,
            'visibility_roles' => '',
            'params' => '',
            'updated' => '2018-09-12 23:31:59',
            'created' => '2018-09-12 23:31:59'
        ],
        [
            'id' => 14,
            'parent_id' => null,
            'menu_id' => 6,
            'title' => 'CakePHP',
            'class' => 'cakephp',
            'description' => '',
            'link' => 'http://www.cakephp.org',
            'target' => '',
            'rel' => '',
            'status' => 1,
            'lft' => 1,
            'rght' => 2,
            'visibility_roles' => '',
            'params' => '',
            'updated' => '2018-10-07 03:25:25',
            'created' => '2018-09-12 23:38:43'
        ],
        [
            'id' => 15,
            'parent_id' => null,
            'menu_id' => 3,
            'title' => 'Contact',
            'class' => 'contact',
            'description' => '',
            'link' => 'plugin:vamshop/Contacts|controller:Contacts|action:view|contact',
            'target' => '',
            'rel' => '',
            'status' => 1,
            'lft' => 7,
            'rght' => 8,
            'visibility_roles' => '',
            'params' => '',
            'updated' => '2018-09-16 07:54:13',
            'created' => '2018-09-16 07:53:33'
        ],
        [
            'id' => 16,
            'parent_id' => null,
            'menu_id' => 5,
            'title' => 'Entries (RSS)',
            'class' => 'entries-rss',
            'description' => '',
            'link' => '/nodes/promoted.rss',
            'target' => '',
            'rel' => '',
            'status' => 1,
            'lft' => 3,
            'rght' => 4,
            'visibility_roles' => '',
            'params' => '',
            'updated' => '2018-10-27 17:46:22',
            'created' => '2018-10-27 17:46:22'
        ],
        [
            'id' => 17,
            'parent_id' => null,
            'menu_id' => 5,
            'title' => 'Comments (RSS)',
            'class' => 'comments-rss',
            'description' => '',
            'link' => '/comments.rss',
            'target' => '',
            'rel' => '',
            'status' => 1,
            'lft' => 5,
            'rght' => 6,
            'visibility_roles' => '',
            'params' => '',
            'updated' => '2018-10-27 17:46:54',
            'created' => '2018-10-27 17:46:54'
        ],
        [
            'id' => 18,
            'parent_id' => null,
            'menu_id' => 4,
            'title' => 'Public Link Only',
            'class' => 'public-link-only',
            'description' => '',
            'link' => '/public-link-only',
            'target' => '',
            'rel' => '',
            'status' => 1,
            'lft' => 7,
            'rght' => 8,
            'visibility_roles' => '["3"]',
            'params' => '',
            'updated' => '2018-10-27 17:46:54',
            'created' => '2018-10-27 17:46:54'
        ],
    ];
}
