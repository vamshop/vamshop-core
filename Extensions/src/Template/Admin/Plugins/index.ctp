<?php

$this->extend('Vamshop/Core./Common/admin_index');

$this->assign('title', __d('vamshop', 'Plugins'));

$this->Breadcrumbs->add(__d('vamshop', 'Extensions'), $this->request->getUri()->getPath())
    ->add(__d('vamshop', 'Plugins'), $this->request->getUri()->getPath());

$this->start('action-buttons');
echo $this->Vamshop->adminAction(__d('vamshop', 'Upload'), ['action' => 'add'], ['class' => 'btn btn-success']);
$this->end() ?>

<table class="table table-striped">
    <?php
    $tableHeaders = $this->Html->tableHeaders([
        '',
        __d('vamshop', 'Alias'),
        __d('vamshop', 'Name'),
        __d('vamshop', 'Description'),
        __d('vamshop', 'Active'),
        __d('vamshop', 'Actions'),
    ]);
    ?>
    <thead>
        <?= $tableHeaders ?>
    </thead>

    <?php
    $rows = [];
    foreach ($plugins as $pluginAlias => $pluginData):
        $toggleText = $pluginData['active'] ? __d('vamshop', 'Deactivate') : __d('vamshop', 'Activate');
        $statusIcon = $this->Html->status($pluginData['active']);

        $actions = [];
        $queryString = ['name' => $pluginAlias];
        if (!in_array($pluginAlias, $bundledPlugins) && !in_array($pluginAlias, $corePlugins)):
            $icon = $pluginData['active'] ? $this->Theme->getIcon('power-off') : $this->Theme->getIcon('power-on');
            $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'toggle', '?' => $queryString],
                ['icon' => $icon, 'tooltip' => $toggleText, 'method' => 'post']);
            $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'delete', '?' => $queryString],
                ['icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('vamshop', 'Delete')],
                __d('vamshop', 'Are you sure?'));
        endif;

        if ($pluginData['active'] &&
            !in_array($pluginAlias, $bundledPlugins) &&
            !in_array($pluginAlias, $corePlugins)
        ) {
            $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'moveup', '?' => $queryString],
                ['icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('vamshop', 'Move up'), 'method' => 'post'],
                __d('vamshop', 'Are you sure?'));

            $actions[] = $this->Vamshop->adminRowAction('', ['action' => 'movedown', '?' => $queryString], [
                    'icon' => $this->Theme->getIcon('move-down'),
                    'tooltip' => __d('vamshop', 'Move down'),
                    'method' => 'post',
                ], __d('vamshop', 'Are you sure?'));
        }

        if ($pluginData['needMigration']) {
            $actions[] = $this->Vamshop->adminRowAction(__d('vamshop', 'Migrate'), [
                'action' => 'migrate',
                '?' => $queryString,
            ], [], __d('vamshop', 'Are you sure?'));
        }

        $actions = $this->Html->div('item-actions', implode(' ', $actions));

        $rows[] = [
            '',
            $pluginAlias,
            $pluginData['name'],
            !empty($pluginData['description']) ? $pluginData['description'] : '',
            $statusIcon,
            $actions,
        ];
    endforeach;

    echo $this->Html->tableCells($rows);
    ?>
</table>
