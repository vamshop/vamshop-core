<?php

namespace Vamshop\Wysiwyg\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\Core\App;
use Vamshop\Core\Router;

/**
 * Wysiwyg Helper
 *
 * @category Wysiwyg.Helper
 * @package  Vamshop.Wysiwyg.View.Helper
 * @version  1.5
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class WysiwygHelper extends Helper
{

/**
 * Other helpers used by this helper
 *
 * @var array
 * @access public
 */
    public $helpers = [
        'Html',
        'Url'
    ];

/**
 * beforeRender
 *
 * @param string $viewFile
 * @return void
 */
    public function beforeRender($viewFile)
    {
        $actions = array_keys(Configure::read('Wysiwyg.actions'));
        $currentAction = Router::getActionPath($this->request, true);
        $included = in_array($currentAction, $actions);
        if ($included) {
            $this->Html->script('Vamshop/Wysiwyg.wysiwyg', ['block' => 'script']);
        }
    }

}
