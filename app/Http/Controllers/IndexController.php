<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        return app()->version();
    }

    public function hello()
    {
        return 'Hello World!';
    }
}
