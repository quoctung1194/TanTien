<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * Constructor
     *
     * @return void
     */
    public function index()
    {
        return $this->view('index');
    }
}
