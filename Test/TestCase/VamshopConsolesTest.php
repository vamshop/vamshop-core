<?php
namespace Vamshop\Test\TestCase;

use Vamshop\TestSuite\VamshopTestCase;

class VamshopConsolesTests extends PHPUnit_Framework_TestSuite
{

    public static function suite()
    {
        $suite = new CakeTestSuite('Vamshop commands tests');
        $path = APP . 'Vendor' . DS . 'vamshop' . DS . 'vamshop' . DS . 'Vamshop' . DS . 'Test' . DS . 'Case' . DS . 'Console' . DS . 'Command' . DS;
        $suite->addTestDirectory($path);
        return $suite;
    }
}
