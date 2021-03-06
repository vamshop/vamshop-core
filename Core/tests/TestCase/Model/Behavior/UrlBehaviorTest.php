<?php

namespace Vamshop\Core\Test\TestCase\Model\Behavior;

use Cake\ORM\TableRegistry;
use Vamshop\Core\Link;
use Vamshop\Core\TestSuite\VamshopTestCase;

class UrlBehaviorTest extends VamshopTestCase
{

    public $fixtures = [
        'plugin.vamshop\core.things'
    ];

/**
 * setUp
 *
 * @return void
 */
    public function setUp()
    {
        parent::setUp();

        $this->Things = TableRegistry::get('Things');
    }

    public function testSingle()
    {
        $thing = $this->Things->findByTitle('First Article')->first();

        $this->assertEquals(new Link([
            'controller' => 'Things',
            'action' => 'view',
            1
        ]), $thing->url);
    }

    public function testMultiple()
    {
        $things = $this->Things->find('all')->toArray();

        $this->assertEquals(new Link([
            'controller' => 'Things',
            'action' => 'view',
            1
        ]), $things[0]->url);
        $this->assertEquals(new Link([
            'controller' => 'Things',
            'action' => 'view',
            2
        ]), $things[1]->url);
    }
}
