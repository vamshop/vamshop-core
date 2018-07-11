<?php

namespace Vamshop\Settings\Shell;

use Cake\Console\Shell;
use Vamshop\Core\Plugin;

/**
 * Settings Shell
 *
 * Manipulates Settings via CLI
 *  ./Console/vamshop settings.settings read -a
 *  ./Console/vamshop settings.settings delete Some.key
 *  ./Console/vamshop settings.settings write Some.key newvalue
 *  ./Console/vamshop settings.settings write Some.key newvalue -create
 *
 * @category Shell
 * @package  Vamshop.Settings.Console.Command
 * @author   Rachman Chavik <rchavik@xintesa.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class SettingsShell extends Shell
{

    /**
     * Initialize
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Vamshop/Settings.Settings');
    }

    /**
     * getOptionParser
     */
    public function getOptionParser()
    {
        return parent::getOptionParser()
            ->description('Vamshop Settings utility')
            ->addSubCommand('read', [
                'help' => __d('vamshop', 'Displays setting values'),
                'parser' => [
                    'arguments' => [
                        'key' => [
                            'help' => __d('vamshop', 'Setting key'),
                            'required' => false,
                        ],
                    ],
                    'options' => [
                        'all' => [
                            'help' => __d('vamshop', 'List all settings'),
                            'short' => 'a',
                            'boolean' => true,
                        ]
                    ],
                ],
            ])
            ->addSubcommand('write', [
                'help' => __d('vamshop', 'Write setting value for a given key'),
                'parser' => [
                    'arguments' => [
                        'key' => [
                            'help' => __d('vamshop', 'Setting key'),
                            'required' => true,
                        ],
                        'value' => [
                            'help' => __d('vamshop', 'Setting value'),
                            'required' => true,
                        ],
                    ],
                    'options' => [
                        'create' => [
                            'boolean' => true,
                            'short' => 'c',
                        ],
                        'title' => [
                            'short' => 't',
                        ],
                        'description' => [
                            'short' => 'd',
                        ],
                        'input_type' => [
                            'choices' => [
                                'text', 'textarea', 'checkbox', 'multiple',
                                'radio', 'file',
                            ],
                            'short' => 'i',
                        ],
                        'editable' => [
                            'short' => 'e',
                            'choices' => ['1', '0', 'y', 'n', 'Y', 'N'],
                        ],
                        'params' => [
                            'short' => 'p',
                        ],
                    ],
                ]
            ])
            ->addSubcommand('delete', [
                'help' => __d('vamshop', 'Delete setting based on key'),
                'parser' => [
                    'arguments' => [
                        'key' => [
                            'help' => __d('vamshop', 'Setting key'),
                            'required' => true,
                        ],
                    ],
                ]
            ])
            ->addSubcommand('update_app_version_info', [
                'help' => __d('vamshop', 'Update app version string from git tag information'),
            ])
            ->addSubcommand('update_version_info', [
                'help' => __d('vamshop', 'Update version string from git tag information'),
            ]);
    }

    /**
     * Read setting
     *
     * @param string $key
     * @return void
     */
    public function read()
    {
        if (empty($this->args)) {
            if ($this->params['all'] === true) {
                $key = null;
            } else {
                $this->out($this->OptionParser->help('get'));
                return;
            }
        } else {
            $key = $this->args[0];
        }
        $settings = $this->Settings->find('all', [
            'conditions' => [
                'Settings.key like' => '%' . $key . '%',
            ],
            'order' => 'Settings.weight asc',
        ]);
        $this->out("Settings: ", 2);
        foreach ($settings as $data) {
            $this->out(__d('vamshop', "    %-30s: %s", $data->key, $data->value));
        }
        $this->out();
    }

    /**
     * Write setting
     *
     * @param string $key
     * @param string $val
     * @return void
     */
    public function write()
    {
        $key = $this->args[0];
        $val = $this->args[1];
        $setting = $this->Settings->find()
            ->select(['id', 'key', 'value'])
            ->where([
                'Settings.key' => $key,
            ])
            ->first();
        $this->out(__d('vamshop', 'Updating %s', $key), 2);
        $ask = __d('vamshop', "Confirm update");
        if ($setting || $this->params['create']) {
            $text = '-';
            if ($setting) {
                $text = __d('vamshop', '- %s', $setting->value);
            }
            $this->warn($text);
            $this->success(__d('vamshop', '+ %s', $val));

            if ('y' == $this->in($ask, ['y', 'n'], 'n')) {
                $keys = [
                    'title' => null, 'description' => null,
                    'input_type' => null, 'editable' => null, 'params' => null,
                ];
                $options = array_intersect_key($this->params, $keys);

                if (isset($options['editable'])) {
                    $options['editable'] = in_array(
                        $options['editable'], ['y', 'Y', '1']
                    );
                }

                $this->Settings->write($key, $val, $options);
                $this->success(__d('vamshop', 'Setting updated'));
            } else {
                $this->warn(__d('vamshop', 'Cancelled'));
            }
        } else {
            $this->warn(__d('vamshop', 'Key: %s not found', $key));
        }
    }

/**
 * Delete setting
 *
 * @param string $key
 * @return void
 */
    public function delete()
    {
        $key = $this->args[0];
        $setting = $this->Settings->find()
            ->select(['id', 'key', 'value'])
            ->where([
                'Settings.key' => $key,
            ])
            ->first();
        $this->out(__d('vamshop', 'Deleting %s', $key), 2);
        $ask = __d('vamshop', 'Delete?');
        if ($setting) {
            if ('y' == $this->in($ask, ['y', 'n'], 'n')) {
                $this->Settings->deleteKey($setting->key);
                $this->success(__d('vamshop', 'Setting deleted'));
            } else {
                $this->warn(__d('vamshop', 'Cancelled'));
            }
        } else {
            $this->warn(__d('vamshop', 'Key: %s not found', $key));
        }
    }

/**
 * Update Vamshop.version in settings
 */
    public function updateVersionInfo()
    {
        $gitDir = realpath(Plugin::path('Vamshop/Core') . '..') . DS . '.git';
        if (!file_exists($gitDir)) {
            $this->err('Git repository not found');
            return false;
        }
        if (!is_dir($gitDir)) {
            $gitDir = dirname($gitDir);
        }

        $git = trim(shell_exec('which git'));
        if (empty($git)) {
            $this->err('Git executable not found');
            return false;
        }

        chdir($gitDir);
        $version = trim(shell_exec('git describe --tags'));
        if ($version) {
            $this->runCommand(['write', 'Vamshop.version', $version]);
        }
    }

/**
 * Update Vamshop.appVersion in settings
 */
    public function updateAppVersionInfo()
    {
        $gitDir = realpath(ROOT . DS . '.git');
        if (!file_exists($gitDir)) {
            $this->err('Git repository not found');
            return false;
        }
        if (!is_dir($gitDir)) {
            $gitDir = dirname($gitDir);
        }

        $git = trim(shell_exec('which git'));
        if (empty($git)) {
            $this->err('Git executable not found');
            return false;
        }

        chdir($gitDir);
        $version = trim(shell_exec('git describe --tags'));
        if ($version) {
            $this->runCommand(['write', 'Vamshop.appVersion', $version]);
        }
    }

}
