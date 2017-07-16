<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Drug;
use App\Unit;
use App\UnitPrice;
use App\SpecialPrice;

class UserController extends Controller
{
    /**
     * Index action
     *
     * @return void
     */
    public function index()
    {
        //echo \Illuminate\Support\Facades\Hash::make('password');
        if (!\Auth::check()) {
            return $this->view('login');
        }

        return redirect()->route('DO-index');
    }

    public function login(Request $request)
    {
        if (\Auth::attempt(['username' => $request->username, 'password' => $request->password]))
        {
            return redirect()->route('DO-index');
        }
        else 
        {
            return redirect()->route('LG');
        }
    }
}
