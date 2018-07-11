<footer class="navbar-dark">
    <div class="navbar-inner">

        <div class="footer-content">
            <?php
            use Cake\Core\Configure;

            $link = $this->Html->link(__d('croogo', 'Croogo %s', (string)Configure::read('Croogo.version')),
                'http://www.vamshop.com');
            ?>
            <?= __d('croogo', 'Powered by %s', $link) ?>
            <?= $this->Html->image('//assets.vamshop.com/powered_by.png') ?>
        </div>

    </div>
</footer>
