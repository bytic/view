<?php

declare(strict_types=1);

namespace Nip\View\Utilities;

/**
 * Class Backtrace.
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
            if ('load' == $trace['function']) {
                return $trace['file'];
            }

            if ('__call' == $trace['function'] && 'load' == $trace['args'][0]) {
                return $trace['file'];
            }
        }

        return null;
    }
}
