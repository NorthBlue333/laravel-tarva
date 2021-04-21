<?php

namespace LaravelAdmin\Http\Controllers;

class AdminController extends Controller
{
    public function home()
    {
        return view('laravel-admin::home');
    }
}
