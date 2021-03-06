<?php

namespace Vamshop\Menus\Controller\Admin;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use Vamshop\Core\Controller\Component\VamshopComponent;
use Vamshop\Core\Controller\VamshopAppController;
use Vamshop\Menus\Controller\MenusAppController;
use Vamshop\Menus\Model\Table\LinksTable;

/**
 * Links Controller
 *
 * @property VamshopComponent Vamshop
 * @property LinksTable Links
 * @category Controller
 * @package  Vamshop.Menus.Controller
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class LinksController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Vamshop/Core.BulkProcess');
        $this->loadModel('Vamshop/Users.Roles');

        if ($this->request->param('action') == 'toggle') {
            $this->Vamshop->protectToggleAction();
        }
    }

    public function index()
    {
        $menuId = $this->request->query('menu_id');
        $menu = $this->Links->Menus->get($menuId);
        $this->set('title_for_layout', __d('vamshop', 'Links: %s', $menu->title));
        $linksTree = $this->Links->find('treeList')
            ->where([
                'Links.menu_id' => $menuId,
            ]);
        $linksStatus = $this->Links->find('list', [
            'valueField' => 'status',
        ])
            ->where([
                'Links.menu_id' => $menuId,
            ])
            ->toArray();
        $this->set(compact('linksTree', 'linksStatus', 'menu'));
        $this->set('_serialize', ['linksTree', 'menu', 'linksStatus']);
    }

    /**
     * Admin delete
     *
     * @param int $id
     *
     * @return \Cake\Network\Response|null|void
     */
    public function delete($id = null)
    {
        $link = $this->Links->get($id);

        $this->Links->setTreeScope($link->menu_id);
        if (!$this->Links->delete($link)) {
            return;
        }

        $this->Flash->success(__d('vamshop', 'Link deleted'));

        return $this->redirect([
            'action' => 'index',
            '?' => [
                'menu_id' => $link->menu_id,
            ],
        ]);
    }

    /**
     * Admin moveup
     *
     * @param int $id
     * @param int $step
     *
     * @return \Cake\Network\Response|null
     */
    public function moveup($id, $step = 1)
    {
        try {
            $link = $this->Links->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__d('vamshop', 'Invalid id for Link'));

            return $this->redirect([
                'controller' => 'menus',
                'action' => 'index',
            ]);
        }

        $this->Links->setTreeScope($link->menu_id);
        if ($this->Links->moveUp($link, $step)) {
            Cache::clearGroup('menus', 'vamshop_menus');
            $this->Flash->success(__d('vamshop', 'Moved up successfully'));
        } else {
            $this->Flash->error(__d('vamshop', 'Could not move up'));
        }

        return $this->redirect([
            'action' => 'index',
            '?' => [
                'menu_id' => $link->menu_id,
            ],
        ]);
    }

    /**
     * Admin movedown
     *
     * @param int $id
     * @param int $step
     *
     * @return \Cake\Network\Response|null
     */
    public function movedown($id, $step = 1)
    {
        try {
            $link = $this->Links->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__d('vamshop', 'Invalid id for Link'));

            return $this->redirect([
                'controller' => 'menus',
                'action' => 'index',
            ]);
        }

        $this->Links->setTreeScope($link->menu_id);
        if ($this->Links->moveDown($link, $step)) {
            Cache::clearGroup('menus', 'vamshop_menus');
            $this->Flash->success(__d('vamshop', 'Moved down successfully'));
        } else {
            $this->Flash->error(__d('vamshop', 'Could not move down'));
        }

        return $this->redirect([
            'action' => 'index',
            '?' => [
                'menu_id' => $link->menu_id,
            ],
        ]);
    }

    /**
     * Admin process
     *
     * @param int $menuId
     *
     * @return null
     */
    public function process($menuId = null)
    {
        $Links = $this->Links;
        list($action, $ids) = $this->BulkProcess->getRequestVars($Links->alias());

        $redirect = ['action' => 'index'];

        $menu = $this->Links->Menus->get($menuId);
        if (isset($menu->id)) {
            $redirect['?'] = ['menu_id' => $menuId];
        }
        $this->Links->setTreeScope($menuId);

        $multiple = ['copy' => false];
        $messageMap = [
            'delete' => __d('vamshop', 'Links deleted'),
            'publish' => __d('vamshop', 'Links published'),
            'unpublish' => __d('vamshop', 'Links unpublished'),
        ];
        $options = compact('multiple', 'redirect', 'messageMap');

        return $this->BulkProcess->process($this->Links, $action, $ids, $options);
    }

    public function beforeCrudRender(Event $event)
    {
        $menuId = null;
        $conditions = [];
        if (isset($event->subject()->entity) && $event->subject()->entity->isNew() === false) {
            $menuId = $event->subject()->entity->menu_id;
            $conditions[$this->Links->aliasField('id') .' !='] = $event->subject()->entity->id;
        }
        if ($this->request->query('menu_id')) {
            $menuId = $this->request->query('menu_id');
        }
        if (!$menuId) {
            return;
        }

        $menu = $this->Links->Menus->get($menuId);
        $conditions['menu_id'] = $menu->id;

        $this->set('menu', $menu);
        $this->set('roles', $this->Roles->find('list'));
        $this->set('parentLinks', $this->Links->find('treeList')->where($conditions));
    }

    public function beforeCrudRedirect(Event $event)
    {
        if ($this->redirectToSelf($event)) {
            return;
        }

        $entity = $event->subject()->entity;
        $event->subject()->url['menu_id'] = $entity->menu_id;
    }

    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Crud.beforeRender' => 'beforeCrudRender',
            'Crud.beforeRedirect' => 'beforeCrudRedirect',
        ];
    }
}
