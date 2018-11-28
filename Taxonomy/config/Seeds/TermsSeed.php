<?php

use Phinx\Seed\AbstractSeed;

class TermsSeed extends AbstractSeed
{

    public $table = 'terms';

    public $records = [
        [
            'id' => '1',
            'title' => 'Uncategorized',
            'slug' => 'uncategorized',
            'description' => '',
            'updated' => '2018-07-22 03:38:43',
            'created' => '2018-07-22 03:34:56'
        ],
        [
            'id' => '2',
            'title' => 'Announcements',
            'slug' => 'announcements',
            'description' => '',
            'updated' => '2018-05-16 23:57:06',
            'created' => '2018-07-22 03:45:37'
        ],
        [
            'id' => '3',
            'title' => 'mytag',
            'slug' => 'mytag',
            'description' => '',
            'updated' => '2018-08-26 14:42:43',
            'created' => '2018-08-26 14:42:43'
        ],
    ];

    public function run()
    {
        $Table = $this->table('terms');
        $Table->insert($this->records)->save();
    }

}
