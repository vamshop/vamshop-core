<?php
namespace Vamshop\Test\TestCase;

use Vamshop\TestSuite\VamshopTestCase;

class VamshopComponentsTest extends PHPUnit_Framework_TestSuite
{

/**
 * suite
 */
    public static function suite()
    {
        $suite = new CakeTestSuite('Vamshop components tests');
        $path = APP . 'Vendor' . DS . 'vamshop' . DS . 'vamshop' . DS . 'Vamshop' . DS . 'Test' . DS . 'Case' . DS . 'Controller' . DS . 'Component' . DS;
        $suite->addTestDirectory($path);
        return $suite;
    }
}
