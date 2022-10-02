<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{

    public function Main(Request $request)
    {
        return view('main');
    }

    public function GetInfo(Request $request)
    {
        
        include_once base_path().'/amoCRM/get_info.php';
        echo '<script type="text/javascript">';
        echo ' alert("The data has been exported to the database")';
        echo '</script>';
        return view('main');
    }

    public function GetToken(Request $request)
    {
        
        include_once base_path().'/amoCRM/get_token.php';
    }
}
