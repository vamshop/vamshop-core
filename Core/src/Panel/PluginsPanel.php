<?php

namespace Vamshop\Core\Panel;

use Cake\Core\Plugin;
use DebugKit\DebugPanel;

class PluginsPanel extends DebugPanel
{

    public $plugin = 'Vamshop/Core';

    public function data()
    {
        return [
            'loaded' => Plugin::loaded()
        ];
    }

    public function summary()
    {
        return count(Plugin::loaded());
    }
}
