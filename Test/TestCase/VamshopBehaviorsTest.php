<?php
namespace Vamshop\Test\TestCase;

use Vamshop\TestSuite\VamshopTestCase;

class VamshopBehaviorsTest extends PHPUnit_Framework_TestSuite
{

    public static function suite()
    {
        $suite = new CakeTestSuite('Vamshop behavior tests');
        $path = APP . 'Vendor' . DS . 'croogo' . DS . 'croogo' . DS . 'Vamshop' . DS . 'Test' . DS . 'Case' . DS . 'Model' . DS . 'Behavior' . DS;
        $suite->addTestDirectory($path);
        return $suite;
    }
}
