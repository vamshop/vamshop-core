<div class="navbar navbar-light bg-light">
    <div class="d-flex justify-content-between">
        <div>
        <?php
        echo __d('vamshop', 'Sort by:');
        echo ', ' . $this->Paginator->sort('title', __d('vamshop', 'Title'), ['class' => 'sort']);
        echo ', ' . $this->Paginator->sort('created', __d('vamshop', 'Created'), ['class' => 'sort']);
        ?>
        </div>
        <button type="button" class="btn btn-primary add-image">Add images</button>
        <?= $this->element('Vamshop/Nodes.admin/nodes_search') ?>
    </div>
</div>

<div class="card-columns" id="dropzone-previews">
    <?php
    $rows = [];
    foreach ($attachments as $attachment):
        list($mimeType, $imageType) = explode('/', $attachment->mime_type);
        $imagecreatefrom = ['gif', 'jpeg', 'png', 'string', 'wbmp', 'webp', 'xbm', 'xpm'];
        if ($mimeType == 'image' && in_array($imageType, $imagecreatefrom)) {
            $thumbnail = $this->Image->resize($attachment->path, 500, 500, [], ['class' => 'card-img-bottom img-fluid']);
        } else {
            $thumbnail = $this->Html->image(
                '/vamshop/img/icons/page_white.png',
                ['class' => 'card-img-bottom img-fluid']
            );
        }

        $headerText = $this->Html->div('', $attachment->title);
        $cardHeader = $this->Html->div('card-header', $headerText);
        $card = $this->Html->div(
            'card text-xs-center selector item-choose',
            $cardHeader . $thumbnail,
            [
                'data-slug' => $attachment->slug,
                'data-chooser-type' => 'Node',
                'data-chooser-id' => $attachment->id,
                'data-chooser-title' => $attachment->title,
                'rel' => $attachment->path,
            ]
        );
        echo $card;
    endforeach;
    ?>
</div>
<?= $this->element('Vamshop/Core.admin/pagination') ?>

<?php
echo $this->Html->script([
    'Vamshop/FileManager.lib/dropzone',
    'Vamshop/FileManager.attachments/chooser'
]);
echo $this->element('Vamshop/FileManager.admin/dropzone_setup', ['type' => 'card']);
