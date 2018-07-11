<?php

namespace Vamshop\FileManager\Event;

use Cake\Event\EventListenerInterface;
use Vamshop\Core\Vamshop;

/**
 * FileManagerEventHandler
 *
 * @category Event
 * @package  Vamshop.FileManager.Event
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class FileManagerEventHandler implements EventListenerInterface
{

/**
 * implementedEvents
 */
    public function implementedEvents()
    {
        return [
            'Controller.Links.setupLinkChooser' => [
                'callable' => 'onSetupLinkChooser',
            ],
        ];
    }

/**
 * Setup Link chooser values
 *
 * @return void
 */
    public function onSetupLinkChooser($event)
    {
        $linkChoosers = [];
        $linkChoosers['Images'] = [
            'title' => 'Images',
            'description' => 'Attachments with an image mime type.',
            'url' => [
                'plugin' => 'Vamshop/FileManager',
                'controller' => 'Attachments',
                'action' => 'index',
                '?' => [
                    'chooser_type' => 'image',
                    'chooser' => 1,
                    'KeepThis' => true,
                    'TB_iframe' => true,
                    'height' => 400,
                    'width' => 600
                ]
            ]
        ];
        $linkChoosers['Files'] = [
            'title' => 'Files',
            'description' => 'Attachments with other mime types, ie. pdf, xls, doc, etc.',
            'url' => [
                'plugin' => 'Vamshop/FileManager',
                'controller' => 'Attachments',
                'action' => 'index',
                '?' => [
                    'chooser_type' => 'file',
                    'chooser' => 1,
                    'KeepThis' => true,
                    'TB_iframe' => true,
                    'height' => 400,
                    'width' => 600
                ]
            ]
        ];
        Vamshop::mergeConfig('Vamshop.linkChoosers', $linkChoosers);
    }
}
