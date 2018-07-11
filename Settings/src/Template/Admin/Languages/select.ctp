<?php

$this->extend('/Common/admin_index');

$this->Breadcrumbs
    ->add(__d('vamshop', 'Settings'), [
        'plugin' => 'Vamshop/Settings',
        'controller' => 'Settings',
        'action' => 'index',
    ])
    ->add(__d('vamshop', 'Languages'), [
        'plugin' => 'Vamshop/Settings',
        'controller' => 'Languages',
        'action' => 'index'
    ]);

$this->append('main');
    $html = null;
    foreach ($languages as $language):
        $title = $language->title . ' (' . $language->native . ')';
        $link = $this->Html->link($title, array(
            'plugin' => 'Vamshop/Translate',
            'controller' => 'Translate',
            'action' => 'edit',
            '?' => [
                'id' => $id,
                'model' => $modelAlias,
                'locale' => $language->alias,
            ],
        ));
        $html .= '<li>' . $link . '</li>';
    endforeach;
    echo $this->Html->div(
        $this->Theme->getCssClass('columnFull'),
        $this->Html->tag('ul', $html)
    );
$this->end();
