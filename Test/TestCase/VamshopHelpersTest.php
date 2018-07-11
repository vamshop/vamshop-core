<?php
namespace Vamshop\Test\TestCase;

use Vamshop\TestSuite\VamshopTestCase;

class VamshopHelpersTest extends PHPUnit_Framework_TestSuite
{

    public static function suite()
    {
        $suite = new CakeTestSuite('Vamshop helper tests');
        $path = APP . 'Vendor' . DS . 'croogo' . DS . 'croogo' . DS . 'Vamshop' . DS . 'Test' . DS . 'Case' . DS . 'View' . DS . 'Helper' . DS;
        $suite->addTestDirectory($path);
        return $suite;
    }
}
