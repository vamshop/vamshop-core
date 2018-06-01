<?php
$this->Croogo->adminScript('Nodes.admin');
if (Configure::read('Writing.wysiwyg')) {
    $this->Html->scriptBlock($tinymce->fileBrowserCallBack(), array('inline' => false));
    $this->Html->scriptBlock($tinymce->init('NodeBody'), array('inline' => false));
}
?>
<div class="nodes form">
    <h2><?= $title_for_layout ?></h2>

    <?php
        echo $this->Form->create('Node', array('url' => array(
            'action' => 'translate',
            'locale' => $this->request->params['named']['locale'],
        )));
    ?>
    <fieldset>
        <div class="tabs">
            <ul>
                <li><a href="#node-main"><span><?= __d('croogo', $type['Type']['title']) ?></span></a></li>
            </ul>

            <div id="node-main">
            <?php
                foreach ($fields as $field) {
                    echo $this->Form->input('Node.' . $field);
                }
            ?>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->end('Submit');?>
</div>