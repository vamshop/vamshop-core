<?php

namespace Vamshop\Taxonomy\Test\Fixture;

use Vamshop\Core\TestSuite\VamshopTestFixture;

class TermFixture extends VamshopTestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'slug' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'updated' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'updated_by' => ['type' => 'integer', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'created_by' => ['type' => 'integer', 'length' => 20, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'slug' => ['type' => 'unique', 'columns' => ['slug'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
        [
            'id' => 1,
            'title' => 'Uncategorized',
            'slug' => 'uncategorized',
            'description' => '',
            'updated' => '2009-07-22 03:38:43',
            'created' => '2009-07-22 03:34:56'
        ],
        [
            'id' => 2,
            'title' => 'Announcements',
            'slug' => 'announcements',
            'description' => '',
            'updated' => '2010-05-16 23:57:06',
            'created' => '2009-07-22 03:45:37'
        ],
        [
            'id' => 3,
            'title' => 'mytag',
            'slug' => 'mytag',
            'description' => '',
            'updated' => '2009-08-26 14:42:43',
            'created' => '2009-08-26 14:42:43'
        ],
    ];
        parent::init();
    }
}
