<?php

namespace Vamshop\Extensions\Controller\Admin;

use Cake\Core\Configure;
use Vamshop\Extensions\VamshopTheme;
use Vamshop\Extensions\Exception\MissingThemeException;
use Vamshop\Extensions\ExtensionsInstaller;

/**
 * Extensions Themes Controller
 *
 * @category Controller
 * @package  Vamshop.Extensions.Controller
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class ThemesController extends AppController
{

    /**
     * VamshopTheme instance
     * @var \Vamshop\Extensions\VamshopTheme
     */
    protected $_VamshopTheme = false;

    /**
     * Constructor
     */
    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->_VamshopTheme = new VamshopTheme();
    }

    /**
     * Admin index
     *
     * @return void
     */
    public function index()
    {
        $this->set('title_for_layout', __d('vamshop', 'Themes'));

        $themes = $this->_VamshopTheme->getThemes();
        $themesData = [];
        foreach ($themes as $theme => $path) {
            $themesData[$theme] = $this->_VamshopTheme->getData($theme, $path);
        }

        $activeTheme = Configure::read('Site.theme');
        if (empty($activeTheme)) {
            $activeTheme = 'Vamshop/Core';
        }
        $currentTheme = $this->_VamshopTheme->getData($activeTheme);
        $this->set(compact('themes', 'themesData', 'currentTheme'));
    }

    /**
     * Admin activate
     *
     * @param string $theme
     */
    public function activate($theme = null)
    {
        try {
        		$theme = base64_decode(urldecode($theme));
            $this->_VamshopTheme->activate($theme);

            $this->Flash->success(__d('vamshop', 'Theme activated.'));
        } catch (MissingThemeException $exception) {
            $this->Flash->error(__d('vamshop', 'Theme activation failed: %s', $exception->getMessage()));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Admin add
     *
     * @return void
     */
    public function add()
    {
        $this->set('title_for_layout', __d('vamshop', 'Upload a new theme'));

        if (!empty($this->request->data)) {
            $file = $this->request->data['Theme']['file'];
            unset($this->request->data['Theme']['file']);

            $Installer = new ExtensionsInstaller;
            try {
                $Installer->extractTheme($file['tmp_name']);
                $this->Flash->success(__d('vamshop', 'Theme uploaded successfully.'));
            } catch (CakeException $e) {
                $this->Flash->error($e->getMessage());
            }

            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Admin editor
     *
     * @return void
     */
    public function editor()
    {
        $this->set('title_for_layout', __d('vamshop', 'Theme Editor'));
    }

    /**
     * Admin save
     *
     * @return void
     */
    public function save()
    {
    }

    /**
     * Admin delete
     *
     * @param string $alias
     * @return void
     */
    public function delete($alias = null)
    {
        if ($alias == null) {
            $this->Flash->error(__d('vamshop', 'Invalid Theme.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($alias == 'Vamshop/Core') {
            $this->Flash->error(__d('vamshop', 'Default theme cannot be deleted.'));

            return $this->redirect(['action' => 'index']);
        } elseif ($alias == Configure::read('Site.theme')) {
            $this->Flash->error(__d('vamshop', 'You cannot delete a theme that is currently active.'));

            return $this->redirect(['action' => 'index']);
        }

        $result = $this->_VamshopTheme->delete($alias);

        if ($result === true) {
            $this->Flash->success(__d('vamshop', 'Theme deleted successfully.'));
        } elseif (!empty($result[0])) {
            $this->Flash->error($result[0]);
        } else {
            $this->Flash->error(__d('vamshop', 'An error occurred.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
