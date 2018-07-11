<?php
/**
 * @var \Vamshop\Core\View\VamshopView $this
 */

$cancelUrl = isset($cancelUrl) ? $cancelUrl : ['action' => 'index'];
$saveText = isset($saveText) ? $saveText : '<i class="fa fa-save"></i> ' . __d('vamshop', 'Save');
$defaultApplyText = __d('vamshop', 'Apply');
if (isset($applyText)):
    if ($applyText !== false):
        $applyText = $defaultApplyText;
    endif;
else:
    $applyText = '<i class="fa fa-bolt"></i> ' . $defaultApplyText;
endif;


?>
<div class="clearfix">
    <div class="card-buttons d-flex justify-content-center">
    <?php
        echo $this->Form->button($saveText, ['class' => 'btn-outline-success']);
        if ($applyText):
            echo $this->Form->button($applyText, ['class' => 'btn-outline-primary',
                'name' => '_apply',
            ]);
        endif;
        echo $this->Html->link(__d('vamshop', 'Cancel'), $cancelUrl, [
            'class' => 'cancel btn btn-outline-danger'
        ]);
    ?>
    </div>
</div>
