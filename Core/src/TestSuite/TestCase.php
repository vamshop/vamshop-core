<?php

namespace Vamshop\Core\TestSuite;

use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Network\Request;
use Cake\ORM\Query;
use Cake\TestSuite\TestCase as CakeTestCase;
use Vamshop\Core\Plugin;
use Vamshop\Core\Event\EventManager;
use Vamshop\Core\TestSuite\Constraint\QueryCount;
use PHPUnit_Util_InvalidArgumentHelper;

/**
 * VamshopTestCase class
 *
 * @category TestSuite
 * @package  Vamshop
 * @version  1.4
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @author   Rachman Chavik <rchavik@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class TestCase extends CakeTestCase
{
    protected $previousPlugins = [];

    public static function setUpBeforeClass()
    {
        Configure::write('Config.language', 'eng');
    }

    public static function tearDownAfterClass()
    {
        Configure::write('Config.language', Configure::read('Site.locale'));
    }

/**
 * setUp
 *
 * @return void
 */
    public function setUp()
    {
        parent::setUp();

        EventManager::instance(new EventManager);
        Configure::write('EventHandlers', []);

        Plugin::unload('Vamshop/Install');
        Plugin::load('Vamshop/Example', ['autoload' => true, 'path' => '../Example/']);
        Configure::write('Acl.database', 'test');

        $this->previousPlugins = Plugin::loaded();
    }

    public function tearDown()
    {
        parent::tearDown();

        // Unload all plugins that were loaded while running tests
        Plugin::unload(array_diff(Plugin::loaded(), $this->previousPlugins));
    }

    public function assertQueryCount($count, Query $query, $message = '')
    {
        if (!is_int($count)) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(1, 'integer');
        }

        $constraint = new QueryCount($count);

        static::assertThat($query, $constraint, $message);
    }

/**
 * Helper method to create an test API request (with the appropriate detector)
 */
    protected function _apiRequest($params)
    {
        $request = new Request();
        $request->addParams($params);
        $request->addDetector('api', [
            'callback' => ['Vamshop\\Core\\Router', 'isApiRequest'],
        ]);
        return $request;
    }
}
