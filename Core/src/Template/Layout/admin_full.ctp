s
                    <?= $this->fetch('content') ?>
                </div>
            </div>
        </div>

    </div>

    <?= $this->element('Vamshop/Core.admin/footer') ?>
    <?php
        echo $this->element('Vamshop/Core.admin/initializers');
        echo $this->Blocks->get('scriptBottom');
        echo $this->Js->writeBuffer();
    ?>
    </body>
</html>