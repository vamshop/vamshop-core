<?php

namespace Vamshop\Core\Test\TestCase;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Network\Request;
use Cake\ORM\TableRegistry;
use Vamshop\Core\Router;
use Vamshop\Core\Plugin;
use Vamshop\Core\TestSuite\TestCase;

class VamshopRouterTest extends TestCase
{

    public $fixtures = [
//		'plugin.vamshop/settings.setting',
//		'plugin.taxonomy.vocabulary',
        'plugin.vamshop/taxonomy.type',
//		'plugin.taxonomy.types_vocabulary',
    ];

    public function setUp()
    {
        parent::setUp();

        // This test case is only valid for 2.3.x series
        $this->skipIf(version_compare(Configure::version(), '2.3.1', '<'));
    }

/**
 * testHomeRoute
 */
    public function testHomeRoute()
    {
        $promoted = [
            'plugin' => 'Vamshop/Nodes',
            'controller' => 'Nodes',
            'action' => 'promoted',
        ];
        $result = Router::connect('/', $promoted);

        $this->assertEquals(1, count($result));
        $this->assertNotEmpty($result[0]);
        $this->assertInstanceOf('Cake\\Routing\\Route\\Route', $result[0]);
        $reversed = Router::parse('/');
        $this->assertEquals($promoted, array_intersect_key($promoted, $reversed));

        // another route
        $index = [
            'plugin' => 'Vamshop/Nodes',
            'controller' => 'Nodes',
            'action' => 'index',
        ];
        $result = Router::connect('/nodes', $index);
        $this->assertEquals(2, count($result));
        $reversed = Router::parse('/');
        $this->assertEquals($promoted, array_intersect_key($promoted, $reversed));

        $terms = [
            'plugin' => 'Vamshop/Nodes',
            'controller' => 'Nodes',
            'action' => 'terms',
        ];
        $result = Router::connect('/', $terms);
        $this->assertEquals(3, count($result));

        // override '/' route
//		Router::promote();
        $reversed = Router::parse('/');
        $this->assertEquals($terms, array_intersect_key($terms, $reversed));
    }

    public function testContentType()
    {
        // Reload plugin routes
        Plugin::routes();

        $params = [
            'url' => [],
            'plugin' => 'Vamshop/Nodes',
            'controller' => 'Nodes',
            'action' => 'index',
            'type' => 'blog',
        ];
        $result = Router::reverse($params);
        $this->assertEquals('/blog', $result);

        Router::reload();
        Router::contentType('blog');
        $result = Router::reverse($params);
        $this->assertEquals('/blog', $result);

        Router::contentType('page');
        $params = [
            'url' => [],
            'plugin' => 'Vamshop/Nodes',
            'controller' => 'Nodes',
            'action' => 'index',
            'type' => 'page',
        ];
        $result = Router::reverse($params);
        $this->assertEquals('/page', $result);

        Router::$initialized = false;
    }

    public function testRoutableContentTypes()
    {
        // Reload plugin routes
        Plugin::routes();

        $table = TableRegistry::get('Vamshop/Taxonomy.Types');
        $type = $table->save($table->newEntity([
            'title' => 'Press Release',
            'alias' => 'press-release',
            'description' => '',
        ]));
        $table->save($type);
        Cache::clear(false, 'vamshop_types');
        $type = $table->findByAlias('press-release')->first();
        Router::routableContentTypes();

        $params = [
            'url' => [],
            'plugin' => 'Vamshop/Nodes',
            'controller' => 'Nodes',
            'action' => 'index',
            'type' => 'press-release',
        ];
        $result = Router::reverse($params);
        $this->assertEquals('/press-release', $result);

        $type->params = [
            'routes' => true
        ];
        $table->save($type);
        Cache::clear(false, 'vamshop_types');
        Router::reload();
        Router::routableContentTypes();

        $result = Router::reverse($params);
        $this->assertEquals('/press-release', $result);
    }

/**
 * testWhitelistedDetectorWithInvalidIp
 */
    public function testWhitelistedDetectorWithInvalidIp()
    {
        $request = $this->getMockBuilder(Request::class)
            ->setMethods(['clientIp'])
            ->getMock();
        $request->addDetector('whitelisted', ['Vamshop\\Core\\Router', 'isWhitelistedRequest']);

        Configure::write('Site.ipWhitelist', '127.0.0.2');
        $request->expects($this->once())
            ->method('clientIp')
            ->will($this->returnValue('8.8.8.8'));
        $this->assertFalse($request->is('whitelisted'));
    }

/**
 * testWhitelistedDetectorWithValidIp
 */
    public function testWhitelistedDetectorWithValidIp()
    {
        $request = $this->getMockBuilder(Request::class)
            ->setMethods(['clientIp'])
            ->getMock();
        $request->addDetector('whitelisted', ['Vamshop\\Core\\Router', 'isWhitelistedRequest']);

        Configure::write('Site.ipWhitelist', '127.0.0.2');
        $request->expects($this->once())
            ->method('clientIp')
            ->will($this->returnValue('127.0.0.2'));
        $this->assertTrue($request->is('whitelisted'));
    }
}
