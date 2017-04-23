<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DrugOrder;

class DrugOrderController extends Controller
{
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Index action
     *
     * @return void
     */
    public function index()
    {
        return $this->view('index');
    }

    /**
     * Search action
     *
     * @return void
     */
    public function search(Request $request)
    {
        // limit items per page
        $limit = \Config::get('tantien.limit');
        $drugOrder = DrugOrder::paginate(10);

        return $this->view('ajax.list', compact('drugOrder'));
    }
}
