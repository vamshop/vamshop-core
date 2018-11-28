<?php

namespace Vamshop\Core\Test\TestCase;

use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Vamshop\Core\Status;
use Vamshop\Core\TestSuite\VamshopTestCase;

class VamshopStatusTest extends VamshopTestCase implements EventListenerInterface
{
    public function implementedEvents()
    {
        return [
            'Vamshop.Status.setup' => [
                'callable' => 'onVamshopStatusSetup',
            ],
        ];
    }

/**
 * onVamshopStatusSetup
 */
    public function onVamshopStatusSetup($event)
    {
        $event->data['publishing'][4] = 'Added by event handler';
    }

/**
 * setUp
 */
    public function setUp()
    {
        EventManager::instance()->attach($this);
        $this->VamshopStatus = new Status();
    }

/**
 * tearDown
 */
    public function tearDown()
    {
        EventManager::instance()->detach($this);
        unset($this->VamshopStatus);
    }

/**
 * testByDescription
 */
/*    public function testByDescription()
    {
        $result = $this->VamshopStatus->byDescription('Published');
        $this->assertEquals(1, $result);
    }*/

/**
 * testById
 */
/*    public function testById()
    {
        $result = $this->VamshopStatus->byId(2);
        $this->assertEquals('Preview', $result);
    }*/

/**
 * testStatuses
 */
/*    public function testStatuses()
    {
        $result = $this->VamshopStatus->statuses();
        $this->assertTrue(count($result) >= 4);
    }*/

/**
 * testStatus
 */
/*    public function testStatus()
    {
        $expected = [Status::PUBLISHED];
        $result = $this->VamshopStatus->status();
        $this->assertEquals($expected, $result);
    }*/

/**
 * modifyStatus callback
 */
/*    public function modifyStatus($event)
    {
        switch ($event->data['accessType']) {
            case 'webmaster':
                if (!in_array(Status::PREVIEW, $event->data['values'])) {
                    $event->data['values'][] = Status::PREVIEW;
                }
                break;
            default:
                $event->data['values'] = [null];
                break;
        }
    }*/

/**
 * testStatusModifiedByEventHandler
 */
/*    public function testStatusModifiedByEventHandler()
    {
        $callback = [$this, 'modifyStatus'];
        EventManager::instance()->on($this);
        EventManager::instance()->on('Vamshop.Status.status', $callback);

        // test status is modified for 'webmaster' type by event handler
        $expected = [Status::PUBLISHED, Status::PREVIEW];
        $this->VamshopStatus = new Status();
        $result = $this->VamshopStatus->status(1, 'publishing', 'webmaster');
        $this->assertEquals($expected, $result);

        // test status is emptied for unknown type
        $expected = [null];
        $result = $this->VamshopStatus->status(1, 'publishing', 'bogus');
        $this->assertEquals($expected, $result);

        EventManager::instance()->on('Vamshop.Status.status', $callback);
    }*/

/**
 * testArrayAccessUsage
 */
/*    public function testArrayAccessUsage()
    {
        $newIndex = 5;
        $count = count($this->VamshopStatus->statuses());
        $this->VamshopStatus['publishing'][$newIndex] = 'New status';
        $this->assertEquals($count + 1, count($this->VamshopStatus->statuses()));
        unset($this->VamshopStatus['publishing'][$newIndex]);
        $this->assertEquals($count, count($this->VamshopStatus->statuses()));
        $this->assertFalse(isset($this->VamshopStatus['publishing'][$newIndex]));
    }*/
}
