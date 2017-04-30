<?php

namespace App\Utilizes;

use App\constants\CommonConstant;

class TUrl
{
    public static function asset($url) {
        return $url . '?v=' . CommonConstant::RESOURCE_VERSION; 
    }
}