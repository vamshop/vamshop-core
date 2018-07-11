<?php

namespace Vamshop\Nodes\Test\TestCase\View\Helper;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\View\View;
use Vamshop\Core\Vamshop;
use Vamshop\Core\Event\EventManager;
use Vamshop\Core\Plugin;
use Vamshop\Core\TestSuite\TestCase;
use Vamshop\Nodes\View\Helper\NodesHelper;

/**
 * @property \Vamshop\Nodes\View\Helper\NodesHelper helper
 * @property \Cake\View\View view
 * @property \Vamshop\Nodes\Model\Table\NodesTable Nodes
 */
class NodesHelperTest extends TestCase
{
    public $fixtures = [
        'plugin.vamshop/users.role',
        'plugin.vamshop/users.user',
        'plugin.vamshop/users.aco',
        'plugin.vamshop/users.aro',
        'plugin.vamshop/users.aros_aco',
        'plugin.vamshop/blocks.block',
        'plugin.vamshop/comments.comment',
        'plugin.vamshop/contacts.contact',
        'plugin.vamshop/translate.i18n',
        'plugin.vamshop/settings.language',
        'plugin.vamshop/menus.link',
        'plugin.vamshop/menus.menu',
        'plugin.vamshop/contacts.message',
        'plugin.vamshop/meta.meta',
        'plugin.vamshop/nodes.node',
        'plugin.vamshop/taxonomy.model_taxonomy',
        'plugin.vamshop/blocks.region',
        'plugin.vamshop/core.settings',
        'plugin.vamshop/taxonomy.taxonomy',
        'plugin.vamshop/taxonomy.term',
        'plugin.vamshop/taxonomy.type',
        'plugin.vamshop/taxonomy.types_vocabulary',
        'plugin.vamshop/taxonomy.vocabulary',
    ];

    public function setUp()
    {
        parent::setUp();

        Plugin::routes();
        Plugin::events();
        EventManager::loadListeners();

        $this->view = new View;
        $this->helper = new NodesHelper($this->view);
        $this->Nodes = TableRegistry::get('Vamshop/Nodes.Nodes');
    }

    /**
     * Test [node] shortcode
     */
    public function testNodeShortcode()
    {
        $content = '[node:recent_posts conditions="Nodes.type:blog" order="Nodes.id DESC" limit="5"]';
        $this->view->viewVars['nodesForLayout']['recent_posts'] = [
            $this->Nodes->get(1),
        ];
        Vamshop::dispatchEvent('Helper.Layout.beforeFilter', $this->view, ['content' => &$content]);
        $this->assertContains('node-list-recent_posts', $content);
        $this->assertContains('class="node-list"', $content);
    }

    public function testNodesUrl()
    {
        $node = $this->Nodes->get(1);
        $expected = '/blog/hello-world';
        $this->assertEquals($expected, $this->helper->url($node));

        $fullBaseUrl = Configure::read('App.fullBaseUrl');
        $result = $this->helper->url($node, true);
        $this->assertEquals($fullBaseUrl . $expected, $result);
    }
}
