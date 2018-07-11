<?php

use Cake\Utility\Inflector;
use Vamshop\Core\Vamshop;

Vamshop::hookComponent('*', ['Vamshop/Meta.Meta' => ['priority' => 8]]);

Vamshop::hookHelper('*', 'Vamshop/Meta.Meta');

Inflector::rules('uninflected', ['meta']);
