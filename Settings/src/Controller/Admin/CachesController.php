<?php

namespace Vamshop\Settings\Controller\Admin;

use Cake\Cache\Cache;
use Vamshop\Core\Event\EventManager;

/**
 * Caches Controller
 *
 * @category Settings.Controller
 * @package  Vamshop.Settings
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class CachesController extends AppController
{

    public function index()
    {
        $caches = [];
        $configured = Cache::configured();
        if ($this->request->query('sort') === 'title') {
            sort($configured);
            if ($this->request->query('direction') !== 'asc') {
                $configured = array_reverse($configured);
            }
        }
        foreach ($configured as $cache) {
            $engine = Cache::engine($cache);
            $caches[$cache] = $engine;
        }
        $this->set(compact('caches'));
    }

    public function clear()
    {
        $config = $this->request->query('config') ?: 'all';
        if ($config === 'all') {
            $result = Cache::clearAll();
        } else {
            $result = Cache::clear(false, $config);
        }
        if ($result) {
            $this->Flash->success(__d('vamshop', "Cache '%s' cleared", $config));
        } else {
            $this->Flash->warning(__d('vamshop', 'Failed clearing cache'));
        }
        return $this->redirect($this->request->referer());
    }

}
