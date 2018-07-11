<?php
$this->assign('title', __d('vamshop', 'Database'));

$this->start('before');
echo $this->Form->create($context, [
    'align' => ['left' => 4, 'middle' => 8, 'right' => 0],
]);
$this->end();
?>
<?php if ($currentConfiguration['exists']): ?>
    <div class="alert alert-warning">
        <strong><?= __d('vamshop', 'Warning') ?>:</strong>
        <?= __d('vamshop', 'A database configuration already exists.') ?>
        <?php
        if ($currentConfiguration['valid']):
            $valid = __d('vamshop', 'Valid');
            $class = 'text-success';
        else:
            $valid = __d('vamshop', 'Invalid');
            $class = 'text-error';
        endif;
        echo __d('vamshop', 'The configuration is %s.', $this->Html->tag('span', $valid, compact('class')));
        ?>
        <?php if ($currentConfiguration['valid']): ?>
            <?php
            echo $this->Html->link(__d('vamshop', 'Reuse this configuration and proceed'), ['action' => 'data']);
            ?>
            <?= __d('vamshop', 'or complete the form below to replace it.'); ?>
        <?php else: ?>
            <?= __d('vamshop', 'This configuration will be replaced.') ?>
        <?php endif ?>
    </div>
<?php endif ?>

<?php
echo $this->Form->input('driver', [
    'placeholder' => __d('vamshop', 'Database'),
    'label' => __d('vamshop', 'Database'),
    'empty' => false,
    'options' => [
        Cake\Database\Driver\Mysql::class => 'MySQL',
        Cake\Database\Driver\Sqlite::class => 'SQLite',
        Cake\Database\Driver\Postgres::class => 'PostgreSQL',
        Cake\Database\Driver\Sqlserver::class => 'Microsoft SQL Server',
    ],
]);
echo $this->Form->input('host', [
    'placeholder' => __d('vamshop', 'Host'),
    'tooltip' => __d('vamshop', 'Database hostname or IP Address'),
    'prepend' => $this->Html->icon('home'),
    'label' => __d('vamshop', 'Host'),
]);
echo $this->Form->input('username', [
    'placeholder' => __d('vamshop', 'Login'),
    'tooltip' => __d('vamshop', 'Database login/username'),
    'prepend' => $this->Html->icon('user'),
    'label' => __d('vamshop', 'Login'),
]);
echo $this->Form->input('password', [
    'placeholder' => __d('vamshop', 'Password'),
    'tooltip' => __d('vamshop', 'Database password'),
    'prepend' => $this->Html->icon('key'),
    'label' => __d('vamshop', 'Password'),
]);
echo $this->Form->input('database', [
    'placeholder' => __d('vamshop', 'Database name'),
    'tooltip' => __d('vamshop', 'Database name'),
    'prepend' => $this->Html->icon('briefcase'),
    'label' => __d('vamshop', 'Database name'),
]);
echo $this->Form->input('port', [
    'placeholder' => __d('vamshop', 'Port'),
    'tooltip' => __d('vamshop', 'Database port (leave blank if unknown)'),
    'prepend' => $this->Html->icon('asterisk'),
    'label' => __d('vamshop', 'Port'),
]);
?>
<?php
$this->assign('buttons', $this->Form->button(__d('vamshop','Next step'), ['class' => 'success']));

$this->assign('after', $this->Form->end());
