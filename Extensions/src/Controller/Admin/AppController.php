<?php

namespace Vamshop\Extensions\Controller\Admin;

use Cake\Event\Event;
use Vamshop\Core\Controller\Admin\AppController as VamshopController;

/**
 * Extensions Admin Controller
 *
 * @category Controller
 * @package  Vamshop.Extensions.Controller
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class AppController extends VamshopController
{
/**
 * beforeFilter
 *
 * @return void
 */
    public function initialize()
    {
        parent::initialize();

        if (in_array($this->request->param('action'), ['admin_delete', 'admin_toggle', 'admin_activate'])) {
            $this->request->allowMethod('post');
        }
    }
}
