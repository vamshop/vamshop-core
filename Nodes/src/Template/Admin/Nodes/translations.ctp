<div class="nodes index">
    <h2><?= $title_for_layout ?></h2>

    <div class="actions">
        <ul>
            <li>
            <?php
                echo $this->Html->link(__d('vamshop', 'Translate in a new language'), array(
                    'controller' => 'languages',
                    'action' => 'select',
                    'nodes',
                    'translate',
                    $node['Node']['id'],
                ));
            ?>
            </li>
        </ul>
    </div>

    <?php if (count($translations) > 0): ?>
    <table cellpadding="0" cellspacing="0">
    <?php
        $tableHeaders = $this->Html->tableHeaders(array(
            '',
            __d('vamshop', 'Title'),
            __d('vamshop', 'Locale'),
            __d('vamshop', 'Actions'),
        ));
        echo $tableHeaders;

        $rows = array();
        foreach ($translations as $translation) {
            $actions = $this->Html->link(__d('vamshop', 'Edit'), array('action' => 'translate', $id, 'locale' => $translation[$runtimeModelAlias]['locale']));
            $actions .= ' ' . $this->Form->postLink(__d('vamshop', 'Delete'), array('action' => 'delete_translation', $translation[$runtimeModelAlias]['locale'], $id), null, __d('vamshop', 'Are you sure?'));

            $rows[] = array(
                '',
                $translation[$runtimeModelAlias]['content'],
                $translation[$runtimeModelAlias]['locale'],
                $actions,
            );
        }

        echo $this->Html->tableCells($rows);
        echo $tableHeaders;
    ?>
    </table>
    <?php else: ?>
        <p><?= __d('vamshop', 'No translations available.') ?></p>
    <?php endif ?>
</div>