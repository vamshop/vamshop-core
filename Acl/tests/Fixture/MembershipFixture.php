<?php

namespace Vamshop\Acl\Test\Fixture;

use Vamshop\TestSuite\VamshopTestFixture;

class MembershipFixture extends VamshopTestFixture
{

/**
 * fields property
 *
 * @var array
 */
    public $fields = [
        'id' => ['type' => 'integer'],
        'employee_id' => ['type' => 'integer', 'null' => false],
        'department_id' => ['type' => 'integer', 'null' => false],
        '_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]]
    ];

/**
 * records property
 *
 * @var array
 */
    public $records = [
        ['employee_id' => 1, 'department_id' => 1],
        ['employee_id' => 1, 'department_id' => 4],
        ['employee_id' => 4, 'department_id' => 3],
    ];
}
