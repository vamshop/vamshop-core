<?php
$this->extend('Vamshop/Core./Common/admin_index');
$this->Breadcrumbs->add(__d('vamshop', 'Contacts'), $this->request->getUri()->getPath());
