<?php

namespace Vamshop\Extensions\Test\Fixture;

use Vamshop\TestSuite\VamshopTestFixture;

class MovieFixture extends VamshopTestFixture
{

/**
 * fields property
 *
 * @var array
 */
    public $fields = [
        'id' => ['type' => 'integer'],
        'title' => ['type' => 'string', 'null' => false],
        'year' => ['type' => 'integer', 'null' => false],
        'user_id' => ['type' => 'integer', 'null' => true],
        'created' => 'datetime',
        'updated' => 'datetime',
        '_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]]
    ];

/**
 * records property
 *
 * @var array
 */
    public $records = [
    ];
}
