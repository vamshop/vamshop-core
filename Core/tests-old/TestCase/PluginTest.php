<?php

namespace Vamshop\Core\Test\TestCase;

use Cake\Cache\Cache;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Vamshop\Core\Plugin;
use Vamshop\Core\TestSuite\TestCase;

class PluginTest extends TestCase
{
    /**
     * @var \Vamshop\Core\Plugin
     */
    public $plugin;

    /**
     * @var \PDO Backup connection instance
     */
    public $connection;

    public function setUp()
    {
        parent::setUp();

        $this->plugin = $this->getMockBuilder(Plugin::class)
            ->setMethods([
                '_writeSetting',
                'needMigration',
            ])
            ->getMock();

        $this->_mapping = [
            1346748762 => [
                'version' => 1346748762,
                'name' => '1346748762_first',
                'class' => 'First',
                'type' => 'app',
                'migrated' => '2012-09-04 10:52:42'
            ],
            1346748933 => [
                'version' => 1346748933,
                'name' => '1346748933_addstatus',
                'class' => 'AddStatus',
                'type' => 'app',
                'migrated' => '2012-09-04 10:55:33'
            ]
        ];

        // Backup the PDO connection instance as the Migrations CakeAdapter replaces it with Phinx's.
        $this->connection = ConnectionManager::get('test')
            ->driver()
            ->connection();
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->plugin);

        // Restore the PDO connection instance
        ConnectionManager::get('test')->driver()->connection($this->connection);
    }

    protected function _getMockMigrationVersion()
    {
        return $this->getMockBuilder('MigrationVersion')
            ->setMethods([
                'getMapping',
                'run'
            ])
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testGetDataPluginNotActive()
    {
        $actives = Configure::read('Hook.bootstraps');
        Configure::write('Hook.bootstraps', '');

        $suppliers = $this->plugin->getData('Suppliers');

        $needed = [
            'name' => 'Suppliers',
            'description' => 'Suppliers plugin',
            'active' => false,
            'needMigration' => false
        ];
        $this->assertEquals($needed, $suppliers);

        Configure::write('Hook.bootstraps', $actives);
    }

    public function testGetDataPluginActive()
    {
/*        $actives = Configure::read('Hook.bootstraps');
        Configure::write('Hook.bootstraps', 'suppliers');

        $migrationVersion = $this->_getMockMigrationVersion();
        $vamshopPlugin = new Plugin($migrationVersion);

        $suppliers = $vamshopPlugin->getData('Suppliers');

        $needed = [
            'name' => 'Suppliers',
            'description' => 'Suppliers plugin',
            'active' => true,
            'needMigration' => false
        ];
        $this->assertEquals($needed, $suppliers);

        Configure::write('Hook.bootstraps', $actives);*/
    }

    public function testGetDataPluginNotExists()
    {
        $data = $this->plugin->getData('NotARealPlugin');
        $this->assertEquals(false, $data);
    }

    public function testGetDataWithEmptyJson()
    {
        $expected = [
            'needMigration' => false, 'active' => false, 'name' => 'EmptyJson',
        ];
        $data = $this->plugin->getData('EmptyJson');
        $this->assertEquals($expected, $data);
    }

    public function testGetDataWithMixedManifest()
    {
        $data = $this->plugin->getData('MixedManifest');
        $expected = [
            'active', 'dependencies', 'description', 'name', 'needMigration',
            'type', 'vendor',
        ];

        $keys = array_keys($data);
        sort($keys);

        $this->assertEquals($expected, $keys);
        $this->assertContains('test plugin with mixed', $data['description']);
        $this->assertEquals('vamshop-plugin', $data['type']);
        $this->assertEquals('MixedManifest', $data['name']);
    }


/*    public function testNeedMigrationPluginNotExists()
    {
        $migrationVersion = $this->_getMockMigrationVersion();
        $migrationVersion->expects($this->any())
            ->method('getMapping')
            ->will($this->returnValue(false));
        $vamshopPlugin = new Plugin($migrationVersion);
        $this->assertEquals(false, $vamshopPlugin->needMigration('Anything', true));
    }*/

    public function testNeedMigrationPluginNotActive()
    {
        $vamshopPlugin = new Plugin();
        $this->assertEquals(false, $vamshopPlugin->needMigration('Anything', false));
    }

    public function testNeedMigrationPluginNoMigration()
    {
        $this->markTestSkipped('This test needs to be ported to CakePHP 3.0');

        $migrationVersion = $this->_getMockMigrationVersion();
        $migrationVersion->expects($this->any())
            ->method('getMapping')
            ->will($this->returnValue($this->_mapping));
        $migrationVersion->expects($this->any())
            ->method('getVersion')
            ->will($this->returnValue(1346748933));
        $vamshopPlugin = new Plugin($migrationVersion);
        $this->assertEquals(false, $vamshopPlugin->needMigration('app', true));
    }

    public function testNeedMigrationPluginWithMigration()
    {
        $this->markTestSkipped('This test needs to be ported to CakePHP 3.0');

        $migrationVersion = $this->_getMockMigrationVersion();
        $migrationVersion->expects($this->any())
            ->method('getMapping')
            ->will($this->returnValue($this->_mapping));
        $migrationVersion->expects($this->any())
            ->method('getVersion')
            ->will($this->returnValue(1346748762));
        $vamshopPlugin = new Plugin($migrationVersion);
        $this->assertEquals(true, $vamshopPlugin->needMigration('app', true));
    }

    public function testMigratePluginNotNeedMigration()
    {
        $this->markTestSkipped('This test needs to be ported to CakePHP 3.0');

        $actives = Configure::read('Hook.bootstraps');
        Configure::write('Hook.bootstraps', 'Suppliers');

        $migrationVersion = $this->_getMockMigrationVersion();
        $migrationVersion->expects($this->any())
            ->method('getMapping')
            ->will($this->returnValue($this->_mapping));
        $vamshopPlugin = new Plugin($migrationVersion);

        $this->assertEquals(false, $vamshopPlugin->migrate('Suppliers'));

        Configure::read('Hook.bootstraps', $actives);
    }

/*    public function testMigratePluginWithMigration()
    {
        Plugin::load('Suppliers');

        $actives = Configure::read('Hook.bootstraps');
        Configure::write('Hook.bootstraps', 'Suppliers');

        $migrationVersion = $this->_getMockMigrationVersion();
        $migrationVersion->expects($this->any())
            ->method('getMapping')
            ->will($this->returnValue($this->_mapping));
        $migrationVersion->expects($this->any())
            ->method('run')
            ->with($this->logicalAnd($this->arrayHasKey('version'), $this->arrayHasKey('type')))
            ->will($this->returnValue(true));

        $vamshopPlugin = new Plugin($migrationVersion);

        $this->assertEquals(true, $vamshopPlugin->migrate('Suppliers'));

        Configure::read('Hook.bootstraps', $actives);
    }*/

/*    public function testMigratePluginWithMigrationError()
    {
        $this->markTestSkipped('This test needs to be ported to CakePHP 3.0');

        $actives = Configure::read('Hook.bootstraps');
        Configure::write('Hook.bootstraps', 'Suppliers');

        $migrationVersion = $this->_getMockMigrationVersion();
        $migrationVersion->expects($this->any())
            ->method('getMapping')
            ->will($this->returnValue($this->_mapping));
        $migrationVersion->expects($this->any())
            ->method('run')
            ->will($this->returnValue('An error message'));

        $vamshopPlugin = new Plugin($migrationVersion);

        $expectedErrors = ['An error message'];
        $this->assertEquals(false, $vamshopPlugin->migrate('Suppliers'));
        $this->assertEquals($expectedErrors, $vamshopPlugin->migrationErrors);

        Configure::read('Hook.bootstraps', $actives);
    }*/

/*    public function testUnmigrate()
    {
        $this->markTestSkipped('This test needs to be ported to CakePHP 3.0');

        $actives = Configure::read('Hook.bootstraps');
        Configure::write('Hook.bootstraps', 'Suppliers');

        $migrationVersion = $this->_getMockMigrationVersion();
        $migrationVersion->expects($this->once())
            ->method('getMapping')
            ->will($this->returnValue($this->_mapping));
        $migrationVersion->expects($this->once())
            ->method('run')
            ->with($this->arrayHasKey('version', 'type', 'direction'))
            ->will($this->returnValue(true));

        $vamshopPlugin = new Plugin($migrationVersion);

        $this->assertEquals(true, $vamshopPlugin->unmigrate('Suppliers'));

        Configure::read('Hook.bootstraps', $actives);
    }*/

/*    public function testUnmigrateNoMapping()
    {
        $this->markTestSkipped('This test needs to be ported to CakePHP 3.0');

        $actives = Configure::read('Hook.bootstraps');
        Configure::write('Hook.bootstraps', 'Suppliers');

        $migrationVersion = $this->_getMockMigrationVersion();
        $migrationVersion->expects($this->once())
            ->method('getMapping')
            ->will($this->returnValue([]));
        $migrationVersion->expects($this->never())
            ->method('run')
            ->will($this->returnValue(false));

        $vamshopPlugin = new Plugin($migrationVersion);

        $this->assertEquals(false, $vamshopPlugin->unmigrate('Suppliers'));

        Configure::read('Hook.bootstraps', $actives);
    }*/

/**
 * testReorderBootstraps
 */
    public function testReorderBootstraps()
    {
        $bootstraps = explode(',', 'Vamshop/Settings,Vamshop/Taxonomy,Sites,Vamshop/Example');

        $expected = 'Vamshop/Example is already at the last position';
        $result = $this->plugin->move('down', 'Vamshop/Example', $bootstraps);
        $this->assertEquals($expected, $result);

        // core and bundled plugins must not be reordered
        $result = $this->plugin->move('up', 'Sites', $bootstraps);
        $this->assertEquals('Sites is already at the first position', $result);

        $bootstraps = explode(',', 'Vamshop/Example,Vamshop/Settings,Vamshop/Taxonomy,Sites');
        $result = $this->plugin->move('up', 'Vamshop/Example', $bootstraps);
        $this->assertEquals('Vamshop/Example is already at the first position', $result);
    }

/**
 * testReorderBootstrapsWithDependency
 */
    public function testReorderBootstrapsWithDependency()
    {
        $bootstraps = explode(',', 'Widgets,Editors');

        $expected = 'Plugin Editors depends on Widgets';
        $result = $this->plugin->move('up', 'Editors', $bootstraps);
        $this->assertEquals($expected, $result);

        $expected = 'Plugin Editors depends on Widgets';
        $result = $this->plugin->move('down', 'Widgets', $bootstraps);
        $this->assertEquals($expected, $result);
    }

/**
 * testDeleteEmptyPlugin
 * @expectedException InvalidArgumentException
 */
    public function testDeleteEmptyPlugin()
    {
        $this->plugin->delete(null);
    }

/**
 * testUsedBy
 */
    public function testUsedBy()
    {
        Cache::delete('pluginDeps', 'cached_settings');
        Plugin::load('Widgets');
        Plugin::load('Editors');
        Plugin::load('Articles');
        Plugin::cacheDependencies();
        $usedBy = $this->plugin->usedBy('Widgets');
        $this->assertTrue(in_array('Articles', $usedBy));
        $this->assertTrue(in_array('Editors', $usedBy));
        Plugin::unload('Articles');
        Plugin::unload('Editors');
        Plugin::unload('Widgets');
    }

    /**
     * @dataProvider pathDataProvider
     */
    public function testPath($plugin, $path, $expectedException = null)
    {
        $this->setExpectedException($expectedException);

        $this->assertEquals($path, Plugin::path($plugin));
    }

    /**
     * @dataProvider pathDataProvider
     */
    public function testAvailable($plugin, $path)
    {
        if ($path) {
            $this->assertTrue(Plugin::available($plugin));

            return;
        }

        $this->assertFalse(Plugin::available($plugin));
    }

    public function testEventsSinglePlugin()
    {
        Plugin::load('Shops', [
            'events' => true
        ]);

        $this->assertTrue(Plugin::events('Shops'));

        $this->assertEquals([
            'Shops.ShopsNodesEventHandler',
            'Shops.ShopsEventHandler' => [
                'options' => [
                    'priority' => 1
                ]
            ]
        ], Configure::read('EventHandlers'));
    }

    public function testEventsAllPlugins()
    {
        Plugin::load('Shops', [
            'events' => true
        ]);

        $this->assertTrue(Plugin::events());

        $this->assertContains('Shops.ShopsNodesEventHandler', Configure::read('EventHandlers'));
    }

    public function pathDataProvider()
    {
        return [
            // Internal Vamshop plugins based on Vamshop/Core path
            ['Vamshop/Core', VAMSHOP_INCLUDE_PATH  . 'Core' . DS],
            ['Vamshop', VAMSHOP_INCLUDE_PATH . 'Nodes' . DS],
            // Plugin paths from the 'plugins' Configure key
            ['BootstrapUI', VENDOR .  'friendsofcake' . DS . 'bootstrap-ui' . DS],
            // Plugin path from the plugins directory
            ['Shops', App::path('Plugin')[0] . 'Shops'],
            // A non existing plugin
            ['NonExisting', false, 'Cake\\Core\\Exception\\MissingPluginException']
        ];
    }
}
