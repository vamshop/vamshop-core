<?php
$this->assign('title', __d('vamshop', 'Welcome'));
$check = true;

// tmp is writable
if (is_writable(TMP)) {
    echo '<p><span class="badge badge-success">' . __d('vamshop', 'Your tmp directory is writable.') . '</span></p>';
} else {
    $check = false;
    echo '<p><span class="badge badge-danger">' . __d('vamshop', 'Your tmp directory is NOT writable.') . '</span></p>';
}

// config is writable
if (is_writable(ROOT . DS . 'config')) {
    echo '<p><span class="badge badge-success">' . __d('vamshop', 'Your config directory is writable.') . '</span></p>';
} else {
    $check = false;
    echo '<p><span class="badge badge-danger">' . __d('vamshop', 'Your config directory is NOT writable.') . '</danger></p>';
}

$versions = \Vamshop\Install\InstallManager::versionCheck();
if ($versions['php']) {
    echo '<p><span class="badge badge-success">' .
        sprintf(__d('vamshop', 'PHP version %s >= %s'), phpversion(), \Vamshop\Install\InstallManager::PHP_VERSION) .
        '</span></p>';
} else {
    $check = false;
    echo '<p><span class="badge badge-danger">' .
        sprintf(__d('vamshop', 'PHP version %s < %s'), phpversion(), \Vamshop\Install\InstallManager::PHP_VERSION) .
        '</span></p>';
}

// cakephp version
if ($versions['cake']) {
    echo '<p><span class="badge badge-success">' .
        __d('vamshop', 'CakePhp version %s >= %s', \Cake\Core\Configure::version(),
            \Vamshop\Install\InstallManager::CAKE_VERSION) .
        '</span></p>';
} else {
    $check = false;
    echo '<p><span class="badge badge-danger">' .
        __d('vamshop', 'CakePHP version %s < %s', \Cake\Core\Configure::version(),
            \Vamshop\Install\InstallManager::CAKE_VERSION) .
        '</span></p>';
}

if ($check) {
    $out = $this->Html->link(__d('vamshop', 'Start installation'), [
        'action' => 'database',
    ], [
        'button' => 'success',
        'tooltip' => [
            'data-title' => __d('vamshop', 'Click here to begin installation'),
            'data-placement' => 'left',
        ],
    ]);
} else {
    $out = '<p>' . __d('vamshop', 'Installation cannot continue as minimum requirements are not met.') . '</p>';
}
$this->assign('buttons', $this->Html->div('form-actions', $out));
