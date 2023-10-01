<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    function index()
    {
        $menus = Menu::all();
        return response()->json([
            'status' => 'success',
            'data'   => $menus
        ], 200);
    }
}
