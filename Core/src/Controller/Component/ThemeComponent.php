<?php

namespace Vamshop\Core\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Event\Event;
use Vamshop\Extensions\VamshopTheme;

class ThemeComponent extends Component
{

    /**
     * @var \Cake\Controller\Controller
     */
    protected $_controller;

    public function __construct(ComponentRegistry $registry, array $config = [])
    {
        $this->_defaultConfig = [
            'theme' => Configure::read('Site.theme')
        ];

        parent::__construct($registry, $config);
    }

    public function beforeFilter(Event $event)
    {
        $this->_controller = $event->subject();
        $theme = $this->config('theme');
        if (!$theme) {
            $this->_controller->viewBuilder()->theme('Vamshop/Core');
            return;
        }

        $this->_controller->viewBuilder()->theme($theme);
        $this->loadThemeSettings($theme);

        $this->_controller->viewBuilder()->helpers(['Vamshop/Core.Theme']);
    }

    /**
     * Load theme settings
     *
     * @return void
     */
    public function loadThemeSettings($theme)
    {
        $prefix = $this->request->param('prefix');
        $croogoTheme = new VamshopTheme();
        $settings = $croogoTheme->getData($theme)['settings'];

        $themePrefix = ($prefix) ? $prefix : '';

        $themeHelpers = [];
        if (isset($settings['prefixes'][$themePrefix])) {
            foreach ($settings['prefixes'][$themePrefix]['helpers'] as $helper => $options) {
                $themeHelpers[$helper] = $options;
            }
        }

        $this->_controller->viewBuilder()->helpers($themeHelpers);
    }
}
