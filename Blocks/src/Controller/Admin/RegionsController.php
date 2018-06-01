<?php

namespace Croogo\Blocks\Controller\Admin;

use Cake\Event\Event;

/**
 * Regions Controller
 *
 * @category Blocks.Controller
 * @package  Croogo.Blocks.Controller
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class RegionsController extends AppController
{
    public $modelClass = 'Croogo/Blocks.Regions';

    public function initialize()
    {
        parent::initialize();

        $this->_setupPrg();

        $this->Crud->config('actions.index', [
            'displayFields' => $this->Regions->displayFields(),
            'searchFields' => ['title']
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
