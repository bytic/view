<?php

namespace Nip\View\Utilities;

/**
 * Class Backtrace
 * @package Nip\View\Utilities
 */
class Backtrace
{
    /**
     * @return string
     */
    public static function getViewOrigin()
    {
        $backtrace = debug_backtrace();
        foreach ($backtrace as $trace) {
            if ($trace['function'] == 'load') {
                return $trace['file'];
            }
        }
        return null;
    }
}
