<?php

namespace Vamshop\Nodes\Event;

use Cake\Cache\Cache;
use Cake\Core\Plugin;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;
use Vamshop\Comments\Model\Comment;
use Vamshop\Core\Vamshop;
use Vamshop\Core\Nav;

/**
 * Nodes Event Handler
 *
 * @category Event
 * @package  Vamshop.Nodes.Event
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class NodesEventHandler implements EventListenerInterface
{

    /**
     * implementedEvents
     */
    public function implementedEvents()
    {
        return [
            'Vamshop.bootstrapComplete' => [
                'callable' => 'onBootstrapComplete',
            ],
            'Vamshop.setupAdminData' => [
                'callable' => 'onSetupAdminData',
            ],
            'Controller.Links.setupLinkChooser' => [
                'callable' => 'onSetupLinkChooser',
            ],
            'Controller.Nodes.afterPublish' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Nodes.afterUnpublish' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Nodes.afterPromote' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Nodes.afterUnpromote' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Nodes.afterDelete' => [
                'callable' => 'onAfterBulkProcess',
            ],
        ];
    }

    /**
     * Setup admin data
     */
    public function onSetupAdminData($event)
    {
        $View = $event->subject;

        if (!isset($View->viewVars['typesForAdminLayout'])) {
            return;
        }

        $types = $View->viewVars['typesForAdminLayout'];
        foreach ($types as $type) {
            if (!empty($type->plugin)) {
                continue;
            }
            Nav::add('sidebar', 'content.children.create.children.' . $type->alias, [
                'title' => $type->title,
                'url' => [
                    'prefix' => 'admin',
                    'plugin' => 'Vamshop/Nodes',
                    'controller' => 'Nodes',
                    'action' => 'add',
                    $type->alias,
                ],
            ]);
        };
    }

    /**
     * onBootstrapComplete
     */
    public function onBootstrapComplete($event)
    {
        if (Plugin::loaded('Comments')) {
            Vamshop::hookBehavior('Vamshop/Nodes.Nodes', 'Comments.Commentable');
            Vamshop::hookComponent('Vamshop/Nodes.Nodes', 'Comments.Comments');
            Vamshop::hookModelProperty('Vamshop/Comments.Comments', 'belongsTo', [
                'Nodes' => [
                    'className' => 'Vamshop/Nodes.Nodes',
                    'foreignKey' => 'foreign_key',
                    'counterCache' => true,
                    'counterScope' => [
                        'Comment.model' => 'Vamshop/Nodes.Nodes',
                        'Comment.status' => Comment::STATUS_APPROVED,
                    ],
                ],
            ]);
        }
        if (Plugin::loaded('Vamshop/Taxonomy')) {
            Vamshop::hookBehavior('Vamshop/Nodes.Nodes', 'Vamshop/Taxonomy.Taxonomizable');
        }
        if (Plugin::loaded('Vamshop/Meta')) {
            Vamshop::hookBehavior('Vamshop/Nodes.Nodes', 'Vamshop/Meta.Meta');
        }
    }

    /**
     * Setup Link chooser values
     *
     * @return void
     */
    public function onSetupLinkChooser($event)
    {
        $typesTable = TableRegistry::get('Vamshop/Taxonomy.Types');
        $types = $typesTable->find('all', [
            'fields' => ['alias', 'title', 'description'],
        ]);
        $linkChoosers = [];
        foreach ($types as $type) {
            $linkChoosers[$type->title ] = [
                'title' => $type->title,
                'description' => $type->description,
                'url' => [
                    'prefix' => 'admin',
                    'plugin' => 'Vamshop/Nodes',
                    'controller' => 'Nodes',
                    'action' => 'index',
                    '?' => [
                        'type' => $type->alias,
                        'chooser' => 1,
                    ],
                ],
            ];
        }
        Vamshop::mergeConfig('Vamshop.linkChoosers', $linkChoosers);
    }

    /**
     * Clear Nodes related cache after bulk operation
     *
     * @param CakeEvent $event
     * @return void
     */
    public function onAfterBulkProcess($event)
    {
        Cache::clearGroup('nodes', 'nodes');
        Cache::clearGroup('nodes', 'nodes_view');
        Cache::clearGroup('nodes', 'nodes_promoted');
        Cache::clearGroup('nodes', 'nodes_term');
        Cache::clearGroup('nodes', 'nodes_index');
    }
}
