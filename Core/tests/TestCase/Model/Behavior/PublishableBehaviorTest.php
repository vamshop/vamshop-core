<?php

namespace Vamshop\Core\Test\TestCase\Model\Behavior;

use Vamshop\Core\TestSuite\VamshopTestCase;

class PublishableBehaviorTest extends VamshopTestCase
{

    public $fixtures = [
//		'plugin.vamshop\settings.setting',
//		'plugin.Vamshop\Core.order_record',
    ];

/**
 * setUp
 *
 * @return void
 */
    public function setUp()
    {
        parent::setUp();
//		$this->OrderRecord = ClassRegistry::init('OrderRecord');
//		$this->OrderRecord->Behaviors->load('Vamshop.Publishable', array(
//			'fields' => array(
//				'publish_start' => 'start',
//				'publish_end' => 'end',
//			),
//		));
    }

/**
 * tearDown
 *
 * @return void
 */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->OrderRecord);
//		ClassRegistry::flush();
    }

/**
 * testPeriodFilter
 */
    public function testPeriodFilter()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $results = $this->OrderRecord->find('all', [
            'date' => '2014-01-31 06:59:59',
        ]);
        $this->assertEquals(1, count($results));

        $results = $this->OrderRecord->find('all', [
            'date' => '2014-01-31 07:00:01',
        ]);
        $this->assertEquals(2, count($results));

        $results = $this->OrderRecord->find('all', [
            'date' => '2014-01-31 07:11:01',
        ]);
        $this->assertEquals(3, count($results));

        $results = $this->OrderRecord->find('all', [
            'date' => '2014-01-31 09:11:30',
        ]);
        $this->assertEquals(2, count($results));

        $results = $this->OrderRecord->find('all', [
            'date' => '2014-01-31 09:13:45',
        ]);
        $this->assertEquals(3, count($results));
    }
}
