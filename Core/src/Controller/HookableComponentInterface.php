<?php

namespace Vamshop\Core\Controller;

interface HookableComponentInterface
{

    public function _loadHookableComponent($name, array $config);
}
