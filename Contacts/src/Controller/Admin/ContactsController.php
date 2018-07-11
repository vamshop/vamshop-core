<?php

namespace Vamshop\Contacts\Controller\Admin;

use Cake\Event\Event;

/**
 * Contacts Controller
 *
 * @category Controller
 * @package  Vamshop.Contacts.Controller
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class ContactsController extends AppController
{
    public $modelClass = 'Vamshop/Contacts.Contacts';

    public function initialize()
    {
        parent::initialize();

        $this->Crud->config('actions.index', [
            'displayFields' => $this->Contacts->displayFields()
        ]);
    }

    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Crud.beforeRedirect' => 'beforeCrudRedirect',
        ];
    }

    public function beforeCrudRedirect(Event $event)
    {
        if ($this->redirectToSelf($event)) {
            return;
        }
    }

}
