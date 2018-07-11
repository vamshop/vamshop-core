<div class="form">
    <?=
        $this->cell('Vamshop/Comments.Comments::commentFormNode', [
            'node' => $entity,
            'type' => $typesForLayout[$entity->type],
            'comment' => $comment
        ]);
    ?>
</div>
