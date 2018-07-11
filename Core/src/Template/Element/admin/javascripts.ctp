<?php

if (!$this->request->is('ajax')):

    echo $this->Layout->js();
    echo $this->Html->script([
        'Vamshop/Core.jquery/jquery.min.js',
        'Vamshop/Core.jquery/jquery-ui.min.js',
        'Vamshop/Core.core/popper.min.js',
        'Vamshop/Core.core/bootstrap.min.js',
        'Vamshop/Core.jquery/jquery.slug',
        'Vamshop/Core.jquery/jquery.hoverIntent.minified',
        'Vamshop/Core.core/underscore-min',
        'Vamshop/Core.core/bootstrap3-typeahead.min',
        'Vamshop/Core.core/admin',
        'Vamshop/Core.core/sidebar',
        'Vamshop/Core.core/choose',
        'Vamshop/Core.core/modal',
        'Vamshop/Core.core/moment-with-locales',
        'Vamshop/Core.core/moment-timezone-with-data',
        'Vamshop/Core.core/bootstrap-datetimepicker.min',
        'Vamshop/Core.core/typeahead_autocomplete',
        'Vamshop/Core.core/ekko-lightbox.min.js',
        'Vamshop/Core.core/select2.full.min.js',
    ]);

endif;
