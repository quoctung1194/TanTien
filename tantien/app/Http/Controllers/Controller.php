<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Customize render view
     *
     * @return void
     */
    protected function view($view = null, $data = [], $mergeData = []) {
        // get name of current controller
        $array = explode('\\', substr(get_class($this), 0, -10));
        $data['controller'] = $array[count($array) - 1];

        // render view
        return view($data['controller'] . '.' . $view, $data, $mergeData);
    }
}
