<?php

/**
 * Translate Activation
 *
 * @package  Vamshop.Translate
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
namespace Vamshop\Translate\Config;

use Cake\ORM\TableRegistry;
use Vamshop\Core\Plugin;

class PluginActivation
{

/**
 * onActivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
    public function beforeActivation(&$controller)
    {
        return true;
    }

/**
 * Called after activating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
    public function onActivation(&$controller)
    {
        $Acos = TableRegistry::get('Vamshop/Acl.Acos');
        $Acos->addAco('Vamshop\Translate/Admin/Translate/index');
        $Acos->addAco('Vamshop\Translate/Admin/Translate/edit');
        $Acos->addAco('Vamshop\Translate/Admin/Translate/delete');
        $VamshopPlugin = new Plugin();
        $VamshopPlugin->migrate('Vamshop/Translate');
    }

/**
 * onDeactivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
    public function beforeDeactivation(&$controller)
    {
        return true;
    }

/**
 * Called after deactivating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
    public function onDeactivation(&$controller)
    {
        $Acos = TableRegistry::get('Vamshop/Acl.Acos');
        $Acos->removeAco('Vamshop\Translate');
    }
}
