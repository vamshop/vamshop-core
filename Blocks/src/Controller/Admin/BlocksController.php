<?php

namespace Vamshop\Blocks\Controller\Admin;

use Cake\Event\Event;
use Vamshop\Blocks\Model\Entity\Block;

/**
 * Blocks Controller
 *
 * @category Blocks.Controller
 * @package  Vamshop.Blocks.Controller
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class BlocksController extends AppController
{
    public $paginate = [
        'order' => [
            'region_id' => 'asc',
            'weight' => 'asc',
        ]
    ];

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Vamshop/Users.Roles');

        $this->_loadVamshopComponents(['BulkProcess']);
        $this->_setupPrg();

        $this->Crud->config('actions.index', [
            'searchFields' => ['region_id', 'title']
        ]);
        $this->Crud->config('actions.moveUp', [
            'className' => 'Vamshop/Core.Admin/MoveUp'
        ]);
        $this->Crud->config('actions.moveDown', [
            'className' => 'Vamshop/Core.Admin/MoveDown'
        ]);

        if ($this->request->param('action') == 'toggle') {
            $this->Vamshop->protectToggleAction();
        }
    }

/**
 * Admin process
 *
 * @return void
 * @access public
 */
    public function process()
    {
        $Blocks = $this->Blocks;
        list($action, $ids) = $this->BulkProcess->getRequestVars($Blocks->alias());

        $options = [
            'messageMap' => [
                'delete' => __d('vamshop', 'Successfully deleted blocks'),
                'publish' => __d('vamshop', 'Successfully published blocks'),
                'unpublish' => __d('vamshop', 'Successfully unpublished blocks'),
                'copy' => __d('vamshop', 'Successfully copied blocks'),
            ],
        ];

        return $this->BulkProcess->process($Blocks, $action, $ids, $options);
    }

    public function beforePaginate(Event $event)
    {
        $query = $event->subject()->query;
        $query->contain([
            'Regions'
        ]);

        $this->set('regions', $this->Blocks->Regions->find('list'));
    }

    public function beforeCrudRender()
    {
        $this->set('roles', $this->Roles->find('list'));
    }

    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Crud.beforePaginate' => 'beforePaginate',
            'Crud.beforeRender' => 'beforeCrudRender',
            'Crud.beforeRedirect' => 'beforeCrudRedirect',
        ];
    }

    public function beforeCrudRedirect(Event $event)
    {
        if ($this->redirectToSelf($event)) {
            return;
        }
    }

    public function toggle()
    {
        return $this->Crud->execute();
    }

}
