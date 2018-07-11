<?php

$this->extend('Vamshop/Core./Common/admin_view');

$this->Breadcrumbs
    ->add(__d('vamshop', 'Users'), ['action' => 'index'])
    ->add($user->name, $this->request->getRequestTarget());

$this->append('action-buttons');
    echo $this->Vamshop->adminAction(__d('vamshop', 'Edit User'), ['action' => 'edit', $user->id]);
$this->end();

$this->append('main');
?>
<div class="users view large-9 medium-8 columns">
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __d('vamshop', 'Role') ?></th>
            <td><?= $user->has('role') ? $this->Html->link($user->role->title, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('vamshop', 'Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('vamshop', 'Name') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('vamshop', 'Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('vamshop', 'Website') ?></th>
            <td><?= h($user->website) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('vamshop', 'Timezone') ?></th>
            <td><?= h($user->timezone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('vamshop', 'Updated By') ?></th>
            <td><?= $this->Number->format($user->updated_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('vamshop', 'Created By') ?></th>
            <td><?= $this->Number->format($user->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('vamshop', 'Updated') ?></th>
            <td><?= $this->Time->i18nFormat($user->updated) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('vamshop', 'Created') ?></th>
            <td><?= $this->Time->i18nFormat($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('vamshop', 'Status') ?></th>
            <td><?= $user->status ? __d('vamshop', 'Yes') : __d('vamshop', 'No'); ?></td>
        </tr>
    </table>
    <div>
        <label>
            <strong><?= __d('vamshop', 'Bio') ?></strong>
        </label>
        <?= $this->Text->autoParagraph(h($user->bio)); ?>
    </div>
</div>
<?php
$this->end();
