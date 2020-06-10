<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($_COOKIE['orchid_description'])){
            return view('pages/homepage');
        }else{
            return redirect()->to('/');
        }
    }
}