<?php

use Cake\Core\Configure;

$this->extend('Vamshop/Core./Common/admin_index');

$this->assign('title', __d('vamshop', 'Locales'));

$this->Breadcrumbs
    ->add(__d('vamshop', 'Extensions'), array('plugin' => 'Vamshop/Extensions', 'controller' => 'Plugins', 'action' => 'index'))
    ->add(__d('vamshop', 'Locales'), $this->request->getUri()->getPath());

$this->append('action-buttons');
    echo $this->Vamshop->adminAction(__d('vamshop', 'Upload'),
        array('action' => 'add')
    );
$this->end();

$this->start('table-heading');
    $tableHeaders = $this->Html->tableHeaders(array(
        '',
        __d('vamshop', 'Locale'),
        __d('vamshop', 'Name'),
        __d('vamshop', 'Default'),
        __d('vamshop', 'Actions'),
    ));
    echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
    $rows = array();
    $vendorDir = ROOT . DS . 'vendor' . DS . 'vamshop' . DS . 'locale' . DS;
    $siteLocale = Configure::read('Site.locale');
    foreach ($locales as $locale => $data):
        $actions = array();

        if ($locale == $siteLocale) {
            $status = $this->Html->status(1);
            $actions[] = $this->Vamshop->adminRowAction('',
                array('action' => 'deactivate', $locale),
                array('icon' => $this->Theme->getIcon('power-off'), 'tooltip' => __d('vamshop', 'Deactivate'), 'method' => 'post')
            );
        } else {
            $status = $this->Html->status(0);
            $actions[] = $this->Vamshop->adminRowAction('',
                array('action' => 'activate', $locale),
                array('icon' => $this->Theme->getIcon('power-on'), 'tooltip' => __d('vamshop', 'Activate'), 'method' => 'post')
            );
        }

        $actions[] = $this->Vamshop->adminRowAction('',
            array('action' => 'edit', $locale),
            array('icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('vamshop', 'Edit this item'))
        );

        if (strpos($data['path'], $vendorDir) !== 0):
            $actions[] = $this->Vamshop->adminRowAction('',
                ['action' => 'delete', $locale],
                [
                    'icon' => $this->Theme->getIcon('delete'),
                    'tooltip' => __d('vamshop', 'Remove this item'),
                ],
                __d('vamshop', 'Are you sure?')
            );
        endif;
        $actions = $this->Html->div('item-actions', implode(' ', $actions));

        $rows[] = array(
            '',
            $locale,
            $data['name'],
            $status,
            $actions,
        );
    endforeach;

    usort($rows, function($a, $b) {
        return strcmp($a[3], $b[3]);
    });

    echo $this->Html->tableCells($rows);
$this->end();
?>
