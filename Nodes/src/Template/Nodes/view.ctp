<?php
use Cake\Core\Plugin;

$this->assign('title', $node->title);
$this->Nodes->set($node);
?>
<div id="node-<?= $this->Nodes->field('id') ?>" class="node node-type-<?= $this->Nodes->field('type') ?>">
    <h2><?= $this->Nodes->field('title') ?></h2>
    <?php
        echo $this->Nodes->info();
        echo $this->Nodes->body();
        echo $this->Nodes->moreInfo();
    ?>
</div>

<?php if (Plugin::loaded('Assets')): ?>
<?php if (isset($node->linked_assets['DefaultAsset'])): ?>
    <?php
        foreach ($node->linked_assets['DefaultAsset'] as $assets):
    ?>


    <div id="node-<?= $this->Nodes->field('id') ?>" class="node node-type-<?= $this->Nodes->field('type') ?>">

        <?php
            echo $this->Html->image($assets['path']);
        ?>
    </div>

    <?php
        endforeach;
    ?>
<?php endif ?>  
    
<?php if (isset($node->linked_assets['FeaturedImage'])): ?>
<h1>Featured Assets</h1>

    <?php
        foreach ($node->linked_assets['FeaturedImage'] as $featured):
    ?>


    <div id="node-<?= $this->Nodes->field('id') ?>" class="node node-type-<?= $this->Nodes->field('type') ?>">

        <?php
            echo $this->Html->image($featured['path']);
        ?>
    </div>

    <?php
        endforeach;
    ?>

<?php endif ?>  

<?php endif ?>    

<?php if (Plugin::loaded('Vamshop/Comments')): ?>
<div id="comments" class="node-comments">
<?php
    $type = $typesForLayout[$this->Nodes->field('type')];

    if ($type->comment_status > 0 && $this->Nodes->field('comment_status') > 0) {
        echo $this->cell('Vamshop/Comments.Comments::node', [$node->id]);
    }

    if ($type->comment_status == 2 && $this->Nodes->field('comment_status') == 2) {
        echo $this->cell('Vamshop/Comments.Comments::commentFormNode', [
            'mode' => $node,
            'type' => $type
        ]);
    }
?>
</div>
<?php endif ?>
