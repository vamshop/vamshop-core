<?php

namespace Vamshop\Core\View\Helper;

use Cake\ORM\Entity;
use Cake\Routing\Exception\MissingRouteException;
use Cake\View\Helper;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Utility\Hash;
use Vamshop\Core\Vamshop;
use Cake\Utility\Inflector;

/**
 * Layout Helper
 *
 * @category Helper
 * @package  Vamshop.Vamshop.View.Helper
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class LayoutHelper extends Helper
{

/**
 * Other helpers used by this helper
 *
 * @var array
 * @access public
 */
    public $helpers = [
        'Vamshop/Core.Vamshop',
        'Vamshop/Core.Theme',
        'Html',
        'Form',
        'Flash'
    ];

/**
 * Core helpers
 *
 * Extra supported callbacks, like beforeNodeInfo() and afterNodeInfo(),
 * won't be called for these helpers.
 *
 * @var array
 * @access public
 */
    public $coreHelpers = [
        // CakePHP
        'Cache',
        'Form',
        'Html',
        'Number',
        'Paginator',
        'Rss',
        'Text',
        'Time',
        'Xml',

        // Vamshop
        'Filemanager',
        'Image',
        'Layout',
        'Recaptcha',
    ];

/**
 * Javascript variables
 *
 * Shows vamshop.js file along with useful information like the applications's basePath, etc.
 *
 * Also merges Configure::read('Js') with the Vamshop js variable.
 * So you can set javascript info anywhere like Configure::write('Js.my_var', 'my value'),
 * and you can access it like 'Vamshop.my_var' in your javascript.
 *
 * @return string
 */
    public function js()
    {
        $vamshop = $this->_mergeThemeSettings();
        if ($this->request->param('locale')) {
            $vamshop['basePath'] = Router::url('/' . $this->request->param('locale') . '/');
        } else {
            $vamshop['basePath'] = Router::url('/');
        }
        $validKeys = [
            'plugin' => null,
            'controller' => null,
            'action' => null,
            'prefix' => null,
            'named' => null,
        ];
        $vamshop['params'] = array_intersect_key(
            array_merge($validKeys, $this->request->params),
            $validKeys
        );
        if (is_array(Configure::read('Js'))) {
            $vamshop = Hash::merge($vamshop, Configure::read('Js'));
        }
        return $this->Html->scriptBlock('var Vamshop = ' . json_encode($vamshop) . ';');
    }

/**
 * Merge helper and prefix specific settings
 *
 * @param array $vamshopSetting Vamshop JS settings
 * @return array Merged settings
 */
    protected function _mergeThemeSettings($vamshopSetting = [])
    {
        $themeSettings = $this->Theme->settings();
        if (empty($themeSettings)) {
            return $vamshopSetting;
        }
        $validKeys = [
            'css' => null,
            'icons' => null,
            'iconDefaults' => null,
        ];
        $vamshopSetting['themeSettings'] = array_intersect_key(
            array_merge($validKeys, $themeSettings),
            $validKeys
        );

        if ($this->_View->helpers()->has('VamshopHtml')) {
            unset($validKeys['css']);
            $vamshopSetting['themeSettings'] = Hash::merge(
                $vamshopSetting['themeSettings'],
                array_intersect_key(
                    array_merge($validKeys, $this->_View->Html->config()),
                    $validKeys
                )
            );
        }
        return $vamshopSetting;
    }

/**
 * Status
 *
 * instead of 0/1, show tick/cross
 *
 * @param int $value or 1
 * @return string formatted img tag
 */
    public function status($value)
    {
        $icons = $this->Theme->settings('icons');
        if (empty($icons)) {
            $icons = ['check-mark' => 'ok', 'x-mark' => 'remove'];
        }
        if ($value == 1) {
            $icon = $icons['check-mark'];
            $class = 'green';
        } else {
            $icon = $icons['x-mark'];
            $class = 'red';
        }
        if (method_exists($this->Html, 'icon')) {
            return $this->Html->icon($icon, compact('class'));
        } else {
            if (empty($this->_View->Html)) {
                $this->_View->Helpers->load('Vamshop/Core.VamshopHtml');
            }
            return $this->_View->Html->icon($icon, compact('class'));
        }
    }

/**
 * Display value from $item array
 *
 * @param $item array of values
 * @param $model string model alias
 * @param $field string field name
 * @param $options array
 * @return string
 */
    public function displayField(Entity $item, $model, $field, $options = [])
    {
        extract(array_intersect_key($options, [
            'type' => null,
            'url' => [],
            'options' => [],
        ]));
        switch ($type) {
            case 'boolean':
                $out = $this->status($item->{$field});
                break;
            default:
                $out = h((!isset($item->{$model})) ? $item->{$field} : $item->{$model}->{$field});
                break;
        }

        if (!empty($url)) {
            if (isset($url['pass'])) {
                $passVars = is_string($url['pass']) ? [$url['pass']] : $url['pass'];
                foreach ($passVars as $passField) {
                    $url[] = $item->get($passField);
                }
                unset($url['pass']);
            }

            if (isset($url['named'])) {
                foreach ((array)$url['named'] as $namedField => $namedRoute) {
                    if (is_numeric($namedField)) {
                        $namedField = $namedRoute;
                    }
                    $url[$namedRoute] = $item->get($namedField);
                }
                unset($url['named']);
            }

            try {
                $out = $this->Html->link($out, $url, $options);
            } catch (MissingRouteException $e) {
                $out = $out; //If the route doesn't exist then act gracefully
            }
        }
        return $out;
    }

/**
 * Show flash message
 *
 * @return string
 */
    public function sessionFlash()
    {
        $messages = $this->request->session()->read('Flash');
        $output = '';
        if (is_array($messages)) {
            foreach (array_keys($messages) as $key) {
                $output .= $this->Flash->render($key);
            }
        }
        return $output;
    }

/**
 * isLoggedIn
 *
 * if User is logged in
 *
 * @return boolean
 */
    public function isLoggedIn()
    {
        if ($this->request->session()->check('Auth.User.id')) {
            return true;
        } else {
            return false;
        }
    }

/**
 * Feed
 *
 * RSS feeds
 *
 * @param bool $returnUrl true, only the URL will be returned
 * @return string
 */
    public function feed($returnUrl = false)
    {
        if (Configure::read('Site.feed_url')) {
            $url = Configure::read('Site.feed_url');
        } else {
            /*$url = Router::url(array(
				'controller' => 'nodes',
				'action' => 'index',
				'type' => 'blog',
				'ext' => 'rss',
			));*/
            $url = '/promoted.rss';
        }

        if ($returnUrl) {
            $output = $url;
        } else {
            $url = Router::url($url);
            $output = '<link href="' . $url . '" type="application/rss+xml" rel="alternate" title="RSS 2.0" />';
            return $output;
        }

        return $output;
    }

/**
 * Get Role ID
 *
 * @return integer
 */
    public function getRoleId()
    {
        if ($this->isLoggedIn()) {
            $roleId = $this->request->session()->read('Auth.User.role_id');
        } else {
            // Public
            $roleId = 3;
        }
        return $roleId;
    }

/**
 * Filter content
 *
 * Replaces bbcode-like element tags
 *
 * @param string $content content
 * @return string
 */
    public function filter($content, $options = [])
    {
        Vamshop::dispatchEvent('Helper.Layout.beforeFilter', $this->_View, [
            'content' => &$content,
            'options' => $options,
        ]);
        $content = $this->filterElements($content, $options);
        Vamshop::dispatchEvent('Helper.Layout.afterFilter', $this->_View, [
            'content' => &$content,
            'options' => $options,
        ]);
        return $content;
    }

/**
 * Filter content for elements
 *
 * Original post by Stefan Zollinger: http://bakery.cakephp.org/articles/view/element-helper
 * [element:element_name] or [e:element_name]
 *
 * @param string $content
 * @return string
 */
    public function filterElements($content, $options = [])
    {
        preg_match_all('/\[(element|e|cell|c):([A-Za-z0-9_\-\/]*)(.*?)\]/i', $content, $tagMatches);
        $validOptions = ['plugin', 'cache', 'callbacks'];
        for ($i = 0, $ii = count($tagMatches[1]); $i < $ii; $i++) {
            $regex = '/([\w-]+)=[\'"]?((?:.(?![\'"]?\s+(?:\S+)=|[>\'"]))*.)[\'"]?/i';
            preg_match_all($regex, $tagMatches[3][$i], $attributes);
            $element = $tagMatches[2][$i];
            $data = $options = [];
            for ($j = 0, $jj = count($attributes[0]); $j < $jj; $j++) {
                if (in_array($attributes[1][$j], $validOptions)) {
                    $options = Hash::merge($options, [$attributes[1][$j] => $attributes[2][$j]]);
                } else {
                    $data[$attributes[1][$j]] = $attributes[2][$j];
                }
            }
            if (!empty($this->_View->viewVars['block'])) {
                $data['block'] = $this->_View->viewVars['block'];
            }
            if (!empty($options['plugin'])) {
                $element = $options['plugin'] . '.' . $element;
                unset($options['plugin']);
            }
            if ($tagMatches[1][$i] === 'cell' || $tagMatches[1][$i] === 'c') {
                $element = $this->_View->cell($element, $data, $options);
            } else {
                $element = $this->_View->element($element, $data, $options);
            }
            $content = str_replace($tagMatches[0][$i], $element, $content);
        }
        return $content;
    }

/**
 * Hook
 *
 * Used for calling hook methods from other HookHelpers
 *
 * @param string $methodName
 * @return string
 */
    public function hook($methodName)
    {
        $output = '';
        foreach ($this->_View->helpers as $helper => $settings) {
            if (!is_string($helper) || in_array($helper, $this->coreHelpers)) {
                continue;
            }
            list(, $helper) = pluginSplit($helper);
            if (isset($this->_View->{$helper}) && method_exists($this->_View->{$helper}, $methodName)) {
                $output .= $this->_View->{$helper}->$methodName();
            }
        }
        return $output;
    }

/**
 * Gets a value of view variables based on path
 *
 * @param string $name Variable name to retrieve from View::viewVars
 * @param string $path Extraction path following the Hash path syntax
 * @return array
 */
    public function valueOf($name, $path, $options = [])
    {
        if (!isset($this->_View->viewVars[$name])) {
            $this->log(sprintf('Invalid viewVars "%s"', $name));
            return [];
        }
        $result = Hash::extract($this->_View->viewVars[$name], $path);
        $result = isset($result[0]) ? $result[0] : $result;
        return $result;
    }

/**
 * Compute default options for snippet()
 *
 * @param string $type Type
 * @return array Array of options
 */
    private function __snippetDefaults($type)
    {
        $varName = strtolower(Inflector::pluralize($type)) . '_for_layout';
        $modelAlias = Inflector::classify($type);
        $checkField = 'alias';
        $valueField = 'body';
        $filter = true;
        $format = '{s}.{n}.%s[%s=%s].%s';
        switch ($type) {
            case 'type':
                $valueField = 'description';
                $format = '{s}.%s[%s=%s].%s';
                break;
            case 'vocabulary':
                $valueField = 'title';
                $format = '{s}.%s[%s=%s].%s';
                break;
            case 'menu':
                $valueField = 'title';
                $format = '{s}.%s[%s=%s].%s';
                break;
            case 'node':
                $checkField = 'slug';
                break;
        }
        return compact('checkField', 'filter', 'format', 'modelAlias', 'valueField', 'varName');
    }

/**
 * Simple method to retrieve value from view variables using Hash path format
 *
 * Example:
 *
 *   // display the 'about' block
 *   echo $this->Layout->snippet('about');
 *   // display the 'hello world' node
 *   echo $this->Layout->snippet('hello-world', 'node');
 *
 * You can customize the return value by supplying a custom path:
 *   // display the 'main' menu array
 *   echo $this->Layout->snippet('main', 'menu', array(
 *       'format' => '{s}.%s[%s=%s].%s',
 *   ));
 *   // display the 'main' menu description field
 *   echo $this->Layout->snippet('main', 'menu', array(
 *       'valueField' => 'description',
 *       'format' => '{s}.%s[%s=%s].%s',
 *   ));
 *
 * Options:
 * - checkField Field name that will be checked against $name
 * - filter Filter view data. Defaults to true
 * - format Hash path format
 * - modelAlias Model alias
 * - valueField Field name that will be returned if data is found
 * - varName Variable name as it is stored in viewVars
 *
 * @param string $name Identifier
 * @param string $type String of `block`, `nodes`, `node`
 * @param array $options Options array
 * @return string
 */
    public function snippet($name, $type = 'block', $options = [])
    {
        $options = array_merge($this->__snippetDefaults($type), $options);
        extract($options);
        $path = sprintf($format, $modelAlias, $checkField, $name, $valueField);
        $result = $this->valueOf($options['varName'], $path);
        if ($result) {
            if ($options['filter'] === true && is_string($result)) {
                return $this->filter($result, $options);
            } else {
                return $result;
            }
        } else {
            return null;
        }
    }
}
