<?php

namespace Vamshop\Core\Controller\Admin;

use Vamshop\Core\Vamshop;
use Cake\Core\Configure;

class LinkChooserController extends AppController
{

    public function linkChooser()
    {
        Vamshop::dispatchEvent('Controller.Links.setupLinkChooser', $this);
        $linkChoosers = Configure::read('Vamshop.linkChoosers');
        $this->set(compact('linkChoosers'));
    }
}
