<?php

/**
 * UpgradeTask
 *
 * @package  Vamshop.Vamshop.Console.Command.Task
 * @since    1.5
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */

namespace Vamshop\Core\Shell\Task;

use Vamshop\Core\Shell\AppShell as VamshopAppShell;

class UpgradeTask extends VamshopAppShell
{

/**
 * maps 1.4 controllers to the current plugin
 */
    protected $_controllerMap = [
        'attachments' => 'file_manager',
        'filemanager' => 'file_manager',
        'contacts' => 'contacts',
        'messages' => 'contacts',
        'terms' => 'taxonomy',
        'vocabularies' => 'taxonomy',
        'types' => 'taxonomy',
        'comments' => 'comments',
        'acl_actions' => 'acl',
        'acl_permissions' => 'acl',
        'roles' => 'users',
        'users' => 'users',
        'nodes' => 'nodes',
        'regions' => 'blocks',
        'blocks' => 'blocks',
        'languages' => 'settings',
        'settings' => 'settings',
        'menus' => 'menus',
        'links' => 'menus',
    ];

/**
 * Setting instance
 */
    public $Setting = null;

/**
 * Load Settings plugin and model
 */
    protected function _loadSettingsPlugin()
    {
        if (!Plugin::loaded('Settings')) {
            Plugin::load('Settings');
        }
        if (!$this->Setting) {
            $this->Setting = ClassRegistry::init('Settings.Setting');
        }
    }

/**
 * getOptionParser
 */
    public function getOptionParser()
    {
        return parent::getOptionParser()
            ->addSubCommand('acl', [
                'help' => __d('vamshop', 'Upgrade ACL database for core controllers.'),
                'parser' => [
                    'description' => __d(
                        'vamshop',
                        'Upgrades the ACO hierarchy from 1.3/1.4 so it follows the default ' .
                        'behavior in normal CakePHP applications. The primary difference is ' .
                        'plugin controllers now are stored underneath its own Plugin ACO record, ' .
                        'whereas previous version assumes all Controllers belongs to the root ' .
                        '\'controllers\' node.%s' .
                        '<warning>Ensure that you have a backup of your aros, acos, and aros_acos table ' .
                        'before upgrading.</warning>',
                        $this->nl(2)
                    ),
                ],
            ])
            ->addSubCommand('settings', [
                'help' => __d('vamshop', 'Create settings.json from database'),
            ])
            ->addSubCommand('bootstraps', [
                'help' => __d('vamshop', 'Update Hook.bootstrap settings'),
            ])
            ->addSubCommand('links', [
                'help' => __d('vamshop', 'Update Links in database'),
            ])
            ->addSubCommand('first_migrations', [
                'help' => __d('vamshop', 'Create first migration records'),
            ])
            ->addSubCommand('migrations', [
                'help' => __d('vamshop', 'Run all pending migrations for core plugins'),
            ])
            ->addSubCommand('all', [
                'help' => __d('vamshop', 'Run all upgrade tasks'),
            ]);
    }

/**
 * convert settings.yml to settings.json
 */
    public function settings($keys = [])
    {
        $this->_loadSettingsPlugin();
        if (file_exists(APP . 'config' . DS . 'settings.json')) {
            $this->err(__d('vamshop', '<warning>config/settings.json already exist</warning>'));
        } else {
            $defaultPlugins = [
                'Settings', 'Comments', 'Contacts', 'Nodes', 'Meta', 'Menus',
                'Users', 'Blocks', 'Taxonomy', 'FileManager', 'Ckeditor',
            ];
            $Setting = $this->Setting;
            $setting = $Setting->findByKey('Hook.bootstraps');
            $plugins = explode(',', $setting['Setting']['value']);
            if (is_array($plugins)) {
                foreach ($plugins as $plugin) {
                    if (!in_array($plugin, $defaultPlugins)) {
                        $defaultPlugins[] = $plugin;
                    }
                }
            }
            $Setting->write('Hook.bootstraps', join(',', $defaultPlugins));
            if ($version = file_get_contents(APP . 'VERSION.txt')) {
                $Setting->write('Vamshop.version', $version);
            }
            $Setting->write('Access Control.multiColumn', '', [
                'title' => 'Allow login by username or email',
                'input_type' => 'checkbox',
                'editable' => true,
            ]);
            $Setting->write('Access Control.multiRole', 0, [
                'title' => 'Enable Multiple Roles',
                'input_type' => 'checkbox',
                'editable' => true,
            ]);
            $Setting->write('Access Control.rowLevel', 0, [
                'title' => 'Row Level Access Control',
                'input_type' => 'checkbox',
                'editable' => true,
            ]);
            $Setting->write('Access Control.autoLoginDuration', '+1 week', [
                'title' => '"Remember Me" Cookie Lifetime',
                'description' => 'Eg: +1 day, +1 week',
                'input_type' => 'text',
                'editable' => true,
            ]);
            $this->out(__d('vamshop', '<success>Config/settings.yml created based on `settings` table</success>'));
        }
    }

/**
 * Upgrade ACL database
 */
    public function acl()
    {
        if (!Plugin::loaded('Acl') || !class_exists('AclUpgrade')) {
            $this->err('AclUpgrade class not found or Acl plugin not loaded');
            $this->_stop();
        }
        $Upgrade = new AclUpgrade();
        if (($result = $Upgrade->upgrade()) !== true) {
            $this->err($result);
        } else {
            $this->out('<success>ACL Upgrade completed successfully</success>');
        }
    }

    public function links()
    {
        if (!Plugin::loaded('Menus')) {
            Plugin::load('Menus');
        }
                                $Menus = new MenusHelper(new View());
        $Link = ClassRegistry::init('Menus.Link');
        $links = $Link->find('all', ['fields' => ['id', 'title', 'link']]);

        $count = 0;
        foreach ($links as $link) {
            if (!strstr($link['Link']['link'], 'controller:')) {
                continue;
            }
            if (strstr($link['Link']['link'], 'plugin:')) {
                continue;
            }
            $url = $Menus->linkStringToArray($link['Link']['link']);
            if (isset($this->_controllerMap[$url['controller']])) {
                $url['plugin'] = $this->_controllerMap[$url['controller']];
                $linkString = $Menus->urlToLinkString($url);
                $Link->id = $link['Link']['id'];
                $this->out(__d('vamshop', 'Updating Link %s', $Link->id));
                $this->warn(__d('vamshop', '- %s', $link['Link']['link']));
                $this->success(__d('vamshop', '+ %s', $linkString), 2);
                $Link->saveField('link', $linkString, false);
                $count++;
            }
        }
        $this->out(__d('vamshop', 'Links updated: %d rows', $count));
    }

/**
 * Upgrade Hook.bootstraps
 */
    public function bootstraps()
    {
        $this->_loadSettingsPlugin();

        $bootstraps = Configure::read('Hook.bootstraps');
        $plugins = explode(',', $bootstraps);

        $plugins = $this->_bootstrapReorderByDependency($plugins);
        $plugins = $this->_bootstrapSetupEditor($plugins);

        $this->Setting->write('Hook.bootstraps', join(',', $plugins));
        $this->out(__d('vamshop', 'Hook.bootstraps updated'));
    }

/**
 * Activate/move Wysiwyg before Ckeditor/Tinymce when appropriate
 */
    protected function _bootstrapSetupEditor($plugins)
    {
        $plugins = array_flip($plugins);
        if (empty($plugins['Ckeditor']) && empty($plugins['Tinymce'])) {
            return;
        }
        foreach ($plugins as $plugin => &$value) {
            $value *= 10;
        }

        if (!empty($plugins['Ckeditor']) && !empty($plugins['Tinymce'])) {
            $editor = ($plugins['Ckeditor'] < $plugins['Tinymce']) ? $plugins['Ckeditor'] : $plugins['Tinymce'];
        } elseif (!empty($plugins['Ckeditor'])) {
            $editor = $plugins['Ckeditor'];
        } else {
            $editor = $plugins['Tinymce'];
        }

        if (empty($plugins['Wysiwyg'])) {
            $plugins['Wysiwyg'] = $editor - 1;
        } else {
            if ($plugins['Wysiwyg'] >= $editor) {
                $plugins['Wysiwyg'] = $editor - 1;
            }
        }

        asort($plugins);
        $plugins = array_flip($plugins);
        return $plugins;
    }

/**
 * Re-order plugins based on dependencies:
 * for e.g, Ckeditor depends on Wysiwyg
 * if in Hook.bootstraps Ckeditor appears before Wysiwyg,
 * we will reorder it so that it loads right after Wysiwyg
 */
    protected function _bootstrapReorderByDependency($plugins)
    {
        $pluginsOrdered = $plugins;
        foreach ($plugins as $p) {
            $jsonPath = APP . 'Plugin' . DS . $p . DS . 'config' . DS . 'plugin.json';
            if (file_exists($jsonPath)) {
                $pluginData = json_decode(file_get_contents($jsonPath), true);
                if (isset($pluginData['dependencies']['plugins'])) {
                    foreach ($pluginData['dependencies']['plugins'] as $d) {
                        $k = array_search($p, $pluginsOrdered);
                        $dk = array_search($d, $pluginsOrdered);
                        if ($dk > $k) {
                            unset($pluginsOrdered[$k]);
                            $pluginsOrdered = array_slice($pluginsOrdered, 0, $k + 1, true) +
                                [$p => $p] +
                                array_slice($pluginsOrdered, $k + 1, count($pluginsOrdered) - 1, true);
                            $pluginsOrdered = array_values($pluginsOrdered);
                        }
                    }
                }
            }
        }
        return $pluginsOrdered;
    }

/**
 * create schema_migrations record for $plugin
 */
    protected function _createFirstMigration($plugin)
    {
        static $Migration;
        if (empty($Migration)) {
            $Migration = ClassRegistry::init([
                'class' => 'AppModel',
                'table' => 'schema_migrations',
            ]);
        }
        $className = 'FirstMigration' . $plugin;
        $migration = $Migration->findByClass($className);
        if (!empty($migration)) {
            return true;
        }
        $Migration->create();
        return $Migration->save([
            'class' => $className,
            'type' => $plugin,
        ]);
    }

/**
 * Create default FirstMigration records for installations using vamshop_data.sql
 */
    public function first_migrations()
    {
        foreach ((array)Configure::read('Core.corePlugins') as $plugin) {
            $result = $this->_createFirstMigration($plugin);
            if (!$result) {
                $this->error(sprintf('Unable to setup FirstMigration records for %s', $plugin));
            }
        }
        $this->success('FirstMigration default records created');
    }

/**
 * Runs all available pending migrations for core plugins
 */
    public function migrations()
    {
        $VamshopPlugin = new VamshopPlugin();
        foreach ((array)Configure::read('Core.corePlugins') as $plugin) {
            $result = $VamshopPlugin->migrate($plugin);
            if (!$result) {
                $this->out($VamshopPlugin->migrationErrors);
            }
        }
    }

/**
 * Runs all available subcommands
 */
    public function all()
    {
        foreach ($this->OptionParser->subcommands() as $command) {
            $name = $command->name();
            if ($name === 'all') {
                continue;
            }
            $this->out(__d('vamshop', 'Upgrade "%s"', $name));
            $this->$name();
        }
    }

    public function main()
    {
        if (empty($this->args)) {
            return $this->out($this->OptionParser->help());
        }
        $commands = array_keys($this->OptionParser->subcommands('vamshop'));
        $command = $this->args[0];
        if ($command[0] != '_' && in_array($command, $commands)) {
            return $this->{$command}();
        } else {
            $this->out(__d('vamshop', 'Command not recognized'));
        }
    }
}
