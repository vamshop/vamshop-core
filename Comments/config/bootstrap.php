<?php

use Cake\Core\Configure;
use Cake\Cache\Cache;
use Vamshop\Core\Vamshop;

Cache::config('croogo_comments', array_merge(
    Configure::read('Vamshop.Cache.defaultConfig'),
    ['groups' => ['comments']]
));

Vamshop::hookHelper('*', 'Vamshop/Comments.Comments');

Vamshop::hookBehavior('Vamshop/Nodes.Nodes', 'Vamshop/Comments.Commentable');
