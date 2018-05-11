<?php

namespace App\Http\Controllers;

use App\Support\Json;

class IndexController extends Controller
{
    public function index()
    {
        return response()->json(['version' => app()->version()], 200);
    }
}
