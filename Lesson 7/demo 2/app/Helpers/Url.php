<?php namespace App\Helpers;

class Url
{
    public static function redirect($path = '/')
    {
        header('Location: '.$path);
        exit();
    }
}
