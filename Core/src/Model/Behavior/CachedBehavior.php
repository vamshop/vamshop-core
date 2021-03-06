<?php

namespace Vamshop\Core\Model\Behavior;

use Cake\Cache\Cache;
use Cake\ORM\Behavior;

/**
 * Cached Behavior
 *
 * @category Behavior
 * @package  Vamshop.Vamshop.Model.Behavior
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class CachedBehavior extends Behavior
{
    protected $_defaultConfig = [
        'groups' => []
    ];

    /**
     * afterSave callback
     * @return void
     */
    public function afterSave()
    {
        $this->_deleteCachedFiles();
    }

    /**
     * afterDelete callback
     *
     * @return void
     */
    public function afterDelete()
    {
        $this->_deleteCachedFiles();
    }

    /**
     * Delete cache files matching prefix
     *
     * @return void
     */
    protected function _deleteCachedFiles()
    {
        foreach ($this->config('groups') as $group) {
            try {
                $configs = Cache::groupConfigs($group);
                foreach ($configs[$group] as $config) {
                    Cache::clearGroup($group, $config);
                }
            } catch (\InvalidArgumentException $e) {
                //Ignore invalid cache configs
            }
        }
    }
}
