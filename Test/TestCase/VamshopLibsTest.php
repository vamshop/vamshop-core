<?php
namespace Vamshop\Test\TestCase;

use Vamshop\TestSuite\VamshopTestCase;

class VamshopLibsTest extends PHPUnit_Framework_TestSuite
{

    public static function suite()
    {
        $suite = new CakeTestSuite('Vamshop lib tests');
        $path = APP . 'Vendor' . DS . 'croogo' . DS . 'croogo' . DS . 'Vamshop' . DS . 'Test' . DS . 'Case' . DS . 'Lib' . DS;
        $suite->addTestDirectory($path);
        $suite->addTestDirectory($path . 'Configure');
        return $suite;
    }
}
