<?php

namespace Vamshop\Core\Shell;

use App\Controller\AppController;
use Cake\Controller\Controller;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Utility\Inflector;
use Vamshop\Extensions\VamshopPlugin;
use Vamshop\Extensions\VamshopTheme;

/**
 * Ext Shell
 *
 * Activate/Deactivate Plugins/Themes
 *  ./Console/vamshop ext activate plugin Example
 *  ./Console/vamshop ext activate theme minimal
 *  ./Console/vamshop ext deactivate plugin Example
 *  ./Console/vamshop ext deactivate theme
 *
 * @category Shell
 * @package  Vamshop.Vamshop.Console.Command
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class ExtShell extends AppShell
{

/**
 * Models we use
 *
 * @var array
 */
    public $uses = ['Settings.Setting'];

/**
 * VamshopPlugin class
 *
 * @var VamshopPlugin
 */
    protected $_VamshopPlugin = null;

/**
 * VamshopTheme class
 *
 * @var VamshopTheme
 */
    protected $_VamshopTheme = null;

/**
 * Controller
 *
 * @var Controller
 * @todo Remove this when PluginActivation dont need controllers
 */
    protected $_Controller = null;

/**
 * Initialize
 *
 * @param type $stdout
 * @param type $stderr
 * @param type $stdin
 */
    public function __construct($stdout = null, $stderr = null, $stdin = null)
    {
        parent::__construct($stdout, $stderr, $stdin);
        $this->_VamshopPlugin = new VamshopPlugin();
        $this->_VamshopTheme = new VamshopTheme();
        $Request = new Request();
        $Response = new Response();
        $this->_Controller = new AppController($Request, $Response);
        $this->_Controller->startupProcess();
        $this->_VamshopPlugin->setController($this->_Controller);
        $this->initialize();
    }

/**
 * Call the appropriate command
 *
 * @return void
 */
    public function main()
    {
        $args = $this->args;
        $this->args = array_map('strtolower', $this->args);
        $method = $this->args[0];
        $type = $this->args[1];
        $ext = isset($args[2]) ? $args[2] : null;
        $force = isset($this->params['force']) ? $this->params['force'] : false;
        if ($type == 'theme') {
            $extensions = $this->_VamshopTheme->getThemes();
            $theme = Configure::read('Site.theme');
            $active = !empty($theme) ? $theme == 'default' : true;
        } elseif ($type == 'plugin') {
            $extensions = $this->_VamshopPlugin->getPlugins();
            if ($force) {
                $plugins = array_combine($p = Plugin::loaded(), $p);
                $extensions += $plugins;
            }
            $active = Plugin::loaded($ext);
        }
        if ($type == 'theme' && $method == 'deactivate') {
            $this->err(__d('vamshop', 'Theme cannot be deactivated, instead activate another theme.'));
            return false;
        }
        if (!empty($ext) && !isset($extensions[$ext]) && !$active && !$force) {
            $this->err(__d('vamshop', '%s "%s" not found.', ucfirst($type), $ext));
            return false;
        }
        switch ($method) {
            case 'list':
                $call = Inflector::pluralize($type);
                return $this->{$call}($ext);
            default:
                if (empty($ext)) {
                    $this->err(__d('vamshop', '%s name must be provided.', ucfirst($type)));
                    return false;
                }
                return $this->{'_' . $method . ucfirst($type)}($ext);
        }
    }

/**
 * Display help/options
 */
    public function getOptionParser()
    {
        return parent::getOptionParser()
            ->description(__d('vamshop', 'Activate Plugins & Themes'))
            ->addArguments([
                'method' => [
                    'help' => __d('vamshop', 'Method to perform'),
                    'required' => true,
                    'choices' => ['list', 'activate', 'deactivate'],
                ],
                'type' => [
                    'help' => __d('vamshop', 'Extension type'),
                    'required' => true,
                    'choices' => ['plugin', 'theme'],
                ],
                'extension' => [
                    'help' => __d('vamshop', 'Name of extension'),
                ],
            ])
            ->addOption('all', [
                'short' => 'a',
                'boolean' => true,
                'help' => 'List all extensions',
            ])
            ->addOption('force', [
                'short' => 'f',
                'boolean' => true,
                'help' => 'Force method operation even when plugin does not provide a `plugin.json` file.'
            ]);
    }

/**
 * Activate a plugin
 *
 * @param string $plugin
 * @return boolean
 */
    protected function _activatePlugin($plugin)
    {
        $result = $this->_VamshopPlugin->activate($plugin);
        if ($result === true) {
            $this->out(__d('vamshop', 'Plugin "%s" activated successfully.', $plugin));
            return true;
        } elseif (is_string($result)) {
            $this->err($result);
        } else {
            $this->err(__d('vamshop', 'Plugin "%s" could not be activated. Please, try again.', $plugin));
        }
        return false;
    }

/**
 * Deactivate a plugin
 *
 * @param string $plugin
 * @return boolean
 */
    protected function _deactivatePlugin($plugin)
    {
        $usedBy = $this->_VamshopPlugin->usedBy($plugin);
        if ($usedBy === false) {
            $result = $this->_VamshopPlugin->deactivate($plugin);
            if ($result === false) {
                $this->err(__d('vamshop', 'Plugin "%s" could not be deactivated. Please, try again.', $plugin));
            } elseif (is_string($result)) {
                $this->err($result);
            }
        } else {
            $result = false;
            if ($usedBy !== false) {
                if ($this->params['force'] === false) {
                    $this->err(__d('vamshop', 'Plugin "%s" could not be deactivated since "%s" depends on it.', $plugin, implode(', ', $usedBy)));
                } else {
                    $result = true;
                }
            }
        }
        if ($this->params['force'] === true || $result === true) {
            $this->_VamshopPlugin->removeBootstrap($plugin);
            $result = true;
        }
        if ($result === true) {
            $this->out(__d('vamshop', 'Plugin "%s" deactivated successfully.', $plugin));
            return true;
        }
        return false;
    }

/**
 * Activate a theme
 *
 * @param string $theme Name of theme
 * @return boolean
 */
    protected function _activateTheme($theme)
    {
        if ($this->_VamshopTheme->activate($theme)) {
            $this->out(__d('vamshop', 'Theme "%s" activated successfully.', $theme));
        } else {
            $this->err(__d('vamshop', 'Theme "%s" activation failed.', $theme));
        }
        return true;
    }

/**
 * List plugins
 */
    public function plugins($plugin = null)
    {
        $all = $this->params['all'];
        $plugins = $plugin == null ? array_keys(Configure::read('plugins')) : [$plugin];
        $loaded = Plugin::loaded();
        $VamshopPlugin = new VamshopPlugin();
        $this->out(__d('vamshop', 'Plugins:'), 2);
        $this->out(__d('vamshop', '%-20s%-50s%s', __d('vamshop', 'Plugin'), __d('vamshop', 'Author'), __d('vamshop', 'Status')));
        $this->out(str_repeat('-', 80));
        foreach ($plugins as $plugin) {
            $status = '<info>inactive</info>';
            if ($active = in_array($plugin, $loaded)) {
                $status = '<success>active</success>';
            }
            if (!$active && !$all) {
                continue;
            }
            $data = $VamshopPlugin->getPluginData($plugin);
            $author = isset($data['author']) ? $data['author'] : '';
            $this->out(__d('vamshop', '%-20s%-50s%s', $plugin, $author, $status));
        }
    }

/**
 * List themes
 */
    public function themes($theme = null)
    {
        $VamshopTheme = new VamshopTheme();
        $all = $this->params['all'];
        $current = Configure::read('Site.theme');
        $themes = $theme == null ? $VamshopTheme->getThemes() : [$theme];
        $this->out("Themes:", 2);
        $default = empty($current) || $current == 'default';
        $this->out(__d('vamshop', '%-20s%-50s%s', __d('vamshop', 'Theme'), __d('vamshop', 'Author'), __d('vamshop', 'Status')));
        $this->out(str_repeat('-', 80));
        foreach ($themes as $theme) {
            $active = $theme == $current || $default && $theme == 'default';
            $status = $active ? '<success>active</success>' : '<info>inactive</info>';
            if (!$active && !$all) {
                continue;
            }
            $data = $VamshopTheme->getThemeData($theme);
            $author = isset($data['author']) ? $data['author'] : '';
            $this->out(__d('vamshop', '%-20s%-50s%s', $theme, $author, $status));
        }
    }
}
