<?php

namespace Vamshop\Dashboards\Model\Table;

use Vamshop\Core\Model\Table\VamshopTable;

/**
 * Dashboard Model
 *
 * @category Dashboards.Model
 * @package  Vamshop.Dashboards.Model
 * @version  2.2
 * @author   Walther Lalk <emailme@waltherlalk.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class DashboardsTable extends VamshopTable
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('dashboards');
		$this->addBehavior('Timestamp');
		$this->addBehavior('ADmad/Sequence.Sequence', [
			'order' => 'weight',
			'scope' => ['user_id', 'column'],
		]);
        $this->belongsTo('Users', [
            'className' => 'Vamshop/Users.Users'
        ]);
        $this->connection()->getDriver()->enableAutoQuoting();
    }
}
