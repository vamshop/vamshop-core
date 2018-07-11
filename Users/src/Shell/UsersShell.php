<?php

namespace Vamshop\Users\Shell;

use Cake\Console\Shell;
use Vamshop\Users\Model\Entity\User;

/**
 * UsersShell
 *
 * @package Vamshop.Users.Shell
 */
class UsersShell extends Shell
{

    public $uses = [
        'Users.User',
    ];

    /**
     * Initialize
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Vamshop/Users.Users');
    }

    /**
     * getOptionParser
     */
    public function getOptionParser()
    {
        return parent::getOptionParser()
            ->addSubCommand('create', [
                'help' => __d('vamshop', 'Create a new user'),
                'parser' => [
                    'arguments' => [
                        'username' => [
                            'required' => true,
                            'help' => __d('vamshop', 'Username to reset'),
                        ],
                        'password' => [
                            'required' => true,
                            'help' => __d('vamshop', 'New user password'),
                        ],
                        'role_id' => [
                            'required' => true,
                            'help' => __d('vamshop', 'Role id for user'),
                        ],
                    ],
                ],
            ])
            ->addSubCommand('reset', [
                'help' => __d('vamshop', 'Reset user password'),
                'parser' => [
                    'arguments' => [
                        'username' => [
                            'required' => true,
                            'help' => __d('vamshop', 'Username to reset'),
                        ],
                        'password' => [
                            'required' => true,
                            'help' => __d('vamshop', 'New user password'),
                        ],
                    ],
                ],
            ]);
    }

    /**
     * reset
     */
    public function reset()
    {
        $username = $this->args[0];
        $password = $this->args[1];

        $user = $this->Users->findByUsername($username)->first();
        if (empty($user)) {
            return $this->warn(__d('vamshop', 'User \'%s\' not found', $username));
        }
        $user->clean();
        $user->password = $password;
        $result = $this->Users->save($user);
        if ($result) {
            $this->success(__d('vamshop', 'Password for \'%s\' has been changed', $username));
        }
    }

    /**
     * reset
     */
    public function create()
    {
        $username = $this->args[0];
        $password = $this->args[1];
        $roleId = $this->args[2];

        $user = $this->Users->findByUsername($username)->first();
        if ($user) {
            return $this->warn(__d('vamshop', 'User \'%s\' already exists', $username));
        }

        $user = new User([
            'username' => $username,
            'password' => $password,
            'role_id' => $roleId,
            'name' => $username,
            'email' => $username,
            'activation_key' => $this->Users->generateActivationKey(),
            'status' => true,
        ]);
        $result = $this->Users->save($user);
        if ($result) {
            $this->success(__d('vamshop', 'User \'%s\' has been created', $username));
        }
    }

}
