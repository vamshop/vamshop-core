<?php

namespace Vamshop\Contacts\Controller\Admin;

use Cake\Event\Event;

/**
 * Messages Controller
 *
 * @category Contacts.Controller
 * @package  Vamshop.Contacts.Controller
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class MessagesController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->_setupPrg();

        $this->_loadVamshopComponents(['BulkProcess']);

        $this->Crud->config('actions.index', [
            'searchFields' => [
                'search', 'created' => ['type' => 'date'],
            ],
        ]);
    }

/**
 * Admin process
 *
 * @return void
 * @access public
 */
    public function process()
    {
        $Messages = $this->Messages;
        list($action, $ids) = $this->BulkProcess->getRequestVars($Messages->alias());

        $messageMap = [
            'delete' => __d('vamshop', 'Messages deleted'),
            'read' => __d('vamshop', 'Messages marked as read'),
            'unread' => __d('vamshop', 'Messages marked as unread'),
        ];
        return $this->BulkProcess->process($Messages, $action, $ids, [
            'messageMap' => $messageMap,
        ]);
    }

    public function beforePaginate(Event $event)
    {
        $query = $event->subject()->query;

        $query->contain([
            'Contacts'
        ]);
    }

    public function beforeCrudRedirect(Event $event)
    {
        if ($this->redirectToSelf($event)) {
            return;
        }
    }

    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Crud.beforePaginate' => 'beforePaginate',
            'Crud.beforeRedirect' => 'beforeCrudRedirect',
        ];
    }

    public function index()
    {
        $this->Crud->on('beforePaginate', function(Event $event) {
            $query = $event->subject()->query;
            if (empty($this->request->query('sort'))) {
                $query->order([
                    $this->Messages->aliasField('created') => 'desc',
                ]);
            }
        });
        return $this->Crud->execute();
    }

}
