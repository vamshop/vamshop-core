<?php

if (!$this->request->is('ajax')):

    echo $this->Html->css([
        'Vamshop/Core.core/vamshop-admin',
        'Vamshop/Core.core/bootstrap-datetimepicker.min',
        'Vamshop/Core.core/typeaheadjs',
        'Vamshop/Core.core/ekko-lightbox.min.css',
        'Vamshop/Core.core/select2.min.css',
        'Vamshop/Core.core/select2-bootstrap.min.css',
    ]);

endif;
