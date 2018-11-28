<?php

namespace Vamshop\Suppliers\Config;

use Vamshop\Core\Vamshop;

Vamshop::hookBehavior('Shops.Orders', 'Suppliers.SuppliersOrderMonitor');
