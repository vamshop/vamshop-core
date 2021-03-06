<?php

namespace Vamshop\Install\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\File;
use Cake\Utility\Security;
use Vamshop\Core\Plugin;

class InstallTable extends Table
{

/**
 * name
 *
 * @var string
 */
    public $name = 'Install';

/**
 * useTable
 *
 * @var string
 */
    public $useTable = false;

/**
 *
 * @var VamshopPlugin
 */
    protected $_VamshopPlugin = null;

/**
 * Create admin user
 *
 * @var array $user User datas
 * @return If user is created
 */
    public function addAdminUser($user)
    {
        $Users = TableRegistry::get('Vamshop/Users.Users');
        $Users->removeBehavior('Cached');
        $Roles = TableRegistry::get('Vamshop/Users.Roles');
        $Roles->addBehavior('Vamshop/Core.Aliasable');
        $Users->validator('default')->remove('email')->remove('password');
        $user['name'] = $user['username'];
        $user['email'] = '';
        $user['timezone'] = 'UTC';
        $user['role_id'] = $Roles->byAlias('superadmin');
        $user['status'] = true;
        $user['activation_key'] = md5(uniqid());
        $data = $Users->newEntity($user);
        if ($data->errors()) {
            $this->err('Unable to create administrative user. Validation errors:');
            return $this->err($data->errors());
        }
        $saved = $Users->save($data);
        return $saved;
    }
}
