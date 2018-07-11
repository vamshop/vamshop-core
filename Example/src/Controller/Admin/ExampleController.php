<?php

namespace Vamshop\Example\Controller\Admin;

use Vamshop\Example\Controller\Admin\AppController;

/**
 * Example Controller
 *
 * @category Controller
 * @package  Vamshop
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class ExampleController extends AppController
{

/**
 * Controller name
 *
 * @var string
 * @access public
 */
    public $name = 'Example';

/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
    public $uses = ['Setting'];

/**
 * admin_index
 *
 * @return void
 */
    public function index()
    {
        $this->set('title_for_layout', 'Example');
    }

/**
 * admin_chooser
 *
 * @return void
 */
    public function chooser()
    {
        $this->set('title_for_layout', 'Chooser Example');
    }

    public function add()
    {
    }

    public function rteExample()
    {
        $notice = 'If editors are not displayed correctly, check that `Ckeditor` plugin is loaded after `Example` plugin.';
        $this->Flash->success($notice);
    }
}
