<?php

namespace Vamshop\Core\View\Cell\Admin;

use Cake\Core\Configure;
use Cake\View\Cell;
use Vamshop\Core\Vamshop;

/**
 * Class LinkChooserCell
 */
class LinkChooserCell extends Cell
{
    public function display($target)
    {
        Vamshop::dispatchEvent('Controller.Links.setupLinkChooser', $this);
        $linkChoosers = Configure::read('Vamshop.linkChoosers');
        $this->set(compact('target', 'linkChoosers'));
    }
}
