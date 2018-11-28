<?php
namespace Vamshop\Test\TestCase;

use Vamshop\TestSuite\VamshopTestCase;

class VamshopModelsTest extends PHPUnit_Framework_TestSuite
{

    public static function suite()
    {
        $suite = new CakeTestSuite('Vamshop model tests');
        $path = APP . 'Vendor' . DS . 'vamshop' . DS . 'vamshop-core' . DS . 'Vamshop' . DS . 'Test' . DS . 'Case' . DS . 'Model' . DS;
        $suite->addTestDirectory($path);
        return $suite;
    }
}
