<?php
echo $this->Form->input('comment_status', array(
    'type' => 'radio',
    'options' => array(
        '0' => __d('vamshop', 'Disabled'),
        '1' => __d('vamshop', 'Read only'),
        '2' => __d('vamshop', 'Read/Write'),
    ),
    'default' => $type->comment_status,
    'legend' => false,
    'label' => false
));
