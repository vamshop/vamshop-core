<?php

namespace Vamshop\Example\Controller;

use Vamshop\Example\Controller\AppController;

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
    * index
    *
    * @return void
    */
    public function index()
    {
        $this->set('title_for_layout', 'Example');
        $this->set('exampleVariable', 'value here');
    }

}
