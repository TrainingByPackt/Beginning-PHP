<?php namespace System;

use System\View;

class Route
{
    public function __construct($config)
    {
        $url        = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $controller = !empty($url[0]) ? $url[0] : $config['default_controller'];
        $method     = !empty($url[1]) ? $url[1] : $config['default_method'];
        $args       = !empty($url[2]) ? array_slice($url, 2) : array();
        $class      = $config['namespace'].$controller;

        //check the class exists
        if (! class_exists($class)) {
            return $this->not_found();
        }

        //check the method exists
        if (! method_exists($class, $method)) {
            return $this->not_found();
        }

        //create an instance of the controller
        $classInstance = new $class;

        //call the controller and it's method and pass in any arguments
        call_user_func_array(array($classInstance, $method), $args);
    }

    //class or method not found return a 404 view
    public function not_found()
    {
        $view = new View();
        return $view->render('404');
    }
}
