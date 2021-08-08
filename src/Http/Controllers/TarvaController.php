<?php

namespace LaravelTarva\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TarvaController extends Controller
{
    public function home()
    {
        Inertia::setRootView('laravel-tarva::layout');
        return Inertia::render('Home');
    }

    public function login(Request $request)
    {
        Inertia::setRootView('laravel-tarva::layout');
        return Inertia::render('Login');
    }
}
