<?php
$captcha = (isset($captcha)) ? $captcha : false;
?>
<div class="comment-form">
    <h3><?= h(__d('vamshop', 'Add new comment')); ?></h3>
    <?php if ($this->request->params['controller'] == 'Comments'): ?>
        <p class="back">
            <?= $this->Html->link(__d('vamshop', 'Go back to original post: %s', $title), $url->getUrl()); ?>
        </p>
    <?php endif; ?>
    <?= $this->Form->create($comment, ['url' => $formUrl]); ?>
    <?php if (!$loggedInUser): ?>
        <?= $this->Form->input('name', ['label' => __d('vamshop', 'Name')]); ?>
        <?= $this->Form->input('email', ['label' => __d('vamshop', 'Email')]); ?>
        <?= $this->Form->input('website', ['label' => __d('vamshop', 'Website')]); ?>
    <?php endif; ?>
    <?= $this->Form->input('body'); ?>
    <?php if ($captcha): ?>
        <?= $this->Recaptcha->display(); ?>
    <?php endif; ?>
    <?= $this->Form->submit(__d('vamshop', 'Post comment')); ?>
    <?= $this->Form->end(); ?>
</div>
