<?php

namespace Vamshop\Acl\Test\Fixture;

use Vamshop\TestSuite\VamshopTestFixture;

class DepartmentFixture extends VamshopTestFixture
{

/**
 * fields property
 *
 * @var array
 */
    public $fields = [
        'id' => ['type' => 'integer'],
        'name' => ['type' => 'string', 'null' => false],
        '_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]]
    ];

/**
 * records property
 *
 * @var array
 */
    public $records = [
        ['name' => 'Development'],
        ['name' => 'Design'],
        ['name' => 'Management'],
        ['name' => 'Sales'],
        ['name' => 'Support']
    ];
}
