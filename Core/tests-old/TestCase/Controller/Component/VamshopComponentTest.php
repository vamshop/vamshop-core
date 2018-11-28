<?php

namespace Vamshop\Core\Test\TestCase\Controller\Component;

use App\Controller\AppController;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Vamshop\Core\Controller\Component\VamshopComponent;
use Vamshop\Core\TestSuite\VamshopTestCase;
use Vamshop\Core\TestSuite\TestCase;

class MockVamshopComponent extends VamshopComponent
{

    public function startup(Event $event)
    {
        $this->_controller = $event->subject();
    }
}

class VamshopComponentTest extends TestCase
{

    public $fixtures = [
//		'plugin.vamshop/users.aco',
//		'plugin.vamshop/users.aro',
//		'plugin.vamshop/users.aros_aco',
//		'plugin.vamshop/settings.setting',
//		'plugin.vamshop/menus.menu',
//		'plugin.vamshop/menus.link',
//		'plugin.vamshop/users.role',
//		'plugin.vamshop/taxonomy.type',n
//		'plugin.vamshop/taxonomy.vocabulary',
//		'plugin.vamshop/taxonomy.types_vocabulary',
//		'plugin.vamshop/nodes.node',
    ];

    public $component = null;
    public $controller = null;

    public function setUp()
    {
        parent::setUp();

        // Setup our component and fake test controller
        $this->controller = $this->getMockBuilder(Controller::class)
            ->setMethods(['redirect'])
            ->setConstructorArgs([new Request, new Response])
            ->getMock();

        $registry = new ComponentRegistry($this->controller);
        $this->component = new VamshopComponent($registry);

//		$this->Controller = new Controller(new Request(), new Response());
////		$this->Controller->constructClasses();
//		$this->Controller->Vamshop = new MockVamshopComponent($this->Controller->components());
//		$this->Controller->components()->unload('Blocks');
//		$this->Controller->components()->unload('Menus');
//		$this->Controller->components()->set('Vamshop', $this->Controller->Vamshop);
//		$this->Controller->startupProcess();
    }

    public function testAddRemoveAcos()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $Aco = ClassRegistry::init('Aco');

        $this->Controller->Vamshop->addAco('VamshopTestController');
        $parent = $Aco->findByAlias('VamshopTestController');
        $this->assertNotEmpty($parent);

        $this->Controller->Vamshop->addAco('VamshopTestController/index');
        $child = $Aco->findByParentId($parent['Aco']['id']);
        $this->assertNotEmpty($child);

        $this->Controller->Vamshop->removeAco('VamshopTestController/index');
        $child = $Aco->findByParentId($parent['Aco']['id']);
        $this->assertEmpty($child);

        $this->Controller->Vamshop->removeAco('VamshopTestController');
        $parent = $Aco->findByAlias('VamshopTestController');
        $this->assertEmpty($parent);
    }

/**
 * testRedirect
 *
 * @return void
 * @dataProvider redirectData
 */
    public function testRedirect($expected, $url, $data = [], $indexUrl = [])
    {
        $this->controller->request->data = $data;
        $this->controller->expects($this->once())
            ->method('redirect')
            ->with($this->equalTo($expected));
        $VamshopComponent = new VamshopComponent(new ComponentRegistry());
        $VamshopComponent->startup(new Event(null, $this->controller));
        $VamshopComponent->redirect($url, null, true, $indexUrl);
    }

/**
 * redirectData
 *
 * @return array
 */
    public function redirectData()
    {
        return [
            ['vamshop.com', 'vamshop.com'],
            [['action' => 'index'], ['action' => 'edit', 1]],
            [['action' => 'edit', 1], ['action' => 'edit', 1], ['apply' => 'Apply']],
            [['action' => 'index', 1], ['action' => 'edit', 1], [], ['action' => 'index', 1]],
            [['action' => 'edit', 1], ['action' => 'edit', 1], ['apply' => 'Apply'], ['action' => 'index', 1]],
        ];
    }

    public function tearDown()
    {
        parent::tearDown();

        // Clean up after we're done
        unset($this->component, $this->controller);
    }
}
