<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function about()
    {
        return view('static.about');
    }

    public function contact()
    {
        return view('static.contact');
    }

    public function politique()
    {
        return view('static.politique');
    }
}