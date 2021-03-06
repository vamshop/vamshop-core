<?php

namespace Vamshop\Core\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Routing\Router;

/**
 * Error Handling Controller
 *
 * Controller used by ErrorHandler to render error views.  This is based
 * on CakePHP's own CakeErrorController with the following differences:
 * - loads its own set of components and helpers
 * - aware of Site.theme and Site.admin_theme
 *
 * @category Controllers
 * @package  Vamshop.Vamshop.Controller
 * @version  1.0
 * @author   Rachman Chavik <rchavik@xintesa.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class ErrorController extends \Cake\Controller\ErrorController implements HookableComponentInterface
{
    use HookableComponentTrait;

    public function initialize()
    {
        $this->_dispatchBeforeInitialize();

        if (count(Router::extensions()) && !isset($this->RequestHandler)) {
            $this->loadComponent('RequestHandler');
        }

        $eventManager = $this->eventManager();
        if (isset($this->Auth)) {
            $eventManager->off($this->Auth);
        }
        if (isset($this->Security)) {
            $eventManager->off($this->Security);
        }

        parent::initialize();
    }

    /**
     * beforeFilter
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        if ($this->request->is('json')) {
            return;
        }
        $viewBuilder = $this->viewBuilder();
        $viewBuilder->className('Vamshop/Core.Vamshop');
        if ($this->request->param('prefix') === 'admin') {
            $adminTheme = Configure::read('Site.admin_theme');
            if ($adminTheme) {
                $viewBuilder->setTheme($adminTheme);
            }
            if (!$this->request->is('ajax')) {
                $viewBuilder->setLayout('admin_full');
            }
        } elseif (Configure::read('Site.theme')) {
            $viewBuilder->setTheme(Configure::read('Site.theme'));
        }
    }
}
