<?php

namespace Vamshop\Core\Controller\Admin;

use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Event\Event;
use Vamshop\Core\Vamshop;
use Vamshop\Core\Controller\AppController as VamshopAppController;
use Crud\Controller\ControllerTrait;

/**
 * Vamshop App Controller
 *
 * @category Vamshop.Controller
 * @package  Vamshop.Vamshop.Controller
 * @version  1.5
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 *
 * @property \Crud\Controller\Component\CrudComponent $Crud
 */
class AppController extends VamshopAppController
{
    use ControllerTrait;

/**
 * Load the theme component with the admin theme specified
 *
 * @return void
 */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'index' => [
                    'className' => 'Vamshop/Core.Admin/Index'
                ],
                'lookup' => [
                    'className' => 'Crud.Lookup',
                    'findMethod' => 'all'
                ],
                'view' => [
                    'className' => 'Crud.View'
                ],
                'add' => [
                    'className' => 'Vamshop/Core.Admin/Add',
                    'messages' => [
                        'success' => [
                            'params' => [
                                'type' => 'success',
                                'class' => ''
                            ]
                        ],
                        'error' => [
                            'params' => [
                                'type' => 'error',
                                'class' => ''
                            ]
                        ]
                    ]
                ],
                'edit' => [
                    'className' => 'Vamshop/Core.Admin/Edit',
                    'messages' => [
                        'success' => [
                            'params' => [
                                'type' => 'success',
                                'class' => ''
                            ]
                        ],
                        'error' => [
                            'params' => [
                                'type' => 'error',
                                'class' => ''
                            ]
                        ]
                    ]
                ],
                'toggle' => [
                    'className' => 'Vamshop/Core.Admin/Toggle'
                ],
                'delete' => [
                    'className' => 'Crud.Delete'
                ]
            ],
            'listeners' => [
                'Crud.Search',
                'Crud.RelatedModels',
                'Vamshop/Core.Flash',
            ]
        ]);

        $this->Theme->config('theme', Configure::read('Site.admin_theme'));
    }

/**
 * beforeFilter
 *
 * @return void
 */
    public function beforeFilter(Event $event)
    {
        $this->viewBuilder()->setLayout('admin');

        parent::beforeFilter($event);

        Vamshop::dispatchEvent('Vamshop.beforeSetupAdminData', $this);
    }

    public function index()
    {
        return $this->Crud->execute();
    }

    public function view($id)
    {
        return $this->Crud->execute();
    }

    public function add()
    {
        return $this->Crud->execute();
    }

    public function edit($id)
    {
        return $this->Crud->execute();
    }

    public function delete($id)
    {
        return $this->Crud->execute();
    }

    protected function redirectToSelf(Event $event)
    {
        $subject = $event->subject();
        if ($subject->success) {
            if (isset($this->request->data['_apply'])) {
                $entity = $subject->entity;
                return $this->redirect(['action' => 'edit', $entity->id]);
            }
        }
    }

}
