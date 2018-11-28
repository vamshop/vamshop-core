<?php

namespace Vamshop\Extensions\Test\TestCase;

use Vamshop\Core\TestSuite\VamshopTestCase;
use Vamshop\Extensions\VamshopTheme;

class VamshopThemeTest extends VamshopTestCase
{

/**
 * VamshopTheme class
 * @var VamshopTheme
 */
    public $VamshopTheme;

    public function setUp()
    {
        parent::setUp();
        $this->VamshopTheme = $this->getMock('VamshopTheme', null);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->VamshopTheme);
    }

/**
 * testDeleteEmptyTheme
 * @expectedException InvalidArgumentException
 */
    public function testDeleteEmptyTheme()
    {
        $this->VamshopTheme->delete(null);
    }

/**
 * testDeleteBogusTheme
 * @expectedException UnexpectedValueException
 */
    public function testDeleteBogusTheme()
    {
        $this->VamshopTheme->delete('Bogus');
    }

/**
 * testGetThemes
 */
    public function testGetThemes()
    {
        $themes = $this->VamshopTheme->getThemes();
        $this->assertTrue(array_key_exists('Mytheme', $themes));
    }

/**
 * testGetDataBogusTheme
 */
    public function testGetDataBogusTheme()
    {
        $data = $this->VamshopTheme->getData('BogusTheme');
        $this->assertSame([], $data);
    }

/**
 * testGetDataMixedManifest
 */
    public function testGetDataMixedManifest()
    {
        $data = $this->VamshopTheme->getData('MixedManifest');

        $keys = array_keys($data);
        sort($keys);

        $expected = ['name', 'regions', 'screenshot', 'settings', 'type', 'vendor'];
        $this->assertEquals($expected, $keys);

        $this->assertEquals('MixedManifest', $data['name']);
        $this->assertEquals('vamshop/mixed-manifest-theme', $data['vendor']);
    }
}
