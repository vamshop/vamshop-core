<?php
namespace Vamshop\Test\TestCase;

use Vamshop\TestSuite\VamshopTestCase;

class VamshopEventsTest extends PHPUnit_Framework_TestSuite
{

    public static function suite()
    {
        $suite = new CakeTestSuite('Vamshop events tests');
        $path = APP . 'Vendor' . DS . 'vamshop' . DS . 'vamshop' . DS . 'Vamshop' . DS . 'Test' . DS . 'Case' . DS . 'Event' . DS;
        $suite->addTestDirectory($path);
        return $suite;
    }
}
