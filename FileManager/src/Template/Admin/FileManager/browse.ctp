<?php

$this->extend('Vamshop/Core./Common/admin_index');

$this->assign('title', __d('vamshop', 'File Manager'));
$this->Breadcrumbs->add(__d('vamshop', 'File Manager'), $this->request->getRequestTarget());

?>

<?php $this->start('action-buttons') ?>
<div class="btn-group">
    <?php
    echo $this->FileManager->adminAction(__d('vamshop', 'Upload here'),
        ['controller' => 'FileManager', 'action' => 'upload'], $path);
    echo $this->FileManager->adminAction(__d('vamshop', 'Create directory'),
        ['controller' => 'FileManager', 'action' => 'create_directory'], $path);
    echo $this->FileManager->adminAction(__d('vamshop', 'Create file'),
        ['controller' => 'FileManager', 'action' => 'create_file'], $path);
    ?>
</div>
<?php $this->end() ?>

<?= $this->element('Vamshop/FileManager.admin/breadcrumbs') ?>

<div class="directory-content">
    <table class="table table-striped">
        <?php
        $tableHeaders = $this->Html->tableHeaders([
            '',
            __d('vamshop', 'Directory content'),
            __d('vamshop', 'Actions'),
        ]);
        ?>
        <thead>
            <?= $tableHeaders ?>
        </thead>
        <?php
        // directories
        $rows = [];
        foreach ($content['0'] as $directory):
            $actions = [];
            $fullpath = $path . $directory;
            $actions[] = $this->FileManager->linkDirectory(__d('vamshop', 'Open'), $fullpath . DS);
            if ($this->FileManager->inPath($deletablePaths, $fullpath)) {
                $actions[] = $this->FileManager->link(__d('vamshop', 'Delete'), [
                    'controller' => 'FileManager',
                    'action' => 'delete_directory',
                ], $fullpath);
            }
            $actions[] = $this->FileManager->link(__d('vamshop', 'Rename'), [
                'controller' => 'FileManager',
                'action' => 'rename',
            ], $fullpath);
            $actions = $this->Html->div('item-actions', implode(' ', $actions));
            $rows[] = [
                $this->Html->image('/vamshop/core/img/icons/folder.png'),
                $this->FileManager->linkDirectory($directory, $fullpath . DS),
                $actions,
            ];
        endforeach;
        echo $this->Html->tableCells($rows, ['class' => 'directory-listing'], ['class' => 'directory-listing']);

        // files
        $rows = [];
        foreach ($content['1'] as $file):
            $actions = [];
            $fullpath = $path . $file;
            $icon = $this->FileManager->filename2icon($file);
            if ($icon == 'picture.png'):
                $image = '/' . str_replace(WWW_ROOT, '', $fullpath);
                $lightboxOptions = [
                    'data-toggle' => 'lightbox',
                    'escape' => false,
                ];
                $linkFile = $this->Html->link($file, $image, $lightboxOptions);
                $actions[] = $this->Html->link(__d('vamshop', 'View'), $image, $lightboxOptions);
            else:
                $linkFile = $this->FileManager->linkFile($file, $fullpath);
                $actions[] = $this->FileManager->link(__d('vamshop', 'Edit'), [
                        'plugin' => 'Vamshop/FileManager',
                        'controller' => 'FileManager',
                        'action' => 'edit_file',
                    ], $fullpath);
            endif;
            if ($this->FileManager->inPath($deletablePaths, $fullpath)) {
                $actions[] = $this->FileManager->link(__d('vamshop', 'Delete'), [
                    'plugin' => 'Vamshop/FileManager',
                    'controller' => 'FileManager',
                    'action' => 'delete_file',
                ], $fullpath);
            }
            $actions[] = $this->FileManager->link(__d('vamshop', 'Rename'), [
                'plugin' => 'Vamshop/FileManager',
                'controller' => 'FileManager',
                'action' => 'rename',
            ], $fullpath);
            $actions = $this->Html->div('item-actions', implode(' ', $actions));
            $rows[] = [
                $this->Html->image('/vamshop/core/img/icons/' . $icon),
                $linkFile,
                $actions,
            ];
        endforeach;
        echo $this->Html->tableCells($rows, ['class' => 'file-listing'], ['class' => 'file-listing']);

        ?>
        <thead>
            <?= $tableHeaders ?>
        </thead>
    </table>
</div>
