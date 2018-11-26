<?php

namespace Vamshop\Menus\Test\TestCase\Controller\Component;

use Cake\Controller\Controller;
use Vamshop\TestSuite\VamshopControllerTestCase;

class MenusTestController extends Controller
{

    public $components = [
        'Auth',
        'Session',
        'Vamshop.Vamshop',
        'Blocks.Blocks',
        'Menus.Menus',
    ];

    public function beforeFilter()
    {
        $this->Auth->allow('index');
        parent::beforeFilter();
    }

    public function index()
    {
    }
}

class MenusComponentTest extends VamshopControllerTestCase
{

    public $fixtures = [
        'plugin.blocks.block',
        'plugin.blocks.region',
        'plugin.menus.menu',
        'plugin.menus.link',
    ];

    public function setUp()
    {
        $this->_paths = App::paths();
        $app = Plugin::path('Menus') . 'Test' . DS . 'test_app' . DS;
        App::build([
            'Controller' => [
                $app . 'Controller' . DS,
            ],
            'View' => [
                $app . 'View' . DS,
            ],
        ]);
        $this->generate('MenusTest');
    }

    public function tearDown()
    {
        App::paths($this->_paths);
        unset($this->controller);
    }

/**
 * test that public Links are displayed
 */
    public function testMenuGenerationForPublic()
    {
        $vars = $this->testAction('/index', [
            'return' => 'vars',
        ]);
        $result = Hash::extract(
            $vars['menusForLayout'],
            'footer.threaded.{n}.Link[title=Public Link Only]'
        );
        $this->assertResponseNotEmpty($result);
    }

/**
 * test that public Links are not displayed
 */
    public function testMenuGenerationForRegistered()
    {
        $this->controller->Session->write('Auth.User', ['id' => 3, 'role_id' => 2]);
        $vars = $this->testAction('/index', [
            'return' => 'vars',
        ]);
        $result = Hash::extract(
            $vars['menusForLayout'],
            'footer.threaded.{n}.Link[title=Public Link Only]'
        );
        $this->assertEmpty($result);
        $this->controller->Session->delete('Auth');
    }
}
