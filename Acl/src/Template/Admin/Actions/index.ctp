<?php

$this->extend('Vamshop/Core./Common/admin_index');

$this->Html->script('Vamshop/Acl.acl_permissions', ['block' => true]);

$this->Vamshop->adminScript('Vamshop/Acl.acl_permissions');

$this->Breadcrumbs
    ->add(__d('vamshop', 'Users'), array('plugin' => 'Vamshop/Users', 'controller' => 'Users', 'action' => 'index'))
    ->add(__d('vamshop', 'Permissions'), array(
        'plugin' => 'Vamshop/Acl', 'controller' => 'Permissions',
    ))
    ->add(__d('vamshop', 'Actions'), array('plugin' => 'Vamshop/Acl', 'controller' => 'Actions', 'action' => 'index', 'permission' => 1));

$this->append('action-buttons');
    $toolsButton = $this->Html->link(
        __d('vamshop', 'Tools'),
        '#',
        array(
            'button' => 'secondary',
            'class' => 'dropdown-toggle',
            'data-toggle' => 'dropdown',
            'escape' => false
        )
    );

    $generateUrl = array(
        'plugin' => 'Vamshop/Acl',
        'controller' => 'Actions',
        'action' => 'generate',
        'permissions' => 1
    );
    $out = $this->Vamshop->adminAction(__d('vamshop', 'Generate'),
        $generateUrl,
        array(
            'button' => false,
            'list' => true,
            'method' => 'post',
            'class' => 'dropdown-item',
            'tooltip' => array(
                'data-title' => __d('vamshop', 'Create new actions (no removal)'),
                'data-placement' => 'left',
            ),
        )
    );
    $out .= $this->Vamshop->adminAction(__d('vamshop', 'Synchronize'),
        $generateUrl + array('sync' => 1),
        array(
            'button' => false,
            'list' => true,
            'method' => 'post',
            'class' => 'dropdown-item',
            'tooltip' => array(
                'data-title' => __d('vamshop', 'Create new & remove orphaned actions'),
                'data-placement' => 'left',
            ),
        )
    );
    echo $this->Html->div('btn-group',
        $toolsButton .
        $this->Html->tag('ul', $out, [
            'class' => 'dropdown-menu dropdown-menu-right',
        ])
    );
$this->end();

$this->set('tableClass', 'table permission-table');
$this->start('table-heading');
    $tableHeaders = $this->Html->tableHeaders(array(
        __d('vamshop', 'Id'),
        __d('vamshop', 'Alias'),
        __d('vamshop', 'Actions'),
    ));
    echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
    $currentController = '';
    $icon = '<i class="icon-none float-right"></i>';
    foreach ($acos as $aco) {
        $id = $aco->id;
        $alias = $aco->alias;
        $class = '';
        if (substr($alias, 0, 1) == '_') {
            $level = 1;
            $class .= 'level-' . $level;
            $oddOptions = array('class' => 'hidden controller-' . $currentController);
            $evenOptions = array('class' => 'hidden controller-' . $currentController);
            $alias = substr_replace($alias, '', 0, 1);
        } else {
            $level = 0;
            $class .= ' controller';
            if ($aco->children > 0) {
                $class .= ' perm-expand';
            }
            $oddOptions = array();
            $evenOptions = array();
            $currentController = $alias;
        }

        $actions = array();
        $actions[] = $this->Vamshop->adminRowAction('',
            array('action' => 'move', $id, 'up'),
            array('icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('vamshop', 'Move up'))
        );
        $actions[] = $this->Vamshop->adminRowAction('',
            array('action' => 'move', $id, 'down'),
            array('icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('vamshop', 'Move down'))
        );

        $actions[] = $this->Vamshop->adminRowAction('',
            array('action' => 'edit', $id),
            array('icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('vamshop', 'Edit this item'))
        );
        $actions[] = $this->Vamshop->adminRowAction('',
            array('action' => 'delete', $id),
            array(
                'icon' => $this->Theme->getIcon('delete'),
                'tooltip' => __d('vamshop', 'Remove this item'),
                'escapeTitle' => false,
                'escape' => true,
            ),
            __d('vamshop', 'Are you sure?')
        );

        $actions = $this->Html->div('item-actions', implode(' ', $actions));
        $row = array(
            $id,
            $this->Html->div(trim($class), $alias . $icon, array(
                'data-id' => $id,
                'data-alias' => $alias,
                'data-level' => $level,
            )),
            $actions,
        );

        echo $this->Html->tableCells($row, $oddOptions, $evenOptions);
    }
    echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->Js->buffer('AclPermissions.documentReady();');
