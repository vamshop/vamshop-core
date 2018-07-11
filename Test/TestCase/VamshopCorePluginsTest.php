<?php
namespace Vamshop\Test\TestCase;

use Vamshop\TestSuite\VamshopTestCase;

/**
 *  VamshopCorePluginsTest
 *
 */
class VamshopCorePluginsTest extends PHPUnit_Framework_TestSuite
{

    public static function suite()
    {
        $suite = new CakeTestSuite('Vamshop core plugins tests');
        $plugins = [
            'Acl',
            'Blocks',
            'Comments',
            'Contacts',
            'Vamshop',
            'Nodes',
            'Extensions',
            'FileManager',
            'Menus',
            'Meta',
            'Settings',
            'Taxonomy',
            'Ckeditor',
            'Translate',
            'Users',
        ];
        if ((integer)Configure::read('debug') > 0) {
            $plugins[] = 'Install';
        }
        foreach ($plugins as $plugin) {
            Plugin::load($plugin);
            $suite->addTestDirectoryRecursive(Plugin::path($plugin) . 'Test' . DS);
        }
        return $suite;
    }
}
