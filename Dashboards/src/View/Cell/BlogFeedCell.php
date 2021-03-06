<?php

namespace Vamshop\Dashboards\View\Cell;

use Cake\Cache\Cache;
use Cake\I18n\Time;
use Cake\Utility\Xml;
use Cake\View\Cell;
use Vamshop\Core\Link;

class BlogFeedCell extends Cell
{

    public function dashboard()
    {
        $posts = $this->getPosts();

        $this->set('posts', $posts);
    }

    protected function getPosts()
    {
        $posts = Cache::read('vamshop_blog_feed_posts');
        if ($posts === false) {
            $xml = Xml::build(file_get_contents('http://support.vamshop.com/modules/news/backendt.php?topicid=1'));

            $data = Xml::toArray($xml);

            $posts = [];
            foreach ($data['rss']['channel']['item'] as $item) {
                $posts[] = (object)[
                    'title' => $item['title'],
                    'url' => new Link($item['link']),
                    'body' => $item['description'],
                    'date' => new Time($item['pubDate']),
                ];
            }
        }

        Cache::write('vamshop_blog_feed_posts', $posts);

        return $posts;
    }
}
