<?php
$this->assign('title', __d('vamshop', 'Successful'));
?>
<p class="success">
    <?= __d('vamshop', 'The user %s has been created with administrative rights.',
        sprintf('<strong>%s</strong>', $user['username']));
    ?>
</p>

<p>
    <?= __d('vamshop', 'Admin panel: %s',
        $this->Html->link(\Vamshop\Core\Router::url('/admin', true), \Vamshop\Core\Router::url('/admin', true))) ?>
</p>

<p>
    <?php
    echo __d('vamshop', 'You can start with %s or jump in and %s.',
        $this->Html->link(__d('vamshop', 'configuring your site'), [
            'plugin' => 'Vamshop/Settings',
            'prefix' => 'admin',
            'controller' => 'settings',
            'action' => 'prefix',
            'Site',
        ]), $this->Html->link(__d('vamshop', 'create a blog post'), [
            'plugin' => 'Vamshop/Nodes',
            'prefix' => 'admin',
            'controller' => 'nodes',
            'action' => 'add',
            'blog',
        ]));
    ?>
</p>

<blockquote>
    <h3><?= __d('vamshop', 'Resources') ?></h3>
    <ul class="bullet">
        <li><?= $this->Html->link('http://vamshop.com') ?></li>
        <li><?= $this->Html->link('http://wiki.vamshop.com/') ?></li>
        <li><?= $this->Html->link('http://github.com/vamshop/vamshop') ?></li>
        <li><?= $this->Html->link('Vamshop Google Group',
                'https://groups.google.com/forum/#!forum/vamshop') ?></li>
    </ul>
</blockquote>
