<?php namespace App\Helpers;

class Session
{
    private static $sessionStarted = false;

    /**
     * if session has not started, start sessions
     */
    public static function init()
    {
        if (self::$sessionStarted == false) {
            session_start();
            self::$sessionStarted = true;
        }
    }

    public static function set($key, $value = false)
    {
        /**
         * Check whether session is set in array or not
         * If array then set all session key-values in foreach loop
         */
        if (is_array($key) && $value === false) {
            foreach ($key as $name => $value) {
                $_SESSION[$name] = $value;
            }
        } else {
            $_SESSION[$key] = $value;
        }
    }

    public static function pull($key)
    {
        $value = $_SESSION[$key];
        unset($_SESSION[$key]);

        return $value;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return false;
    }


    public static function display()
    {
        return $_SESSION;
    }

    public static function destroy($key = '')
    {
        if (self::$sessionStarted == true) {
            if (empty($key)) {
                session_unset();
                session_destroy();
            } else {
                unset($_SESSION[$key]);
            }
        }
    }

}
