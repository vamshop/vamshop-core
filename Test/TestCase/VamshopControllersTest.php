<?php
namespace Vamshop\Test\TestCase;

use Vamshop\TestSuite\VamshopTestCase;

class VamshopControllerTest extends PHPUnit_Framework_TestSuite
{

    public static function suite()
    {
        $suite = new CakeTestSuite('Vamshop controller tests');
        $path = APP . 'Vendor' . DS . 'croogo' . DS . 'croogo' . DS . 'Vamshop' . DS . 'Test' . DS . 'Case' . DS . 'Controller' . DS;
        $suite->addTestDirectory($path);
        return $suite;
    }
}
