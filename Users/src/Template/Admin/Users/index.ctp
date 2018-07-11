<?php

$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('vamshop', 'Users'), $this->request->getUri()->getPath());
