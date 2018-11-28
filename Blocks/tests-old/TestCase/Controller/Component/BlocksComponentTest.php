<?php

namespace Vamshop\Blocks\Test\TestCase\Controller\Component;

use Vamshop\Core\TestSuite\IntegrationTestCase;

class BlocksComponentTest extends IntegrationTestCase
{
    public $fixtures = [
        'plugin.vamshop/blocks.block',
        'plugin.vamshop/blocks.region',
        'plugin.vamshop/menus.menu',
        'plugin.vamshop/menus.link',
        'plugin.vamshop/taxonomy.type',
        'plugin.vamshop/taxonomy.vocabulary',
        'plugin.vamshop/taxonomy.taxonomy',
        'plugin.vamshop/taxonomy.term',
        'plugin.vamshop/taxonomy.model_taxonomy',
        'plugin.vamshop/comments.comment',
        'plugin.vamshop/meta.meta',
        'plugin.vamshop/nodes.node',
        'plugin.vamshop/users.role',
        'plugin.vamshop/users.user',
        'plugin.vamshop/users.aro',
        'plugin.vamshop/users.aco',
        'plugin.vamshop/users.aros_aco',
    ];

    /**
     * test that public Blocks are displayed
     */
    public function testBlockGenerationForPublic()
    {
        $this->user('yvonne');
        $this->get('/');

        $this->assertEmpty(collection($this->viewVariable('blocksForLayout')['right'])->match([
            'title' => 'Block Visible by Admin or Registered'
        ])->toArray(), '\'Block Visible by Admin or Registered\' should not be visible for public role');

        $this->assertNotEmpty(collection($this->viewVariable('blocksForLayout')['right'])->match([
            'title' => 'Block Visible by Public'
        ])->toArray(), '\'Block Visible by Public\' should be visible for public role');
    }

    /**
     * test that block are displayed for Registered
     */
    public function testBlockGenerationForRegistered()
    {
        $this->user('registered-user');

        $this->get('/');

        $this->assertEmpty(collection($this->viewVariable('blocksForLayout')['right'])->match([
            'title' => 'Block Visible by Public'
        ])->toArray(), '\'Block Visible by Public\' should not be visible for registered role');

        $this->assertNotEmpty(collection($this->viewVariable('blocksForLayout')['right'])->match([
            'title' => 'Block Visible by Admin or Registered'
        ])->toArray(), '\'Block Visible by Admin or Registered\' should be visible for registered role');
    }

    /**
     * test that block are displayed for Admin
     */
    public function testBlockGenerationForAdmin()
    {
        $this->user('admin');

        $this->get('/');

        $this->assertEmpty(collection($this->viewVariable('blocksForLayout')['right'])->match([
            'title' => 'Block Visible by Public'
        ])->toArray(), '\'Block Visible by Public\' should not be visible for registered role');

        $this->assertNotEmpty(collection($this->viewVariable('blocksForLayout')['right'])->match([
            'title' => 'Block Visible by Admin or Registered'
        ])->toArray(), '\'Block Visible by Admin or Registered\' should be visible for registered role');
    }
}
