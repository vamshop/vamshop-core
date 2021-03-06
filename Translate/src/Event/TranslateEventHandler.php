<?php

namespace Vamshop\Translate\Event;

use Cake\Datasource\EntityInterface;
use Cake\Event\EventListenerInterface;
use Vamshop\Translate\Translations;

/**
 * TranslateEventHandler
 *
 * @package  Vamshop.Translate.Event
 * @author   Rachman Chavik <rchavik@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class TranslateEventHandler implements EventListenerInterface
{

    public function implementedEvents()
    {
        return [
            'Vamshop.bootstrapComplete' => [
                'callable' => 'onVamshopBootstrapComplete',
            ],
            'View.beforeRender' => [
                'callable' => 'onBeforeRender',
            ],
        ];
    }

    public function onVamshopBootstrapComplete($event)
    {
        Translations::translateModels();
    }

    public function onBeforeRender($event)
    {
        $View = $event->subject;
        if ($View->request->param('prefix') !== 'admin') {
            return;
        }
        if (empty($View->viewVars['viewVar'])) {
            return;
        }
        $viewVar = $View->viewVars['viewVar'];
        $entity = $View->viewVars[$viewVar];
        if (!$entity instanceof EntityInterface) {
            return;
        }
        if ($entity->isNew()) {
            return;
        }
        $title = __d('vamshop', 'Translate');
        $View->append('action-buttons');
            echo $event->subject->Vamshop->adminAction($title, [
                'plugin' => 'Vamshop/Translate',
                'controller' => 'Translate',
                'action' => 'index',
                'id' => $entity->get('id'),
                'model' => $entity->source(),
            ], [
                'icon' => 'translate',
            ]);
        $View->end();
    }

}
