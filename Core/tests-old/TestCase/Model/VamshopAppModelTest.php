<?php
namespace Vamshop\Core\Test\TestCase\Model;

use App\Controller\Component\AuthComponent;
use App\Model\Model;
use App\Model\User;
use Cake\ORM\TableRegistry;
use Vamshop\Model\VamshopAppModel;
use Vamshop\Core\TestSuite\VamshopTestCase;
use Vamshop\Users\Model\Table\UsersTable;

/**
 * VamshopAppModelTest file
 *
 * This file is to test the VamshopAppModel
 *
 * @category Test
 * @package  Vamshop
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class VamshopAppModelTest extends VamshopTestCase
{

/**
 * Fixtures
 *
 * @var array
 */
    public $fixtures = [
//		'plugin.vamshop\users.aco',
//		'plugin.vamshop\users.aro',
//		'plugin.vamshop\users.aros_aco',
//		'plugin.vamshop\users.role',
//		'plugin.vamshop\users.user',
//		'plugin.vamshop\settings.setting',
    ];

/**
 * User instance
 *
 * @var TestUser
 */
    public $User;

/**
 * @var UsersTable
 */
    public $usersTable;

/**
 * setUp method
 *
 * @return void
 */
    public function setUp()
    {
        parent::setUp();

        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

//		$this->User = ClassRegistry::init('Users.User');
        $this->usersTable = TableRegistry::get('Vamshop/Users.Users');
    }

/**
 * tearDown method
 *
 * @return void
 */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->User);
    }

/**
 * testValidName
 */
    public function testValidName()
    {
        $this->assertTrue($this->usersTable->validName(['name' => 'Kyle']));
        $this->assertFalse($this->usersTable->validName(['name' => 'what%is@this#i*dont!even']));
    }

/**
 * testValidAlias
 */
    public function testValidAlias()
    {
        $this->assertTrue($this->usersTable->validAlias(['name' => 'Kyle']));
        $this->assertFalse($this->usersTable->validAlias(['name' => 'Not an Alias']));
    }
}
