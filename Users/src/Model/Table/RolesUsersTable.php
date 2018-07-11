<?php

namespace Vamshop\Users\Model\Table;

use Cake\Core\Exception\Exception;
use Vamshop\Core\Model\Table\VamshopTable;

/**
 * RolesUsers
 *
 * @category Model
 * @package  Vamshop.Users.Model
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class RolesUsersTable extends VamshopTable {

    public function initialize(array $config)
    {
        $this->belongsTo('Users', [
            'className' => 'Vamshop/Users.Users',
        ]);
        $this->belongsTo('Roles', [
            'className' => 'Vamshop/Users.Roles',
        ]);
    }

/**
 * Get Ids of Role's Aro assigned to user
 *
 * @param $userId integer user id
 * @return array array of Role Aro Ids
 */
    public function getRolesAro($userId) {
        $rolesUsers = $this->find('all', array(
            'fields' => 'role_id',
            'conditions' => array(
                $this->aliasField('user_id') => $userId,
            ),
            'cache' => array(
                'name' => 'user_roles_' . $userId,
                'config' => 'nodes_index',
            ),
        ));
        $aroIds = array();
        foreach ($rolesUsers as $rolesUser) {
            try {
                $aro = $this->Roles->Aros->node(array(
                    'model' => 'Roles',
                    'foreign_key' => $rolesUser->role_id,
                ))->first();
                $aroIds[] = $aro->id;
            } catch (Exception $e) {
                continue;
            }
        }
        return $aroIds;
    }
}
