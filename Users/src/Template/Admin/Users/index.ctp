<?php

$this->extend('Vamshop/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('croogo', 'Users'), $this->request->getUri()->getPath());
