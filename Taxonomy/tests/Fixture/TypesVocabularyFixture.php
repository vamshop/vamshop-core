<?php

namespace Vamshop\Taxonomy\Test\Fixture;

use Vamshop\Core\TestSuite\VamshopTestFixture;

class TypesVocabularyFixture extends VamshopTestFixture
{

    public $name = 'TypesVocabulary';

    public $fields = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10],
        'type_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10],
        'vocabulary_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10],
        'weight' => ['type' => 'integer', 'null' => true, 'default' => null],
        '_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']], 'PRIMARY' => ['type' => 'unique', 'columns' => 'id']],
        '_options' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB']
    ];

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
