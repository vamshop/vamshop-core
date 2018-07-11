<?php

namespace Vamshop\Core\Test\TestCase;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\ORM\TableRegistry;
use Vamshop\Core\Vamshop;
use Vamshop\Core\TestSuite\VamshopTestCase;
use Vamshop\Core\TestSuite\TestCase;

class VamshopTest extends TestCase
{

    public $fixtures = [
//		'plugin.croogo/settings.setting',
    ];

    public function testCrossPluginHooks()
    {
        Plugin::load(['Shops', 'Suppliers'], [
            'bootstrap' => true,
        ]);

        $Orders = TableRegistry::get('Shops.Orders');
        $this->assertTrue($Orders->monitored);
    }

/**
 * test Vamshop::hookApiComponent
 */
    public function testHookApiComponent()
    {
        $hooks = Configure::read('Hook.controller_properties');
        Configure::write('Hook.controller_properties', []);

        Vamshop::hookApiComponent('Vamshop/Example.Example', 'Example.ExampleApi');
        Vamshop::hookApiComponent('Vamshop/Example.Example', [
            'Users.UserApi' => [
                'priority' => 2,
            ],
        ]);

        $expected = [
            'Vamshop\Example\Controller\ExampleController' => [
                '_apiComponents' => [
                    'Example.ExampleApi' => [
                        'priority' => 8,
                    ],
                    'Users.UserApi' => [
                        'priority' => 2,
                    ],
                ],
            ],
        ];
        $result = Configure::read('Hook.controller_properties');
        $this->assertEquals($expected, $result);

        Configure::write('Hook.controller_properties', $hooks);
    }
}
