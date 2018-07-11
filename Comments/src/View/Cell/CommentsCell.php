<?php

namespace Vamshop\Comments\View\Cell;

use Cake\ORM\Query;
use Cake\View\Cell;
use Vamshop\Comments\Model\Entity\Comment;
use Vamshop\Nodes\Model\Entity\Node;
use Vamshop\Taxonomy\Model\Entity\Type;

class CommentsCell extends Cell
{
    public function node($nodeId)
    {
        $this->loadModel('Vamshop/Nodes.Nodes');

        $node = $this->Nodes->get($nodeId, [
            'contain' => [
                'Comments' => function (Query $query) {
                    $query->find('threaded');

                    return $query;
                }
            ]
        ]);

        $this->set('node', $node);
    }

    public function commentFormNode(Node $node, Type $type, Comment $comment = null)
    {
        $this->loadModel('Vamshop/Comments.Comments');

        $formUrl = [
            'plugin' => 'Vamshop/Comments',
            'controller' => 'Comments',
            'action' => 'add',
            urlencode('Vamshop/Nodes.Nodes'),
            $node->id,
        ];

        if (isset($this->request->params['pass'][2])) {
            $formUrl[] = $this->request->params['pass'][2];
        }

        $this->set('title', $node->title);
        $this->set('url', $node->url);
        $this->set('formUrl', $formUrl);
        $this->set('comment', $comment ?: $this->Comments->newEntity());
        $this->set('captcha', $type->comment_captcha);
        $this->set('loggedInUser', $this->request->session()->read('Auth.User'));
    }
}
