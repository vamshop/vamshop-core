<?php

/**
 * Translations
 *
 * @package  Vamshop.Translate.Lib
 * @author   Rachman Chavik <rchavik@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
namespace Vamshop\Translate;

use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Utility\Inflector;
use Vamshop\Core\Vamshop;

class Translations
{

/**
 * Read configured Translate.models and hook the appropriate behaviors
 */
    public static function translateModels()
    {
        $path ='prefix:admin/plugin:Vamshop%2fTranslate/controller:Translate/action:index/?id=:id&model={{model}}';
        foreach (Configure::read('Translate.models') as $encoded => $config) {
            $model = base64_decode($encoded);
            Vamshop::hookBehavior($model, 'Vamshop/Translate.Translate', $config);
            $action = str_replace('.', '.Admin/', $model . '/index');
            $url = str_replace('{{model}}', urlencode($model), $path);
            Vamshop::hookAdminRowAction($action,
                __d('vamshop', 'Translate'),
                [
                $url => [
                    'title' => false,
                    'options' => [
                        'icon' => 'translate',
                        'data-title' => __d('vamshop', 'Translate'),
                    ],
                ]]
            );
        }
    }

}
