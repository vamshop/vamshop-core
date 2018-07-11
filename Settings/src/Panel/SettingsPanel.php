<?php

namespace Vamshop\Settings\Panel;

use Cake\Core\Configure;
use DebugKit\DebugPanel;

class SettingsPanel extends DebugPanel
{

    public $plugin = 'Vamshop/Settings';

    public function data()
    {
        return [
            'settings' => Configure::read()
        ];
    }
}
