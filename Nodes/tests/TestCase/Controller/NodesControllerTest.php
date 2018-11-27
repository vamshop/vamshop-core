<?php
namespace Vamshop\Nodes\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Vamshop\Core\Event\EventManager;
use Vamshop\Core\Plugin;
use Vamshop\Core\TestSuite\IntegrationTestCase;

/**
 * @property \Vamshop\Nodes\Model\Table\NodesTable Nodes
 */
class NodesControllerTest extends IntegrationTestCase
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

        $this->Nodes = TableRegistry::get('Vamshop/Nodes.Nodes');
    }

    public function testPromotedWithVisibilityRole()
    {
        $this->user('admin');

        $this->get('/promoted');

        $this->assertEquals(1, count([$this->viewVariable('nodes')]));
    }

    public function testIndexWithVisibilityRole()
    {
        $this->user('admin');

        $this->get('/node?type=page');

        $this->assertEquals(2, count([$this->viewVariable('nodes')]));
    }

    public function testViewFallback()
    {
        Plugin::load('Mytheme');
        Configure::write('Site.theme', 'Mytheme');

        $this->get('/node');

        $this->_controller->Vamshop->viewFallback(['index_blog']);
        $this->assertContains('index_blog', $this->_controller->viewBuilder()->template());
        $this->assertContains('Mytheme', $this->_controller->viewBuilder()->template());

        $this->get('/blog/hello-world');

        $this->_controller->Vamshop->viewFallback(['view_1', 'view_blog']);
        $this->assertContains('view_1.ctp', $this->_controller->viewBuilder()->template());
        $this->assertContains('Mytheme', $this->_controller->viewBuilder()->template());
    }

    /**
     * testViewFallback for core NodesController with default theme
     *
     * @return void
     */
    public function testViewFallbackWithDefaultTheme()
    {
        $this->get('/');

        $this->_controller->Vamshop->viewFallback('index_node');
        $this->assertContains('index_node.ctp', $this->_controller->viewBuilder()->template());
    }
}
