<?php

namespace Vamshop\Menus\Controller\Admin;

use Cake\Event\Event;

/**
 * Menus Controller
 *
 * @category Controller
 * @package  Vamshop.Menus.Controller
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class MenusController extends AppController
{

    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Crud.beforeRedirect' => 'beforeCrudRedirect',
        ];
    }

    public function initialize()
    {
        parent::initialize();
        if ($this->request->param('action') === 'toggle') {
            $this->Vamshop->protectToggleAction();
        }
    }

    /**
     * @param \Cake\Event\Event $event
     * @return void
     */
    public function beforeCrudRedirect(Event $event)
    {
        if ($this->redirectToSelf($event)) {
            return;
        }
    }

}
