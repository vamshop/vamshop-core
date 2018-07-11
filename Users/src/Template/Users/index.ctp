<div class="users index">
    <h2><?= $title_for_layout ?></h2>

    <p><?= __d('vamshop', 'You are currently logged in as:') . ' ' . $this->request->session()->read('Auth.User.username') ?></p>
</div>