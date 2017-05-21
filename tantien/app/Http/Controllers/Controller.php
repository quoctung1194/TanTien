<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Utilizes\ControllerHelper;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Customize render view
     *
     * @return void
     */
    protected function view($view = null, $data = [], $mergeData = [])
    {
        // get name of current controller
        $data['controller'] = ControllerHelper::getNameController($this);

        // render view
        return view($data['controller'] . '.' . $view, $data, $mergeData);
    }

    /**
     * Get sort columns
     *
     * @param $sort: array of sorting columns
     * @return array
     */
    public function getSortColumns($sort = null)
    {
        // array contain sort columns
        $sortArr = array();

        // name of current controller
        $controllerName = ControllerHelper::getNameController($this);
        // get name of corresponding table
        $model = 'App\\' . $controllerName;
        $tableName = (new $model)->getTable();
        
        if ($sort != null) {
            //Todo: update later
        } else {
            $sortArr[$tableName . '.' . 'updated_at'] = 'desc';
        }

        return $sortArr;
    }
}
