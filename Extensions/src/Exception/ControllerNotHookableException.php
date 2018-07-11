<?php

namespace Vamshop\Extensions\Exception;

use Vamshop\Core\Exception\Exception;

class ControllerNotHookableException extends Exception
{

    protected $_messageTemplate = 'Controller %s is not hookable, implement HookableComponentInterface';
}
