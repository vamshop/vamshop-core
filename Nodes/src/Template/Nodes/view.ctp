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


<h1>Assets</h1>

    <?php
        foreach ($this->Nodes->field('linked_assets.DefaultAsset') as $assets):
    ?>


    <div id="node-<?= $this->Nodes->field('id') ?>" class="node node-type-<?= $this->Nodes->field('type') ?>">

        <?php
            echo $this->Html->image($assets['path']);
        ?>
    </div>

    <?php
        endforeach;
    ?>
    
<h1>Featured Assets</h1>

    <div id="node-<?= $this->Nodes->field('id') ?>" class="node node-type-<?= $this->Nodes->field('type') ?>">

        <?php
            echo $this->Html->image($this->Nodes->field('linked_assets.FeaturedImage.path'));
        ?>
    </div>

<?php if (Plugin::loaded('Croogo/Comments')): ?>
<div id="comments" class="node-comments">
<?php
    $type = $typesForLayout[$this->Nodes->field('type')];

    if ($type->comment_status > 0 && $this->Nodes->field('comment_status') > 0) {
        echo $this->cell('Croogo/Comments.Comments::node', [$node->id]);
    }

    if ($type->comment_status == 2 && $this->Nodes->field('comment_status') == 2) {
        echo $this->cell('Croogo/Comments.Comments::commentFormNode', [
            'mode' => $node,
            'type' => $type
        ]);
    }
?>
</div>
<?php endif ?>
