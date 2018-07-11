<div class="pagination-wrapper">
    <p>
        <?php
        echo $this->Paginator->counter([
            'format' => __d('vamshop',
                'Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total'),
        ]);
        ?>
    </p>
    <ul class="pagination justify-content-center pagination-sm">
        <?= $this->Paginator->first('< ' . __d('vamshop', 'first')) ?>
        <?= $this->Paginator->prev('< ' . __d('vamshop', 'prev')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__d('vamshop', 'next') . ' >') ?>
        <?= $this->Paginator->last(__d('vamshop', 'last') . ' >') ?>
    </ul>
</div>
