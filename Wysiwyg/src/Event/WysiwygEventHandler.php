<?php

namespace Vamshop\Wysiwyg\Event;

use Cake\Event\EventListenerInterface;
use Vamshop\Core\Vamshop;

/**
 * Wysiwyg Event Handler
 *
 * @category Event
 * @package  Vamshop.Ckeditor
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class WysiwygEventHandler implements EventListenerInterface
{

/**
 * implementedEvents
 *
 * @return array
 */
    public function implementedEvents()
    {
        return [
            'Vamshop.bootstrapComplete' => [
                'callable' => 'onBootstrapComplete',
            ],
        ];
    }

    public function onBootstrapComplete($event)
    {
        Vamshop::hookHelper('*', 'Vamshop/Wysiwyg.Wysiwyg');
    }
}
