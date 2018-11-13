<?php

use Cake\Core\Configure;

$this->extend('Vamshop/Core./Common/admin_index');

$this->assign('title', __d('vamshop', 'Themes'));

$this->Breadcrumbs->add(__d('vamshop', 'Extensions'),
        ['plugin' => 'Vamshop/Extensions', 'controller' => 'Plugins', 'action' => 'index'])
    ->add(__d('vamshop', 'Themes'), $this->request->getUri()->getPath());

$this->start('action-buttons');
echo $this->Vamshop->adminAction(__d('vamshop', 'Upload'), ['action' => 'add'], ['class' => 'btn btn-success']);
$this->end() ?>

<div class="<?= $this->Theme->getCssClass('row') ?>">
    <div class="extensions-themes <?= $this->Theme->getCssClass('columnFull') ?>">
        <div class="current-theme <?= $this->Theme->getCssClass('row') ?>">
            <div class="screenshot <?= $this->Theme->getCssClass('columnRight') ?>">
                <h3><?= __d('vamshop', 'Current Theme') ?></h3>
                <?php
                if (isset($currentTheme['screenshot'])):
                    $file = $this->Url->assetUrl($currentTheme['name'] . '.' . $currentTheme['screenshot']);
                    $imgUrl = $this->Html->thumbnail($file);
                    $link = $this->Html->link($imgUrl, $file, [
                        'escape' => false,
                        'data-toggle' => 'lightbox',
                    ]);
                    echo $this->Html->tag('div', $link);
                endif;
                ?>
            </div>

            <div class="<?= $this->Theme->getCssClass('columnLeft') ?>">
                <h3>
                    <?php
                    $author = isset($currentTheme['author']) ? $currentTheme['author'] : null;
                    if (isset($currentTheme['authorUrl']) && strlen($currentTheme['authorUrl']) > 0) {
                        $author = $this->Html->link($author, $currentTheme['authorUrl']);
                    }
                    echo $currentTheme['name'];
                    if (!empty($author)):
                        echo ' ' . __d('vamshop', 'by') . ' ' . $author;
                    endif;
                    ?>
                </h3>
                <p class="description"><?= $currentTheme['description'] ?></p>
                <?php if (isset($currentTheme['regions'])): ?>
                    <p class="regions"><?= __d('vamshop', 'Regions supported: ') .
                            implode(', ', $currentTheme['regions']) ?></p>
                <?php endif ?>
            </div>
        </div>

        <div class="available-themes">
            <h3><?= __d('vamshop', 'Available Themes') ?></h3>

            <?php
            $hasAvailable = false;
            foreach ($themesData as $themeAlias => $theme):
                $themeName = $theme['name'];
                $isAdminOnly = (!isset($theme['adminOnly']) || $theme['adminOnly'] != 'true');
                $isDefault = !($themeAlias == 'default' && !Configure::read('Site.theme'));
                $display = $themeAlias != $currentTheme['name'] && $isAdminOnly && $isDefault;
                if (!$display):
                    continue;
                endif;
                echo '<div class="content ' . $this->Theme->getCssClass('row') . '">';
                if (!empty($theme['screenshot'])):
                    $dataUri = $this->Vamshop->dataUri($themeName, $theme['screenshot']);
                    $thumbnail = '<img class="img-thumbnail" src="' . $dataUri . '">';
                    $image = sprintf('<a href="%s" %s>%s</a>',
                        $dataUri,
                        'data-toggle="lightbox"',
                        $thumbnail
                    );

                    echo $this->Html->tag('div', $image, [
                        'class' => 'screenshot ' . $this->Theme->getCssClass('columnRight'),
                    ]);
                else:
                    echo $this->Html->tag('div', '', [
                        'class' => $this->Theme->getCssClass('columnRight'),
                    ]);
                endif;
                $author = isset($theme['author']) ? $theme['author'] : null;
                if (isset($theme['authorUrl']) && strlen($theme['authorUrl']) > 0) {
                    $author = $this->Html->link($author, $theme['authorUrl']);
                }

                $out = $this->Html->tag('h3', $theme['name'] . ' ' . __d('vamshop', 'by') . ' ' . $author, []);
                $out .= $this->Html->tag('p', $theme['description'], ['class' => 'description']);
                if (isset($theme['regions'])):
                    $out .= $this->Html->tag('p',
                        __d('vamshop', 'Regions supported: ') . implode(', ', $theme['regions']),
                        ['class' => 'regions']);
                endif;
                $out .= $this->Html->tag('div', $this->Form->postLink(__d('vamshop', 'Activate'), [
                        'action' => 'activate',
                        urlencode(base64_encode($themeName)),
                    ], [
                        'button' => 'secondary',
                        'icon' => $this->Theme->getIcon('power-on'),
                    ]) . $this->Form->postLink(__d('vamshop', 'Delete'), [
                        'action' => 'delete',
                        urlencode($themeName),
                    ], [
                        'button' => 'danger',
                        'escape' => true,
                        'escapeTitle' => false,
                        'icon' => $this->Theme->getIcon('delete'),
                    ], __d('vamshop', 'Are you sure?')), ['class' => 'actions']);
                echo $this->Html->div($this->Theme->getCssClass('columnLeft'), $out);
                echo '</div>';
                $hasAvailable = true;
            endforeach;

            if (!$hasAvailable):
                echo $this->Html->tag('li', __d('vamshop', 'No available theme'));
            endif;
            ?>
        </div>
    </div>
</div>
