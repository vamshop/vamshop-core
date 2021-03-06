<?php

namespace Vamshop\Core\TestSuite;

use Cake\Database\Connection;
use Cake\Database\Driver\Postgres;
use Cake\TestSuite\Fixture\TestFixture;

/**
 * VamshopTestFixture class
 *
 * @category TestSuite
 * @package  Vamshop
 * @version  1.4
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @author   Rachman Chavik <rchavik@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class VamshopTestFixture extends TestFixture
{

/**
 * _fixSequence
 *
 * @param Postgres $db
 */
//	protected function _fixSequence($db) {
//		$sql = sprintf("
//			SELECT setval(pg_get_serial_sequence('%s', 'id'), (SELECT MAX(id) FROM %s))",
//			$this->table, $this->table);
//
//		$db->execute($sql);
//	}

/**
 * insert
 *
 * @param Object $db
 * @return array
 */
//	public function insert(Connection $db) {
//		$result = parent::insert($db);
//		if ($result === true && $db instanceof Postgres) {
//			$this->_fixSequence($db);
//		}
//		return $result;
//	}
}
