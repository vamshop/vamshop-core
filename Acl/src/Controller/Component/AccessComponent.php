<?php

namespace Vamshop\Acl\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Vamshop\Core\Vamshop;

/**
 * AclAccess Component provides various methods to manipulate Aros and Acos,
 * and additionaly setup various settings for backend/admin use.
 *
 * @category Component
 * @package  Vamshop.Acl.Controller.Component
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class AccessComponent extends Component
{

/**
 * _controller
 *
 * @var Controller
 */
    protected $_controller = null;

/**
 * startup
 *
 * @param Event $event
 */
    public function startup(Event $event)
    {
        $controller = $event->subject();
        $this->_controller = $controller;
        if ($controller->request->param('prefix') != 'admin') {
            return;
        }

        switch ($controller->name) {
            case 'Roles':
                $this->_setupRole();
                break;
        }
    }

/**
 * Hook admin menu element to set role parent
 */
    protected function _setupRole()
    {
        $title = __d('vamshop', 'Parent Role');
        $element = 'Vamshop/Acl.admin/parent_role';
        Vamshop::hookAdminTab('Admin/Roles/add', $title, $element);
        Vamshop::hookAdminTab('Admin/Roles/edit', $title, $element);

        $id = null;
        if (!empty($this->_controller->request->params['pass'][0])) {
            $id = $this->_controller->request->params['pass'][0];
        }
        $this->_controller->set('parents', $this->_controller->Roles->allowedParents($id));
    }

/**
 * Add ACO
 *
 * Creates ACOs with permissions for roles.
 *
 * Action Path format:
 * - ControllerName
 * - ControllerName/method_name
 *
 * @param string $action action path
 * @param array $allowRoles Role aliases
 * @return void
 */
    public function addAco($action, $allowRoles = [])
    {
        $actionPath = $this->_controller->Auth->config('authorize.all.actionPath');
        if (strpos($action, $actionPath) === false) {
            $action = str_replace('//', '/', $actionPath . '/' . $action);
        }
        $Aco = TableRegistry::get('Vamshop/Acl.Acos');
        $Aco->addAco($action, $allowRoles);
    }

/**
 * Remove ACO
 *
 * Removes ACOs and their Permissions
 *
 * Action Path format:
 * - ControllerName
 * - ControllerName/method_name
 *
 * @param string $action action path
 * @return void
 */
    public function removeAco($action)
    {
        $actionPath = $this->_controller->Auth->authorize['all']['actionPath'];
        if (strpos($action, $actionPath) === false) {
            $action = str_replace('//', '/', $actionPath . '/' . $action);
        }
        $Aco = TableRegistry::get('Vamshop/Acl.Acos');
        $Aco->removeAco($action);
    }

    public function isUrlAuthorized($user, $url)
    {
        if (is_string($url)) {
            $parsedUrl = Router::parse($url);
            unset($parsedUrl['_matchedRoute']);
            $options = [
                'params' => $parsedUrl,
                'url' => $url,
            ];
        } else {
            $reversedRoute = Router::reverse($url);
            $options = [
                'params' => $url,
                'url' => $reversedRoute,
            ];
        }
        $request = new ServerRequest($options);
        return $this->getController()->Auth->isAuthorized($user, $request);
    }

}
