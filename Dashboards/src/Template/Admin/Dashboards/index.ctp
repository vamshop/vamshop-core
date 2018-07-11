<?php
$this->assign('title', __d('vamshop', 'Dashboards'));

$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs
        ->add(__d('vamshop', 'Dashboards'), array('action' => 'index'));

$this->set('showActions', false);

$this->append('table-heading');
    $tableHeaders = $this->Html->tableHeaders(array(
        $this->Paginator->sort('id'),
        $this->Paginator->sort('alias'),
        $this->Paginator->sort('column'),
        $this->Paginator->sort('collapsed'),
        $this->Paginator->sort('status'),
        $this->Paginator->sort('updated'),
        $this->Paginator->sort('created'),
        __d('vamshop', 'Actions'),
    ));
    echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
foreach ($dashboards as $dashboard):
?>
    <tr>
        <td><?= h($dashboard->id) ?>&nbsp;</td>
        <td><?= h($dashboard->alias) ?>&nbsp;</td>
        <td><?= $this->Dashboards->columnName($dashboard->column) ?>&nbsp;</td>
        <td>
            <?php
            if ($dashboard->collapsed):
                echo $this->Layout->status($dashboard->collapsed);
            endif;
            ?>&nbsp;
        </td>
        <td>
            <?php
                echo $this->element('Vamshop/Core.admin/toggle', array(
                    'id' => $dashboard->id,
                    'status' => (int)$dashboard->status,
                ));
            ?>
        </td>
        <td><?= $this->Time->i18nFormat($dashboard->updated) ?>&nbsp;</td>
        <td><?= $this->Time->i18nFormat($dashboard->created) ?>&nbsp;</td>
        <td class="item-actions">
        <?php
            $actions = array();
            $actions[] = $this->Vamshop->adminRowAction('',
                array('controller' => 'Dashboards', 'action' => 'moveup', $dashboard->id),
                array(
                    'icon' => $this->Theme->getIcon('move-up'),
                    'tooltip' => __d('vamshop', 'Move up'),
                )
            );
            $actions[] = $this->Vamshop->adminRowAction('',
                array('controller' => 'Dashboards', 'action' => 'movedown', $dashboard->id),
                array(
                    'icon' => $this->Theme->getIcon('move-down'),
                    'tooltip' => __d('vamshop', 'Move down'),
                )
            );
            $actions[] = $this->Vamshop->adminRowAction('',
                array('action' => 'delete', $dashboard->id),
                array(
                    'icon' => $this->Theme->getIcon('delete'),
                    'escape' => true,
                    'method' => 'post',
                ),
                __d('vamshop', 'Are you sure you want to delete # %s?', $dashboard->id)
            );
            echo implode(' ', $actions);
        ?>
        </td>
    </tr>
<?php
endforeach;
$this->end();
