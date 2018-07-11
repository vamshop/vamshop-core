<?php
namespace Vamshop\Core\Test\TestCase\View\Helper;

use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Network\Response;
use Cake\Network\Request;
use Cake\Network\Session;
use Cake\View\View;
use Vamshop\Core\Nav;
use Vamshop\Core\TestSuite\VamshopTestCase;
use Vamshop\Core\View\Helper\VamshopHelper;
use Vamshop\Extensions\VamshopTheme;

class VamshopHelperTest extends VamshopTestCase
{

    public $fixtures = [
//		'plugin.croogo\users.aco',
//		'plugin.croogo\users.aro',
//		'plugin.croogo\users.aros_aco',
//		'plugin.croogo\settings.setting',
//		'plugin.croogo\users.role',
//		'plugin.taxonomy.type',
    ];

/**
 * setUp
 */
    public function setUp()
    {
        parent::setUp();

        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $this->ComponentRegistry = new ComponentRegistry();

        $request = new Request('nodes/index');
        $request->params = [
            'controller' => 'nodes',
            'action' => 'index',
            'named' => [],
        ];
        $view = new View($request, new Response());
        $croogoTheme = new VamshopTheme();
        $data = $croogoTheme->getData();
        $settings = $data['settings'];
        $view->set('themeSettings', $settings);

        $this->Vamshop = new VamshopHelper($view);
        $aclHelper = Configure::read('Site.acl_plugin') . 'Helper';
        $this->Vamshop->Acl = $this->getMock(
            $aclHelper,
            ['linkIsAllowedByRoleId']
            //			array($view)
        );
        $this->Vamshop->Acl
            ->expects($this->any())
            ->method('linkIsAllowedByRoleId')
            ->will($this->returnValue(true));
        $this->menus = Nav::items();

        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        Nav::clear();
    }

/**
 * tearDown
 */
    public function tearDown()
    {
//		ClassRegistry::flush();
        Nav::items('sidebar', $this->menus);
        unset($this->Vamshop);
    }

/**
 * testAdminMenus
 */
    public function testAdminMenus()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        Session::write('Auth.User', ['id' => 1, 'role_id' => 1]);
        Nav::add('contents', [
            'title' => 'Contents',
            'url' => '#',
            ]);
        $items = Nav::items();
        $expected = '<ul class="nav nav-stacked"><li><a href="#" class="menu-contents sidebar-item"><i class="icon-white icon-large"></i><span>Contents</span></a></li></ul>';
        $result = $this->Vamshop->adminMenus(Nav::items());
        $this->assertEquals($expected, $result);
    }

/**
 * testAdminRowActions
 */
    public function testAdminRowActions()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $this->Vamshop->request->params = [
            'controller' => 'test',
            'action' => 'action',
        ];
        Configure::write('Admin.rowActions.Test/action', [
            'Title' => 'plugin:example/controller:example/action:index/:id',
        ]);
        $result = $this->Vamshop->adminRowActions(1);
        $expected = [
            'a' => [
                'href' => '/example/example/index/1',
                'class',
            ],
            'Title',
            '/a',
        ];
        $this->assertHtml($result, $expected);

        // test row actions with options
        Configure::write('Admin.rowActions.Test/action', [
            'Title' => [
                'plugin:example/controller:example/action:index/:id' => [
                    'options' => [
                        'icon' => 'key',
                        'title' => false,
                    ],
                ],
            ]
        ]);
        $result = $this->Vamshop->adminRowActions(1);
        $expected = [
            'a' => [
                'href' => '/example/example/index/1',
                'class',
            ],
            'i' => [
                'class',
            ],
            '/i',
            'Title',
            '/a',
        ];
        $this->assertHtml($result, $expected);

        // test row actions with no title + icon
        Configure::write('Admin.rowActions.Test/action', [
            'Title' => [
                'plugin:example/controller:example/action:edit/:id' => [
                    'title' => false,
                    'options' => [
                        'icon' => 'edit',
                        'title' => false,
                    ],
                ],
            ]
        ]);
        $result = $this->Vamshop->adminRowActions(1);
        $expected = [
            'a' => [
                'href' => '/example/example/edit/1',
                'class' => 'edit',
            ],
            'i' => [
                'class' => 'icon-edit icon-large',
            ],
            '/i',
            '/a',
        ];
        $this->assertHtml($result, $expected);
    }

/**
 * testAdminTabs
 */
    public function testAdminTabs()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $this->Vamshop->request->params = [
            'controller' => 'test',
            'action' => 'action',
        ];
        Configure::write('Admin.tabs.Test/action', [
            'Title' => [
                'element' => 'blank',
                'options' => [],
            ],
        ]);
        $result = $this->Vamshop->adminTabs();
        $expected = '<li><a href="#test-title" data-toggle="tab">Title</a></li>';
        $this->assertEquals($expected, $result);

        $result = $this->Vamshop->adminTabs(true);
        $this->assertContains('test-title', $result);
    }

/**
 * testAdminTabsOptions
 */
    public function testAdminTabsOptions()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $this->Vamshop->request->params = [
            'controller' => 'test',
            'action' => 'action',
        ];
        $testData = 'hellow world';
        Configure::write('Admin.tabs.Test/action', [
            'Title' => [
                'element' => 'tab_options',
                'options' => [
                    'elementData' => [
                        'dataFromHookAdminTab' => $testData,
                    ],
                    'elementOptions' => [
                        'ignoreMissing' => true,
                    ],
                ],
            ],
        ]);
        $result = $this->Vamshop->adminTabs();
        $expected = '<li><a href="#test-title" data-toggle="tab">Title</a></li>';
        $this->assertEquals($expected, $result);

        $result = $this->Vamshop->adminTabs(true);
        $this->assertContains($testData, $result);
        $this->assertContains('test-title', $result);
    }

    public function testAdminBoxes()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $this->Vamshop->request->params = [
            'controller' => 'test',
            'action' => 'action',
        ];
        Configure::write('Admin.boxes.Test/action', [
            'Title' => [
                'element' => 'blank',
                'options' => [],
            ],
        ]);

        $result = $this->Vamshop->adminBoxes('Title');
        $this->assertContains("class='box'", $result);
    }

    public function testAdminBoxesAlreadyPrinted()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $this->Vamshop->params = [
            'controller' => 'test',
            'action' => 'action',
        ];
        Configure::write('Admin.tabs.Test/action', [
            'Title' => [
                'element' => 'blank',
                'options' => [],
            ],
        ]);

        $this->Vamshop->adminBoxes('Title');
        $result = $this->Vamshop->adminBoxes('Title');
        $this->assertEquals('', $result);
    }

    public function testAdminBoxesAll()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $this->Vamshop->request->params = [
            'controller' => 'test',
            'action' => 'action',
        ];
        Configure::write('Admin.boxes.Test/action', [
            'Title' => [
                'element' => 'blank',
                'options' => [],
            ],
            'Content' => [
                'element' => 'blank',
                'options' => [],
            ],
        ]);

        $result = $this->Vamshop->adminBoxes();
        $this->assertContains('Title', $result);
        $this->assertContains('Content', $result);
    }

    public function testSettingsInputCheckbox()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $setting['Setting']['input_type'] = 'checkbox';
        $setting['Setting']['value'] = 0;
        $setting['Setting']['description'] = 'A description';
        $result = $this->Vamshop->settingsInput($setting, 'MyLabel', 0);
        $this->assertContains('type="checkbox"', $result);
    }

    public function testSettingsInputCheckboxChecked()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $setting['Setting']['input_type'] = 'checkbox';
        $setting['Setting']['value'] = 1;
        $setting['Setting']['description'] = 'A description';
        $result = $this->Vamshop->settingsInput($setting, 'MyLabel', 0);
        $this->assertContains('type="checkbox"', $result);
        $this->assertContains('checked="checked"', $result);
    }

    public function testSettingsInputTextbox()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $setting['Setting']['input_type'] = '';
        $setting['Setting']['description'] = 'A description';
        $setting['Setting']['value'] = 'Yes';
        $result = $this->Vamshop->settingsInput($setting, 'MyLabel', 0);
        $this->assertContains('type="text"', $result);
    }

    public function testSettingsInputTextarea()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $setting['Setting']['input_type'] = 'textarea';
        $setting['Setting']['description'] = 'A description';
        $setting['Setting']['value'] = 'Yes';
        $result = $this->Vamshop->settingsInput($setting, 'MyLabel', 0);
        $this->assertContains('</textarea>', $result);
    }

/**
 * testAdminRowAction
 */
    public function testAdminRowAction()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $url = ['controller' => 'users', 'action' => 'edit', 1];
        $expected = [
            'a' => [
                'href' => '/users/edit/1',
                'class' => 'edit',
            ],
            'Edit',
            '/a',
        ];
        $result = $this->Vamshop->adminRowAction('Edit', $url);
        $this->assertHtml($result, $expected);

        $options = ['class' => 'test-class'];
        $message = 'Are you sure?';
        $onclick = "return confirm('" . $message . "');";
        if (version_compare(Configure::version(), '2.4.0', '>=')) {
            $onclick = sprintf(
                "if (confirm(&quot;%s&quot;)) { return true; } return false;",
                $message
            );
        }
        $expected = [
            'a' => [
                'href' => '/users/edit/1',
                'class' => 'test-class edit',
                'onclick' => $onclick,
            ],
            'Edit',
            '/a',
        ];
        $result = $this->Vamshop->adminRowAction('Edit', $url, $options, $message);
        $this->assertHtml($result, $expected);
    }

/**
 * testAdminRowActionEscapedConfirmMessage
 */
    public function testAdminRowActionEscapedConfirmMessage()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $url = ['action' => 'delete', 1];
        $options = [];
        $sure = 'Are you sure?';
        $expected = [
            'form' => [
                'action',
                'name',
                'id',
                'style',
                'method',
            ],
            'input' => [
                'type',
                'name',
                'value',
            ],
            '/form',
            'a' => [
                'href' => '#',
                'class' => 'delete',
                'onclick',
            ],
            'span' => [],
            'Del',
            '/span',
            '/a',
        ];
        $result = $this->Vamshop->adminRowAction('<span>Del</span>', $url, [], $sure);
        $this->assertHtml($result, $expected);
        $quot = '&quot;';
        $this->assertContains($quot . $sure . $quot, $result);
    }

/**
 * testAdminRowActionBulkDelete
 */
    public function testAdminRowActionBulkDelete()
    {
        $this->markTestIncomplete('This test needs to be ported to CakePHP 3.0');

        $url = '#Node1Id';
        $options = [
            'rowAction' => 'delete',
        ];
        $message = 'Delete this?';
        $expected = [
            'a' => [
                'href' => '#Node1Id',
                'data-row-action' => 'delete',
                'data-confirm-message',
            ],
            'Delete',
            '/a',
        ];
        $result = $this->Vamshop->adminRowAction('Delete', $url, $options, $message);
        $this->assertHtml($result, $expected);
    }
}
