<?php

use Phinx\Seed\AbstractSeed;

class CommentsSeed extends AbstractSeed
{

    public $records = [
        [
            'id' => '1',
            'parent_id' => null,
            'model' => 'Vamshop/Nodes.Nodes',
            'foreign_key' => '1',
            'user_id' => '0',
            'name' => 'Mr Vamshop',
            'email' => 'email@example.com',
            'website' => 'http://www.vamshop.com',
            'ip' => '127.0.0.1',
            'title' => '',
            'body' => 'Hi, this is the first comment.',
            'rating' => null,
            'status' => '1',
            'notify' => '0',
            'type' => 'blog',
            'comment_type' => 'comment',
            'lft' => '1',
            'rght' => '2',
            'updated' => '2018-12-25 12:00:00',
            'created' => '2018-12-25 12:00:00'
        ],
    ];

    public function run()
    {
        $Table = $this->table('comments');
        $Table->insert($this->records)->save();
    }

}
