<?php

$this->extend('Vamshop/Core./Common/admin_index');

$this->Vamshop->adminScript('Vamshop/Acl.acl_permissions');

$this->Breadcrumbs->add(__d('vamshop', 'Users'),
        ['plugin' => 'Vamshop/Users', 'controller' => 'Users', 'action' => 'index'])
    ->add(__d('vamshop', 'Permissions'), $this->request->getUri()->getPath());

$this->append('action-buttons');
$toolsButton = $this->Html->link(__d('vamshop', 'Tools'), '#', [
        'button' => 'secondary',
        'class' => 'dropdown-toggle',
        'data-toggle' => 'dropdown',
        'escape' => false,
    ]);

$generateUrl = [
    'plugin' => 'Vamshop/Acl',
    'controller' => 'Actions',
    'action' => 'generate',
    'permissions' => 1,
];
$out = $this->Vamshop->adminAction(__d('vamshop', 'Generate'), $generateUrl, [
        'button' => false,
        'list' => true,
        'method' => 'post',
        'class' => 'dropdown-item',
        'tooltip' => [
            'data-title' => __d('vamshop', 'Create new actions (no removal)'),
            'data-placement' => 'left',
        ],
    ]);
$out .= $this->Vamshop->adminAction(__d('vamshop', 'Synchronize'), $generateUrl + ['sync' => 1], [
        'button' => false,
        'list' => true,
        'method' => 'post',
        'class' => 'dropdown-item',
        'tooltip' => [
            'data-title' => __d('vamshop', 'Create new & remove orphaned actions'),
            'data-placement' => 'left',
        ],
    ]);
echo $this->Html->div('btn-group', $toolsButton . $this->Html->tag('ul', $out, [
    'class' => 'dropdown-menu dropdown-menu-right',
]));

echo $this->Vamshop->adminAction(__d('vamshop', 'Edit Actions'),
    ['controller' => 'Actions', 'action' => 'index', 'permissions' => 1]);
$this->end();

$this->Js->buffer('AclPermissions.tabSwitcher();');

?>
<div class="<?= $this->Theme->getCssClass('row') ?>">
    <div class="<?= $this->Theme->getCssClass('columnFull') ?>">

        <ul id="permissions-tab" class="nav nav-tabs">
        <?php
            echo $this->Vamshop->adminTabs();
        ?>
        </ul>

        <div class="tab-content">
            <?= $this->Vamshop->adminTabs() ?>
        </div>

    </div>
</div>
