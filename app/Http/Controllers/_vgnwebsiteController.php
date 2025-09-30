<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;

class vgnwebsiteController extends Controller
{
    public function index(){
        return view('vgnwebsite');
    }
}
