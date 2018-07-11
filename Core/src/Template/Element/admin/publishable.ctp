<?php
/**
 * @var \Vamshop\Core\View\VamshopView $this
 */
use Vamshop\Core\Status;

echo $this->Form->input('status', [
    'label' => __d('croogo', 'Status'),
    'class' => 'c-select',
    'default' => Status::UNPUBLISHED,
    'options' => $this->Vamshop->statuses(),
]);

echo $this->Html->div('input-daterange', $this->Form->input('publish_start', [
        'label' => __d('croogo', 'Publish on'),
        'empty' => true,
    ]) . $this->Form->input('publish_end', [
        'label' => __d('croogo', 'Un-publish on'),
        'empty' => true,
    ]));
