<?php

namespace Vamshop\Acl\Test\TestCase\Controller;

use Vamshop\TestSuite\VamshopControllerTestCase;

/**
 * AclActionsController Test
 */
class AclActionsControllerTest extends VamshopControllerTestCase
{

/**
 * fixtures
 *
 * @var array
 */
    public $fixtures = [
        'plugin.users.aro',
        'plugin.users.aco',
        'plugin.users.aros_aco',
        'plugin.users.role',
        'plugin.menus.menu',
        'plugin.taxonomy.type',
        'plugin.taxonomy.types_vocabulary',
        'plugin.taxonomy.vocabulary',
        'plugin.settings.setting',
    ];

/**
 * testGenerateActions
 *
 * @return void
 */
    public function testGenerateActions()
    {
        $AclActions = $this->generate('Acl.AclActions', [
            'methods' => [
                'redirect',
            ],
            'components' => [
                'Auth' => ['user'],
                'Session',
                'Menus.Menus',
                'Blocks.Blocks',
                'Nodes.Nodes',
                'Taxonomy.Taxonomies',
            ],
        ]);
        $AclActions->Auth
            ->staticExpects($this->any())
            ->method('user')
            ->will($this->returnValue(['id' => 2, 'role_id' => 1]));
        $AclActions->Session
            ->expects($this->any())
            ->method('setFlash')
            ->with(
                $this->matchesRegularExpression('/(Created Aco node:)|.*Aco Update Complete.*|(Skipped Aco node:)/'),
                $this->equalTo('flash'),
                $this->anything()
            );
        $AclActions
            ->expects($this->once())
            ->method('redirect');
        $node = $AclActions->Acl->Aco->node('controllers/Nodes');
        $this->assertNotEmpty($node);
        $AclActions->Acl->Aco->removeFromTree($node[0]['Aco']['id']);
        $this->testAction('/admin/acl/acl_actions/generate');
    }
}
