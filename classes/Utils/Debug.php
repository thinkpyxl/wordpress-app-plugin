<?php

namespace WordPress_WebApp\Utils;

class Debug
{
    public static function log()
    {
        if (!WP_DEBUG_LOG) {
            return;
        }

        foreach (func_get_args() as $arg) {
            error_log("--------------------------------------------------------------------------------------------------");
            if (is_array($arg) || is_object($arg)) {
                error_log(print_r($arg, true));

            } else {
                error_log($arg);
            }
            error_log("--------------------------------------------------------------------------------------------------");
        }
    }
}