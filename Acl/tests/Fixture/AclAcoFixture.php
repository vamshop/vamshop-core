<?php
/**
 * Short description for file.
 *
 * PHP 5
 *
 * CakePHP(tm) Tests <http://book.cakephp.org/view/1196/Testing>
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://book.cakephp.org/view/1196/Testing CakePHP(tm) Tests
 * @package       Cake.Test.Fixture
 * @since         CakePHP(tm) v 1.2.0.4667
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace Vamshop\Acl\Test\Fixture;

use Vamshop\TestSuite\VamshopTestFixture;

class AclAcoFixture extends VamshopTestFixture
{

    public $name = 'Aco';

/**
 * fields property
 *
 * @var array
 */
    public $fields = [
        'id' => ['type' => 'integer'],
        'parent_id' => ['type' => 'integer', 'length' => 10, 'null' => true],
        'model' => ['type' => 'string', 'null' => true],
        'foreign_key' => ['type' => 'integer', 'length' => 10, 'null' => true],
        'alias' => ['type' => 'string', 'default' => ''],
        'lft' => ['type' => 'integer', 'length' => 10, 'null' => true],
        'rght' => ['type' => 'integer', 'length' => 10, 'null' => true],
        '_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]]
    ];

/**
 * records property
 *
 * @var array
 */
    public $records = [
        ['parent_id' => null, 'model' => null, 'foreign_key' => null, 'alias' => 'Controllers', 'lft' => 1, 'rght' => 24],
        ['parent_id' => 1, 'model' => null, 'foreign_key' => null, 'alias' => 'Controller1', 'lft' => 2, 'rght' => 9],
        ['parent_id' => 2, 'model' => null, 'foreign_key' => null, 'alias' => 'action1', 'lft' => 3, 'rght' => 6],
        ['parent_id' => 3, 'model' => null, 'foreign_key' => null, 'alias' => 'record1', 'lft' => 4, 'rght' => 5],
        ['parent_id' => 2, 'model' => null, 'foreign_key' => null, 'alias' => 'action2', 'lft' => 7, 'rght' => 8],
        ['parent_id' => 1, 'model' => null, 'foreign_key' => null, 'alias' => 'Controller2', 'lft' => 10, 'rght' => 17],
        ['parent_id' => 6, 'model' => null, 'foreign_key' => null, 'alias' => 'action1', 'lft' => 11, 'rght' => 14],
        ['parent_id' => 7, 'model' => null, 'foreign_key' => null, 'alias' => 'record1', 'lft' => 12, 'rght' => 13],
        ['parent_id' => 6, 'model' => null, 'foreign_key' => null, 'alias' => 'action2', 'lft' => 15, 'rght' => 16],
        ['parent_id' => 1, 'model' => null, 'foreign_key' => null, 'alias' => 'Users', 'lft' => 18, 'rght' => 23],
        ['parent_id' => 10, 'model' => null, 'foreign_key' => null, 'alias' => 'Users', 'lft' => 19, 'rght' => 22],
        ['parent_id' => 11, 'model' => null, 'foreign_key' => null, 'alias' => 'view', 'lft' => 20, 'rght' => 21],
        ['parent_id' => null, 'model' => null, 'foreign_key' => null, 'alias' => 'Models', 'lft' => 25, 'rght' => 48],
        ['parent_id' => 13, 'model' => null, 'foreign_key' => null, 'alias' => 'User', 'lft' => 26, 'rght' => 33],
        ['parent_id' => 21, 'model' => 'Employee', 'foreign_key' => 1, 'alias' => '', 'lft' => 38, 'rght' => 39],
        ['parent_id' => 14, 'model' => 'Employee', 'foreign_key' => 2, 'alias' => '', 'lft' => 27, 'rght' => 28],
        ['parent_id' => 14, 'model' => 'Employee', 'foreign_key' => 3, 'alias' => '', 'lft' => 29, 'rght' => 30],
        ['parent_id' => 14, 'model' => 'Employee', 'foreign_key' => 4, 'alias' => '', 'lft' => 31, 'rght' => 32],
        ['parent_id' => 13, 'model' => null, 'foreign_key' => null, 'alias' => 'Group', 'lft' => 34, 'rght' => 47],
        ['parent_id' => 19, 'model' => 'Department', 'foreign_key' => 1, 'alias' => '', 'lft' => 35, 'rght' => 36],
        ['parent_id' => 19, 'model' => 'Department', 'foreign_key' => 2, 'alias' => '', 'lft' => 37, 'rght' => 40],
        ['parent_id' => 19, 'model' => 'Department', 'foreign_key' => 3, 'alias' => '', 'lft' => 41, 'rght' => 42],
        ['parent_id' => 19, 'model' => 'Department', 'foreign_key' => 4, 'alias' => '', 'lft' => 43, 'rght' => 44],
        ['parent_id' => 19, 'model' => 'Department', 'foreign_key' => 5, 'alias' => '', 'lft' => 45, 'rght' => 46],
    ];
}
