<?php

namespace Vamshop\Extensions\Test\TestCase;

use Vamshop\Lib\TestSuite\VamshopTestCase;
use Extensions\Lib\VamshopComposer;

/**
 * Vamshop Composer Test
 *
 * @category Test
 * @package  Vamshop
 * @version  1.4
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class VamshopComposerTest extends VamshopTestCase
{

/**
 * setUp
 *
 * @return void
 */
    public function setUp()
    {
        parent::setUp();
        App::build([
            'Plugin' => [Plugin::path('Extensions') . 'Test' . DS . 'test_app' . DS . 'Plugin' . DS],
            'View' => [Plugin::path('Extensions') . 'Test' . DS . 'test_app' . DS . 'View' . DS],
        ], App::PREPEND);
        $this->testPlugin = Plugin::path('Extensions') . 'Test' . DS . 'test_files' . DS . 'example_plugin.zip';
        $this->testTheme = Plugin::path('Extensions') . 'Test' . DS . 'test_files' . DS . 'example_theme.zip';
        $this->VamshopComposer = new VamshopComposer();
        $this->VamshopComposer->appPath = Plugin::path('Extensions') . 'Test' . DS . 'test_app' . DS;
    }

/**
 * tearDown
 *
 * @return void
 */
    public function tearDown()
    {
        parent::tearDown();
        $path = Plugin::path('Extensions') . 'Test' . DS . 'test_app' . DS . 'Plugin' . DS . 'Example';
        $Folder = new Folder($path);
        $Folder->delete();
        $path = Plugin::path('Extensions') . 'Test' . DS . 'test_app' . DS . 'View' . DS . 'Themed' . DS . 'Minimal';
        $Folder = new Folder($path);
        $Folder->delete();
        $File = new File(Plugin::path('Extensions') . 'Test' . DS . 'test_app' . DS . 'composer.json');
        $File->delete();
    }

/**
 * testGetComposer
 *
 * @return void
 */
    public function testGetComposer()
    {
        $VamshopComposer = $this->getMock('VamshopComposer', ['_shellExec']);
        $VamshopComposer->appPath = $this->VamshopComposer->appPath;
        $VamshopComposer->expects($this->any())
            ->method('_shellExec')
            ->with(
                $this->equalTo('curl -s http://getcomposer.org/installer | php -- --install-dir=' . $VamshopComposer->appPath)
            )
            ->will($this->returnValue(true));
        $VamshopComposer->getComposer();
    }

/**
 * testRunComposer
 *
 * @return void
 */
    public function testRunComposer()
    {
        $VamshopComposer = $this->getMock('VamshopComposer', ['_shellExec']);
        $VamshopComposer->appPath = $this->VamshopComposer->appPath;
        $VamshopComposer->getComposer();
        $VamshopComposer->expects($this->once())
            ->method('_shellExec')
            ->with(
                $this->equalTo('php ' . $VamshopComposer->composerPath . ' install')
            )
            ->will($this->returnValue(true));
        $VamshopComposer->runComposer();
    }

/**
 * testSetConfig
 *
 * @return void
 */
    public function testSetConfig()
    {
        $result = $this->VamshopComposer->setConfig([
            'shama/ftp' => '*',
        ]);
        $this->assertTrue($result);
        $File = new File($this->VamshopComposer->appPath . 'composer.json');
        $result = $File->read();
        $File->close();
        $expected = <<<END
{
\s+"minimum-stability": "dev",
\s+"config": {
\s+"vendor-dir": "Vendor",
\s+"bin-dir": "Vendor/bin"
\s+},
\s+"require": {
\s+"composer/installers": "\*",
\s+"shama/ftp": "\*"
\s+}
}
END;
        $this->assertRegExp($expected, trim($result));
    }
}
