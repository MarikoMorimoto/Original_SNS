<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index(){
        return view('about.index');
    }

    public function rule(){
        return view('about.rule');
    }

    public function privacy(){
        return view('about.privacy');
    }
}
