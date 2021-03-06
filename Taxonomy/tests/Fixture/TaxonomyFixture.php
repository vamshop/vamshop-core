<?php

namespace Vamshop\Taxonomy\Test\Fixture;

use Vamshop\Core\TestSuite\VamshopTestFixture;

class TaxonomyFixture extends VamshopTestFixture
{

    public $name = 'Taxonomy';

    public $fields = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 20],
        'parent_id' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 20],
        'term_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10],
        'vocabulary_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10],
        'lft' => ['type' => 'integer', 'null' => true, 'default' => null],
        'rght' => ['type' => 'integer', 'null' => true, 'default' => null],
        '_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']], 'PRIMARY' => ['type' => 'unique', 'columns' => 'id']],
        '_options' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB']
    ];

    public $records = [
        [
            'id' => 1,
            'parent_id' => null,
            'term_id' => 1,
            'vocabulary_id' => 1,
            'lft' => 1,
            'rght' => 2
        ],
        [
            'id' => 2,
            'parent_id' => null,
            'term_id' => 2,
            'vocabulary_id' => 1,
            'lft' => 3,
            'rght' => 4
        ],
        [
            'id' => 3,
            'parent_id' => null,
            'term_id' => 3,
            'vocabulary_id' => 2,
            'lft' => 1,
            'rght' => 2
        ],
    ];
}
