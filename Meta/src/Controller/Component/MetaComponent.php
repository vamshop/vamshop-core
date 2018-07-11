<?php

namespace Vamshop\Meta\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Vamshop\Core\Vamshop;

/**
 * Meta Component
 *
 * @package Vamshop.Meta.Controller.Component
 */
class MetaComponent extends Component
{
    /**
     * startup
     */
    public function startup()
    {
        $controller = $this->_registry->getController();
        if ($controller->request->param('prefix') === 'admin') {
            $this->_adminTabs();

            if (empty($controller->request->data['meta'])) {
                return;
            }
            $unlockedFields = [];
            foreach ($controller->request->data['meta'] as $uuid => $fields) {
                foreach ($fields as $field => $vals) {
                    $unlockedFields[] = 'meta.' . $uuid . '.' . $field;
                }
            }
            $controller->Security->config('unlockedFields', $unlockedFields);
        }
    }

    /**
     * Hook admin tabs for controllers whom its primary model has MetaBehavior attached.
     */
    protected function _adminTabs()
    {
        $controller = $this->_registry->getController();
        $table = TableRegistry::get($controller->modelClass);
        if ($table &&
            !$table->behaviors()
                ->has('Meta')
        ) {
            return;
        }
        $title = __d('vamshop', 'Custom Fields');
        $element = 'Vamshop/Meta.admin/meta_tab';
        $controllerName = $this->request->param('controller');
        Vamshop::hookAdminBox("Admin/$controllerName/add", $title, $element);
        Vamshop::hookAdminBox("Admin/$controllerName/edit", $title, $element);
    }
}
