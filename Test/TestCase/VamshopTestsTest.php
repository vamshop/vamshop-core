<?php
namespace Vamshop\Test\TestCase;

use Vamshop\TestSuite\VamshopTestCase;

class VamshopTestsTest extends PHPUnit_Framework_TestSuite
{

/**
 * suite
 *
 * @return CakeTestSuite
 */
    public static function suite()
    {
        $suite = new CakeTestSuite('Vamshop Tests');
        $path = TESTS . 'Case' . DS;
        $suite->addTestFile($path . 'VamshopModelsTest.php');
        $suite->addTestFile($path . 'VamshopBehaviorsTest.php');
        $suite->addTestFile($path . 'VamshopHelpersTest.php');
        $suite->addTestFile($path . 'VamshopControllersTest.php');
        $suite->addTestFile($path . 'VamshopComponentsTest.php');
        $suite->addTestFile($path . 'VamshopEventsTest.php');
        $suite->addTestFile($path . 'VamshopLibsTest.php');
        $suite->addTestFile($path . 'VamshopConsolesTest.php');
        $suite->addTestFile($path . 'VamshopCorePluginsTest.php');
        return $suite;
    }
}
