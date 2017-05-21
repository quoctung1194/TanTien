<?php

namespace App\Utilizes;

class ControllerHelper
{
    /**
     * Get name of controller by passing object
     * 
     * @param $controller: object object controller
     * @return string: name of controller
     */
    public static function getNameController($controller)
    {
        $array = explode('\\', substr(get_class($controller), 0, -10));
        return $array[count($array) - 1];
    }
}