<?php
namespace Vamshop\Contacts\Test\TestCase;

use Vamshop\TestSuite\VamshopTestCase;

class AllContactsTestsTest extends PHPUnit_Framework_TestSuite
{

/**
 * suite
 *
 * @return CakeTestSuite
 */
    public static function suite()
    {
        $suite = new CakeTestSuite('All Contacts tests');
        $suite->addTestDirectoryRecursive(Plugin::path('Contacts') . 'Test' . DS . 'Case' . DS);
        return $suite;
    }
}
