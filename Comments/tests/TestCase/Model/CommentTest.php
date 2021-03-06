<?php
namespace Vamshop\Comments\Test\TestCase\Model;

use Comments\Model\Comment;
use Vamshop\TestSuite\VamshopTestCase;

class CommentTest extends VamshopTestCase
{

    public $fixtures = [
        'plugin.comments.comment',
        'plugin.meta.meta',
        'plugin.nodes.node',
        'plugin.taxonomy.model_taxonomy',
        'plugin.taxonomy.taxonomy',
        'plugin.taxonomy.type',
        'plugin.users.user',
    ];

    public $Comment;

    protected $_level;

    protected $_record;

    public function setUp()
    {
        parent::setUp();
        $this->_level = Configure::read('Comment.level');
        Configure::write('Comment.level', 10);
        $this->Comment = ClassRegistry::init('Comments.Comment');
        $this->_record = $this->Comment->findById(1);
    }

    public function tearDown()
    {
        parent::tearDown();
        Configure::write('Comment.level', $this->_level);
        unset($this->Comment);
    }

/**
 * testAdd
 */
    public function testAdd()
    {
        $oldCount = $this->Comment->find('count');
        $data = [
            'Comment' => [
                'name' => 'Test Visitor',
                'email' => 'visitor@test.fr',
                'website' => 'http://www.test.fr',
                'body' => 'TESTEH',
                'ip' => '127.0.0.1',
                'status' => 1,
            ]
        ];

        $result = $this->Comment->add(
            $data,
            'Node',
            1
        );
        $this->assertTrue($result);

        $newCount = $this->Comment->find('count');
        $newComment = $this->Comment->find('first', ['order' => 'Comment.created DESC']);
        $this->assertEquals($oldCount + 1, $newCount);
        $this->assertEquals(2, $newComment['Comment']['status']);
    }

/**
 * testAddWithParentId
 */
    public function testAddWithParentId()
    {
        $oldCount = $this->Comment->find('count');
        $data = [
            'Comment' => [
                'name' => 'Test Visitor',
                'email' => 'visitor@test.fr',
                'website' => 'http://www.test.fr',
                'body' => 'TESTEH',
                'ip' => '127.0.0.1'
            ]
        ];

        $result = $this->Comment->add(
            $data,
            'Node',
            1,
            [
                'parentId' => 1,
            ]
        );
        $newCount = $this->Comment->find('count');
        $newComment = $this->Comment->find('first', ['order' => 'Comment.created DESC']);

        $this->assertEquals(1, $newComment['Comment']['parent_id']);
        $this->assertEquals($oldCount + 1, $newCount);
        $this->assertTrue($result);
    }

/**
 * testAddCommentWithUserData
 */
    public function testAddCommentWithUserData()
    {
        $oldCount = $this->Comment->find('count');
        $data = [
            'Comment' => [
                'name' => '',
                'email' => '',
                'website' => 'http://www.test.fr',
                'body' => 'TESTEH',
                'ip' => '127.0.0.1',
                'status' => 1,
            ]
        ];

        $userData =     [
            'User' => [
                'id' => 2,
                'role_id' => 1,
                'username' => 'rchavik',
                'password' => 'ab4d1d3ab4d1d3ab4d1d3ab4d1d3aaaaab4d1d3a',
                'name' => 'Rachman Chavik',
                'email' => 'me@your-site.com',
                'website' => '/about',
                'activation_key' => '',
                'image' => '',
                'bio' => '',
                'timezone' => '0',
                'status' => 1,
                'updated' => '2010-01-07 22:23:27',
                'created' => '2010-01-05 00:00:00'
            ]
        ];

        $result = $this->Comment->add(
            $data,
            'Node',
            1,
            [
                'parentId' => 1,
                'userData' => $userData
            ]
        );
        $newCount = $this->Comment->find('count');
        $newComment = $this->Comment->find('first', ['order' => 'Comment.created DESC']);

        $this->assertTrue($result);
        $this->assertEquals($oldCount + 1, $newCount);
        $this->assertEquals('Rachman Chavik', $newComment['Comment']['name']);
        $this->assertEquals(2, $newComment['Comment']['user_id']);
    }

/**
 * testAddCommentToModeratedNode
 */
    public function testAddCommentToModeratedNode()
    {
        $oldCount = $this->Comment->find('count');
        $data = [
            'Comment' => [
                'name' => 'Test Visitor',
                'email' => 'visitor@test.fr',
                'website' => 'http://www.test.fr',
                'body' => 'TESTEH',
                'ip' => '127.0.0.1'
            ]
        ];

        $result = $this->Comment->add(
            $data,
            'Node',
            1,
            [
                'foreignKey' => 1,
            ]
        );
        $newCount = $this->Comment->find('count');
        $newComment = $this->Comment->find('first', ['order' => 'Comment.created DESC']);

        $this->assertTrue($result);
        $this->assertEquals($oldCount + 1, $newCount);
        $this->assertEquals(Comment::STATUS_PENDING, $newComment['Comment']['status']);
    }

/**
 * testAddCommentIsRejectedWhenLevelIsExceeded
 */
    public function testAddCommentIsRejectedWhenLevelIsExceeded()
    {
        $oldConf = Configure::read('Comment.level');
        Configure::write('Comment.level', 1);
        $oldCount = $this->Comment->find('count');
        $data = [
            'Comment' => [
                'name' => 'Test Visitor',
                'email' => 'visitor@test.fr',
                'website' => 'http://www.test.fr',
                'body' => 'TESTEH',
                'ip' => '127.0.0.1'
            ]
        ];

        $result = $this->Comment->add(
            $data,
            'Node',
            1,
            [
                'parentId' => 1,
            ]
        );

        $this->assertFalse($result);
        $newCount = $this->Comment->find('count');
        $newComment = $this->Comment->find('first', ['order' => 'Comment.created DESC']);

        $this->assertFalse($result);
        $this->assertEquals($oldCount, $newCount);
    }

/**
 * testAddCommentThrowsExceptionWithInvalidNodeId
 */
    public function testAddCommentThrowsExceptionWithInvalidNodeId()
    {
        $this->setExpectedException('NotFoundException');
        $this->Comment->add(
            ['Comment' => ['name', 'email', 'body']],
            'Node',
            'invalid',
            []
        );
    }

/**
 * testAddCommentThrowsExceptionWithInvalidParentId
 */
    public function testAddCommentThrowsExceptionWithInvalidParentId()
    {
        $this->setExpectedException('NotFoundException');
        $data = [
            'Comment' => [
                'name' => 'Test Visitor',
                'email' => 'visitor@test.fr',
                'website' => 'http://www.test.fr',
                'body' => 'TESTEH',
                'ip' => '127.0.0.1'
            ]
        ];
        $this->Comment->add(
            $data,
            'Node',
            1,
            [
                'parentId' => 'invalid',
            ]
        );
    }
}
