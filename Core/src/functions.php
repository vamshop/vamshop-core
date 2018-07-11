<?php

namespace Vamshop\Core;

use Vamshop\Core\Link;
use DebugKit\DebugTimer;

if (!function_exists('\Vamshop\Core\linkFromLinkString')) {
    /**
     * @param string $link
     *
     * @return \Vamshop\Core\Link
     */
    function linkFromLinkString($link)
    {
        return Link::createFromLinkString($link);
    }
}

if (!function_exists('\Vamshop\Core\link')) {
    /**
     * @param array|string $url
     *
     * @return \Vamshop\Core\Link
     */
    function link($url)
    {
        return new Link($url);
    }
}

if (!function_exists('\Vamshop\Core\timerStart')) {
    function timerStart($name, $message = null)
    {
        if (!Plugin::available('DebugKit')) {
            return;
        }

        DebugTimer::start($name, $message);
    }
}

if (!function_exists('\Vamshop\Core\timerStop')) {
    function timerStop($name)
    {
        if (!Plugin::available('DebugKit')) {
            return;
        }

        DebugTimer::stop($name);
    }
}

if (!function_exists('\Vamshop\Core\time')) {
    function time(callable $callable, $name, $message = null)
    {
        timerStart($name, $message);

        call_user_func($callable);

        timerStop($name);
    }
}
