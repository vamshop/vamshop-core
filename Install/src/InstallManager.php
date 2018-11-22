<?php

namespace Vamshop\Install;

use Cake\Core\Configure;
use Cake\Database\Exception\MissingConnectionException;
use Cake\Datasource\ConnectionManager;
use Cake\Log\LogTrait;
use Cake\ORM\TableRegistry;
use Vamshop\Acl\AclGenerator;
use Vamshop\Core\Plugin;
use Vamshop\Core\Database\SequenceFixer;

class InstallManager
{
    const PHP_VERSION = '5.5.9';
    const CAKE_VERSION = '3.4.8';

    const DATASOURCE_REGEX = "/(\'Datasources'\s\=\>\s\[\n\s*\'default\'\s\=\>\s\[\n\X*\'__FIELD__\'\s\=\>\s\').*(\'\,)(?=\X*\'test\'\s\=\>\s)/";

    use LogTrait;

    /**
     * Default configuration
     *
     * @var array
     * @access public
     */
    public $defaultConfig = [
        'name' => 'default',
        'className' => 'Cake\Database\Connection',
        'driver' => 'Cake\Database\Driver\Mysql',
        'persistent' => false,
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'vamshop',
        'port' => null,
        'schema' => null,
        'prefix' => null,
        'encoding' => 'utf8mb4',
        'timezone' => 'UTC',
        'cacheMetadata' => true,
        'log' => false,
        'quoteIdentifiers' => false,
    ];

    /**
     *
     * @var \Vamshop\Core\Plugin
     */
    protected $_vamshopPlugin;

    public static function versionCheck()
    {
        return [
            'php' => version_compare(phpversion(), static::PHP_VERSION, '>='),
            'cake' => version_compare(Configure::version(), static::CAKE_VERSION, '>='),
        ];
    }

    protected function _updateDatasourceConfig($path, $field, $value)
    {
        $config = file_get_contents($path);
        $config = preg_replace(
            str_replace('__FIELD__', $field, InstallManager::DATASOURCE_REGEX),
            '$1' . addslashes($value) . '$2',
            $config
        );

        if (function_exists('opcache_reset')) {
            opcache_reset();
        }

        return file_put_contents($path, $config);
    }

    public function createDatabaseFile($config)
    {
        $config += $this->defaultConfig;

        if ($config['driver'] === 'Cake\Database\Driver\Postgres') {
            if (empty($config['port'])) {
                $config['port'] = 5432;
            }
        }

        ConnectionManager::drop('default');
        ConnectionManager::config('default', $config);

        try {
            $db = ConnectionManager::get('default');
            $db->connect();
        } catch (MissingConnectionException $e) {
            ConnectionManager::drop('default');
            return __d('vamshop', 'Could not connect to database: ') . $e->getMessage();
        }
        if (!$db->isConnected()) {
            ConnectionManager::drop('default');
            return __d('vamshop', 'Could not connect to database.');
        }

        $configPath = ROOT . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'app.php';
        foreach (['host', 'username', 'password', 'database', 'driver'] as $field) {
            if (isset($config[$field]) && (!empty($config[$field] || $field == 'password'))) {
                $this->_updateDatasourceConfig($configPath, $field, $config[$field]);
            }
        }

        return true;
    }

    /**
     * Mark installation as complete
     *
     * @return bool true when successful
     */
    public function installCompleted()
    {
        Plugin::load('Vamshop/Settings', ['routes' => true]);
        $Setting = TableRegistry::get('Vamshop/Settings.Settings');
        $Setting->removeBehavior('Cached');
        if (!function_exists('mcrypt_decrypt')) {
            $Setting->write('Access Control.autoLoginDuration', '');
        }

        return $Setting->write('Vamshop.installed', true);
    }

    /**
     * Run Migrations and add data in table
     *
     * @return bool True if migrations have succeeded
     */
    public function setupDatabase()
    {
        $plugins = [
            'Vamshop/Users',
            'Vamshop/Acl',
            'Vamshop/Blocks',
            'Vamshop/Taxonomy',
            'Vamshop/FileManager',
            'Vamshop/Meta',
            'Vamshop/Nodes',
            'Vamshop/Comments',
            'Vamshop/Contacts',
            'Vamshop/Menus',
            'Vamshop/Dashboards',
            'Vamshop/Settings',
        ];

        $migrationsSucceed = true;
        foreach ($plugins as $plugin) {
            $migrationsSucceed = $this->runMigrations($plugin);
            if (!$migrationsSucceed) {
                $this->log('Migrations failed for ' . $plugin, LOG_CRIT);
                break;
            }
        }

        foreach ($plugins as $plugin) {
            $migrationsSucceed = $this->seedTables($plugin);
            if (!$migrationsSucceed) {
                break;
            }
        }

        if ($migrationsSucceed) {
            $fixer = new SequenceFixer();
            $fixer->fix('default');
        }

        return $migrationsSucceed;
    }

    protected function _getVamshopPlugin()
    {
        if (!($this->_vamshopPlugin instanceof Plugin)) {
            $this->_setVamshopPlugin(new Plugin());
        }

        return $this->_vamshopPlugin;
    }

    protected function _setVamshopPlugin($vamshopPlugin)
    {
        unset($this->_vamshopPlugin);
        $this->_vamshopPlugin = $vamshopPlugin;
    }

    public function runMigrations($plugin)
    {
        if (!Plugin::loaded($plugin)) {
            Plugin::load($plugin);
        }
        $vamshopPlugin = $this->_getVamshopPlugin();
        $result = $vamshopPlugin->migrate($plugin);
        if (!$result) {
            $this->log($vamshopPlugin->migrationErrors);
        }

        return $result;
    }

    public function seedTables($plugin)
    {
        if (!Plugin::loaded($plugin)) {
            Plugin::load($plugin);
        }
        $vamshopPlugin = $this->_getVamshopPlugin();

        return $vamshopPlugin->seed($plugin);
    }

    /**
     * Create admin user
     *
     * @var array $user User datas
     * @return If user is created
     */
    public function createAdminUser($user)
    {
        $Users = TableRegistry::get('Vamshop/Users.Users');
        $Roles = TableRegistry::get('Vamshop/Users.Roles');
        $Roles->addBehavior('Vamshop/Core.Aliasable');

        if (is_array($user)) {
            $user = $Users->newEntity($user);
        }

        $user->name = $user['username'];
        $user->email = '';
        $user->timezone = 'UTC';
        $user->role_id = $Roles->byAlias('superadmin');
        $user->status = true;
        $user->activation_key = md5(uniqid());
        if ($user->errors()) {
            return __d('vamshop', 'Unable to create administrative user. Validation errors:');
        }

        return $Users->save($user) !== false;
    }

    public function setupAcos()
    {
        $generator = new AclGenerator();
        if ($this->controller) {
            $dummyShell = new DummyShell();
            $generator->Shell = $dummyShell;
        }
        $generator->insertAcos(ConnectionManager::get('default'));
    }

    public function setupGrants($success = null, $error = null)
    {
        if (!$success) {
            $success = function() {
            };
        }
        if (!$error) {
            $error = function () {
            };
        }

        $Roles = TableRegistry::get('Vamshop/Users.Roles');
        $Roles->addBehavior('Vamshop/Core.Aliasable');

        $Permission = TableRegistry::get('Vamshop/Acl.Permissions');
        $admin = 'Role-admin';
        $public = 'Role-public';
        $registered = 'Role-registered';
        $publisher = 'Role-publisher';

        $setup = [
            //            'controllers/Vamshop\Comments/Comments/index' => [$public],
            //            'controllers/Vamshop\Comments/Comments/add' => [$public],
            //            'controllers/Vamshop\Comments/Comments/delete' => [$registered],
            'controllers/Vamshop\Contacts/Contacts/view' => [$public],
            'controllers/Vamshop\Nodes/Nodes/index' => [$public],
            'controllers/Vamshop\Nodes/Nodes/term' => [$public],
            'controllers/Vamshop\Nodes/Nodes/promoted' => [$public],
            'controllers/Vamshop\Nodes/Nodes/search' => [$public],
            'controllers/Vamshop\Nodes/Nodes/view' => [$public],
            'controllers/Vamshop\Users/Users/index' => [$registered],
            'controllers/Vamshop\Users/Users/add' => [$public],
            'controllers/Vamshop\Users/Users/activate' => [$public],
            'controllers/Vamshop\Users/Users/edit' => [$registered],
            'controllers/Vamshop\Users/Users/forgot' => [$public],
            'controllers/Vamshop\Users/Users/reset' => [$public],
            'controllers/Vamshop\Users/Users/login' => [$public],
            'controllers/Vamshop\Users/Users/logout' => [$registered],
            'controllers/Vamshop\Users/Admin/Users/logout' => [$registered],
            'controllers/Vamshop\Users/Users/view' => [$registered],

            'controllers/Vamshop\Dashboards/Admin/Dashboards' => [$admin],
            'controllers/Vamshop\Nodes/Admin/Nodes' => [$publisher],
            'controllers/Vamshop\Menus/Admin/Menus' => [$publisher],
            'controllers/Vamshop\Menus/Admin/Links' => [$publisher],
            'controllers/Vamshop\Blocks/Admin/Blocks' => [$publisher],
            'controllers/Vamshop\FileManager/Admin/Attachments' => [$publisher],
            'controllers/Vamshop\FileManager/Admin/FileManager' => [$publisher],
            'controllers/Vamshop\Contacts/Admin/Contacts' => [$publisher],
            'controllers/Vamshop\Contacts/Admin/Messages' => [$publisher],
            'controllers/Vamshop\Users/Admin/Users/view' => [$admin],
        ];

        foreach ($setup as $aco => $roles) {
            foreach ($roles as $aro) {
                try {
                    $result = $Permission->allow($aro, $aco);
                    if ($result) {
                        $success(__d('vamshop', 'Permission %s granted to %s', $aco, $aro));
                    }
                } catch (\Exception $e) {
                    $error($e->getMessage());
                }
            }
        }
    }
}

class DummyShell {
    use LogTrait;
    function out($msg, $newlines = 1, $level = 1) {
        $msg = preg_replace('/\<\/?\w+\>/', null, $msg);
        $this->log($msg);
    }
}
