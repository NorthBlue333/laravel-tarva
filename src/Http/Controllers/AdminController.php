<?php

namespace LaravelAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function home()
    {
        Inertia::setRootView('laravel-admin::layout');
        return Inertia::render('Home');
    }

    public function login(Request $request)
    {
        Inertia::setRootView('laravel-admin::layout');
        return Inertia::render('Login')->withViewData('pageTitle', 'Connexion');
    }
}
