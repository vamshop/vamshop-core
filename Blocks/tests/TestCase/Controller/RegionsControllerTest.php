<?php

namespace Vamshop\Blocks\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Vamshop\Core\TestSuite\IntegrationTestCase;

/**
 * @property \Vamshop\Blocks\Model\Table\RegionsTable Regions
 */
class RegionsControllerTest extends IntegrationTestCase
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

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'admin',
                    'role_id' => 1,
                    'name' => 'Administrator',
                    'email' => 'you@your-site.com',
                    'website' => '/about'
                ]
            ]
        ]);

        $this->Regions = TableRegistry::get('Vamshop/Blocks.Regions');
    }

    public function testAdminIndex()
    {
        $this->get('/admin/blocks/regions/index');

        $this->assertResponseNotEmpty($this->viewVariable('displayFields'));
        $this->assertResponseNotEmpty($this->viewVariable('regions'));
    }

    public function testAdminAdd()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/admin/blocks/regions/add', [
            'title' => 'new_region',
            'alias' => 'new_region',
            'description' => 'A new region',
        ]);

        $this->assertRedirect();
        $this->assertFlash('Successfully created region');

        $region = $this->Regions
            ->findByAlias('new_region')
            ->first();
        $this->assertEquals('new_region', $region->title);
    }

    public function testAdminEdit()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/admin/blocks/regions/edit/4', [
            'id' => 4, // right
            'title' => 'right_modified',
        ]);

        $this->assertRedirect();
        $this->assertFlash('Successfully updated region');

        $region = $this->Regions
            ->findByAlias('right')
            ->first();
        $this->assertEquals('right_modified', $region->title);
    }

    public function testAdminDelete()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/admin/blocks/regions/delete/4');

        $this->assertRedirect();
        $this->assertFlash('Successfully deleted region');

        $region = (bool)$this->Regions
            ->findByAlias('right')
            ->count();
        $this->assertFalse($region);
    }
}
