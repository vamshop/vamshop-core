<?php

use Cake\Utility\Inflector;

$this->extend('Vamshop/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('vamshop', 'Settings'),
    ['plugin' => 'Vamshop/Settings', 'controller' => 'Settings', 'action' => 'index'])
    ->add($prefix, $this->request->getRequestTarget());

$this->assign('form-start', $this->Form->create(null, [
    'class' => 'protected-form',
    'type' => 'file',
]));

$this->append('tab-heading');
echo $this->Vamshop->adminTab($prefix, '#settings-main');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('settings-main');
foreach ($settings as $setting) :
    if (!empty($setting->params['tab'])) {
        continue;
    }
    $keyE = explode('.', $setting->key);
    $keyTitle = Inflector::humanize($keyE['1']);

    $label = ($setting->title != null) ? $setting->title : $keyTitle;

    echo $this->SettingsForm->input($setting, __d('vamshop', $label));
endforeach;

echo $this->Html->tabEnd();
$this->end();

$this->start('buttons');
    echo $this->Html->beginBox(__d('vamshop', 'Publishing'));
    echo $this->element('Vamshop/Core.admin/buttons', ['applyText' => false]);
    echo $this->Html->endBox();
$this->end();
