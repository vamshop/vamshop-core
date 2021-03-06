<?php

namespace Vamshop\Core\Test\Fixture;

use Vamshop\Core\TestSuite\VamshopTestFixture;

class OrderRecordFixture extends VamshopTestFixture
{

    public $fields = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null],
        'title' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 60],
        'weight' => ['type' => 'integer', 'null' => false, 'default' => null],
        'created' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'updated' => ['type' => 'datetime', 'null' => false, 'default' => null],
        'start' => ['type' => 'datetime', 'null' => true, 'default' => null],
        'end' => ['type' => 'datetime', 'null' => true, 'default' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
        '_options' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB']
    ];

    public $records = [
        [
            'id' => 1,
            'title' => 'Random record',
            'weight' => 1,
            'updated' => '2009-11-02 21:37:38',
            'created' => '2009-11-02 20:52:00'
        ],
        [
            'id' => 2,
            'title' => 'Second record',
            'weight' => 1,
            'updated' => '2009-11-02 21:37:38',
            'created' => '2009-11-02 20:52:00',
            'start' => '2014-01-31 07:00:00',
            'end' => '2014-01-31 08:00:00',
        ],
        [
            'id' => 3,
            'title' => 'Third record',
            'weight' => 1,
            'updated' => '2009-11-02 21:37:38',
            'created' => '2009-11-02 20:52:00',
            'start' => '2014-01-31 07:10:00',
            'end' => '2014-01-31 08:00:00',
        ],
        [
            'id' => 4,
            'title' => 'Fourth record',
            'weight' => 1,
            'updated' => '2009-11-02 21:37:38',
            'created' => '2009-11-02 20:52:00',
            'start' => '2014-01-31 09:10:00',
        ],
        [
            'id' => 5,
            'title' => 'Fifth record',
            'weight' => 1,
            'updated' => '2009-11-02 21:37:38',
            'created' => '2009-11-02 20:52:00',
            'start' => '2014-01-31 09:12:00',
            'end' => '2014-01-31 09:15:00',
        ],
    ];
}
