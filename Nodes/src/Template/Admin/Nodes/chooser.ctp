<div class="navbar navbar-light bg-light">
    <div class="float-left">
        <?php
        echo __d('vamshop', 'Sort by:');
        echo ' ' . $this->Paginator->sort('id', __d('vamshop', 'Id'), ['class' => 'sort']);
        echo ', ' . $this->Paginator->sort('title', __d('vamshop', 'Title'), ['class' => 'sort']);
        echo ', ' . $this->Paginator->sort('created', __d('vamshop', 'Created'), ['class' => 'sort']);
        ?>
    </div>
    <div class="float-right">
        <?= $this->element('Vamshop/Nodes.admin/nodes_search') ?>
    </div>
</div>
<hr>
<div class="row">
    <ul id="nodes-for-links">
        <?php if (isset($type)) : ?>
        <li>
            <?php
            echo $this->Html->link(__d('vamshop', '%s archive/index', $type->title), [
                'prefix' => 'admin',
                'plugin' => 'Vamshop/Nodes',
                'controller' => 'Nodes',
                'action' => 'hierarchy',
                'type' => $type->alias,
            ], [
                'class' => 'item-choose',
                'data-chooser-type' => 'Node',
                'data-chooser-id' => $type->id,
                'data-chooser-title' => $type->title,
                'rel' => $type->url->toLinkString(),
            ]);
            ?>
        </li>
        <?php endif ?>
        <?php foreach ($nodes as $node) : ?>
            <li>
                <?php
                echo $this->Html->link($node->title, [
                    'prefix' => 'admin',
                    'plugin' => 'Vamshop/Nodes',
                    'controller' => 'Nodes',
                    'action' => 'view',
                    'type' => $node->type,
                    'slug' => $node->slug,
                ], [
                    'class' => 'item-choose',
                    'data-chooser-type' => 'Node',
                    'data-chooser-id' => $node->id,
                    'data-chooser-title' => $node->title,
                    'rel' => $node->url->toLinkString(),
                ]);

                $popup = [];
                $type = __d('vamshop', $nodeTypes[$node->type]);
                $popup[] = [
                    __d('vamshop', 'Promoted'),
                    $this->Layout->status($node->promote),
                ];
                $popup[] = [__d('vamshop', 'Status'), $this->Layout->status($node->status)];
                $popup[] = [__d('vamshop', 'Created'), $node->created];
                $popup = $this->Html->tag('table', $this->Html->tableCells($popup));
                $a = $this->Html->link('', '#', [
                    'class' => 'popovers action',
                    'icon' => 'info-sign',
                    'data-title' => $type,
                    'data-trigger' => 'click',
                    'data-placement' => 'right',
                    'data-html' => true,
                    'data-content' => h($popup),
                ]);
                echo $a;
                ?>
            </li>
        <?php endforeach ?>
    </ul>
    <div class="pagination">
        <ul><?= $this->Paginator->numbers() ?></ul>
    </div>
</div>
