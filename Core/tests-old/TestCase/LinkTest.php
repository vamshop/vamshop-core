<?php

namespace Vamshop\Core\Test\TestCase;

use Cake\TestSuite\TestCase;
use Vamshop\Core\Link;

class LinkTest extends TestCase
{
    public function testCreateFromLinkString()
    {
        $link = Link::createFromLinkString('plugin:Vamshop%2FNodes/controller:Nodes/action:promoted');

        $this->assertEquals('Vamshop/Nodes', $link['plugin']);
        $this->assertEquals('Nodes', $link['controller']);
        $this->assertEquals('promoted', $link['action']);
    }

    public function testToLinkString()
    {
        $link = new Link([
            'plugin' => 'Vamshop/Nodes',
            'controller' => 'Nodes',
            'action' => 'promoted'
        ]);

        $this->assertEquals('plugin:Vamshop%2FNodes/controller:Nodes/action:promoted', $link->toLinkString());
    }

    public function testGetUrl()
    {
        $link = new Link([
            'plugin' => 'Vamshop/Nodes',
            'controller' => 'Nodes',
            'action' => 'promoted'
        ]);

        $this->assertEquals([
            'plugin' => 'Vamshop/Nodes',
            'controller' => 'Nodes',
            'action' => 'promoted'
        ], $link->getUrl());

        $linkExample = new Link('http://example.com');

        $this->assertEquals('http://example.com', $linkExample->getUrl());
    }

    public function testToString()
    {
        $link = new Link([
            'plugin' => 'Vamshop/Nodes',
            'controller' => 'Nodes',
            'action' => 'promoted'
        ]);

        $this->assertEquals('plugin:Vamshop%2FNodes/controller:Nodes/action:promoted', (string)$link);

        $linkExample = new Link('http://example.com');

        $this->assertEquals('http://example.com', (string)$linkExample);
    }

    public function testObjectProperties()
    {
        $link = new Link([
            'plugin' => 'Vamshop/Nodes',
            'controller' => 'Nodes',
            'action' => 'promoted'
        ]);

        $this->assertNull($link->prefix);
        $this->assertEquals('Vamshop/Nodes', $link->plugin);
        $this->assertEquals('Nodes', $link->controller);
        $this->assertEquals('promoted', $link->action);
    }
}
