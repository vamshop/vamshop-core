<?php

namespace Vamshop\Taxonomy\Test\Fixture;

use Vamshop\Core\TestSuite\VamshopTestFixture;

class ModelTaxonomyFixture extends VamshopTestFixture
{

    public $name = 'ModelTaxonomy';

    public $fields = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 20],
        'model' => ['type' => 'string', 'null' => false, 'default' => 'Node', 'length' => 50],
        'foreign_key' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20],
        'taxonomy_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 20],
        '_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']], 'PRIMARY' => ['type' => 'unique', 'columns' => 'id']],
        '_options' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB']
    ];

    public $records = [
        [
            'id' => 1,
            'model' => 'Node',
            'foreign_key' => 1,
            'taxonomy_id' => 1
        ],
    ];
}
