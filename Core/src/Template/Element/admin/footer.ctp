<footer class="navbar-dark">
    <div class="navbar-inner">

        <div class="footer-content">
            <?php
            use Cake\Core\Configure;

            $link = $this->Html->link(__d('vamshop', 'Vamshop %s', (string)Configure::read('Vamshop.version')),
                'http://www.vamshop.com');
            ?>
            <?= __d('vamshop', 'Powered by %s', $link) ?>
            <?= $this->Html->image('//assets.vamshop.com/powered_by.png') ?>
        </div>

    </div>
</footer>
