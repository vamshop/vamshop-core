<?php $this->assign('title', __d('vamshop', 'Dashboards')) ?>
<?php
$this->Vamshop->adminScript('Vamshop/Dashboards.admin');
$this->Html->css('Vamshop/Dashboards.admin', array('block' => true));

$this->Breadcrumbs  ->add(__d('vamshop', 'Dashboard'), $this->request->getRequestTarget());

echo $this->Dashboards->dashboards();

$this->Html->scriptBlock('Dashboard.init();', ['block' => 'scriptBottom']);
?>
<div id="dashboard-url" class="hidden"><?= $this->Url->build(array('action' => 'save'));?></div>
