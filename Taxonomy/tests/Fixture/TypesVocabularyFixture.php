<?php

namespace Vamshop\Taxonomy\Test\Fixture;

use Vamshop\Core\TestSuite\VamshopTestFixture;

class TypesVocabularyFixture extends VamshopTestFixture
{

    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'type_id' => ['type' => 'integer', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'vocabulary_id' => ['type' => 'integer', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'weight' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'type_id' => ['type' => 'unique', 'columns' => ['type_id', 'vocabulary_id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    public $records = [
        [
            'id' => 31,
            'type_id' => 2,
            'vocabulary_id' => 2,
            'weight' => null
        ],
        [
            'id' => 30,
            'type_id' => 2,
            'vocabulary_id' => 1,
            'weight' => null
        ],
        [
            'id' => 25,
            'type_id' => 4,
            'vocabulary_id' => 2,
            'weight' => null
        ],
        [
            'id' => 24,
            'type_id' => 4,
            'vocabulary_id' => 1,
            'weight' => null
        ],
    ];
}
