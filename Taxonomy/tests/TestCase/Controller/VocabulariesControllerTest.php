<?php
namespace Vamshop\Taxonomy\Test\TestCase\Controller;

use Vamshop\TestSuite\VamshopControllerTestCase;
use Taxonomy\Controller\VocabulariesController;

/**
 * VocabulariesController Test
 */
class VocabulariesControllerTest extends VamshopControllerTestCase
{

/**
 * fixtures
 */
    public $fixtures = [
        'plugin.users.aco',
        'plugin.users.aro',
        'plugin.users.aros_aco',
        'plugin.blocks.block',
        'plugin.comments.comment',
        'plugin.contacts.contact',
        'plugin.translate.i18n',
        'plugin.settings.language',
        'plugin.menus.link',
        'plugin.menus.menu',
        'plugin.contacts.message',
        'plugin.nodes.node',
        'plugin.meta.meta',
        'plugin.taxonomy.model_taxonomy',
        'plugin.blocks.region',
        'plugin.users.role',
        'plugin.settings.setting',
        'plugin.taxonomy.taxonomy',
        'plugin.taxonomy.term',
        'plugin.taxonomy.type',
        'plugin.taxonomy.types_vocabulary',
        'plugin.users.user',
        'plugin.taxonomy.vocabulary',
    ];

/**
 * setUp
 *
 * @return void
 */
    public function setUp()
    {
        parent::setUp();
        App::build([
            'View' => [Plugin::path('Taxonomy') . 'View' . DS]
        ], App::APPEND);
        $this->VocabulariesController = $this->generate('Taxonomy.Vocabularies', [
            'methods' => [
                'redirect',
            ],
            'components' => [
                'Auth' => ['user'],
                'Session',
            ],
        ]);
        $this->VocabulariesController->Auth
            ->staticExpects($this->any())
            ->method('user')
            ->will($this->returnCallback([$this, 'authUserCallback']));
    }

/**
 * tearDown
 *
 * @return void
 */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->VocabulariesController);
    }

/**
 * testAdminIndex
 *
 * @return void
 */
    public function testAdminIndex()
    {
        $this->testAction('/admin/taxonomy/vocabularies/index');
        $this->assertNotEmpty($this->vars['vocabularies']);
    }

/**
 * testAdminAdd
 *
 * @return void
 */
    public function testAdminAdd()
    {
        $this->expectFlashAndRedirect('The Vocabulary has been saved');
        $this->testAction('admin/taxonomy/vocabularies/add', [
            'data' => [
                'Vocabulary' => [
                    'title' => 'New Vocabulary',
                    'alias' => 'new_vocabulary',
                ],
            ],
        ]);
        $newVocabulary = $this->VocabulariesController->Vocabulary->findByAlias('new_vocabulary');
        $this->assertEqual($newVocabulary['Vocabulary']['title'], 'New Vocabulary');
    }

/**
 * testAdminEdit
 *
 * @return void
 */
    public function testAdminEdit()
    {
        $this->expectFlashAndRedirect('The Vocabulary has been saved');
        $this->testAction('/admin/taxonomy/vocabularies/edit/1', [
            'data' => [
                'Vocabulary' => [
                    'id' => 1, // categories
                    'title' => 'Categories [modified]',
                ],
            ],
        ]);
        $categories = $this->VocabulariesController->Vocabulary->findByAlias('categories');
        $this->assertEquals('Categories [modified]', $categories['Vocabulary']['title']);
    }

/**
 * testAdminDelete
 *
 * @return void
 */
    public function testAdminDelete()
    {
        $this->expectFlashAndRedirect('Vocabulary deleted');
        $this->testAction('admin/taxonomy/vocabularies/delete/1'); // ID of categories
        $hasAny = $this->VocabulariesController->Vocabulary->hasAny([
            'Vocabulary.alias' => 'categories',
        ]);
        $this->assertFalse($hasAny);
    }

/**
 * testAdminMoveup
 *
 * @return void
 */
    public function testAdminMoveup()
    {
        $this->expectFlashAndRedirect('Moved up successfully');
        $this->testAction('admin/taxonomy/vocabularies/moveup/2'); // ID of tags
        $vocabularies = $this->VocabulariesController->Vocabulary->find('list', [
            'fields' => [
                'id',
                'alias',
            ],
            'order' => 'Vocabulary.weight ASC',
        ]);
        $expected = [
            '2' => 'tags',
            '1' => 'categories',
        ];
        $this->assertEqual($vocabularies, $expected);
    }

/**
 * testAdminMovedown
 *
 * @return void
 */
    public function testAdminMovedown()
    {
        $this->expectFlashAndRedirect('Moved down successfully');
        $this->testAction('admin/taxonomy/vocabularies/movedown/1'); // ID of categories
        $vocabularies = $this->VocabulariesController->Vocabulary->find('list', [
            'fields' => [
                'id',
                'alias',
            ],
            'order' => 'Vocabulary.weight ASC',
        ]);
        $expected = [
            '2' => 'tags',
            '1' => 'categories',
        ];
        $this->assertEqual($vocabularies, $expected);
    }
}
