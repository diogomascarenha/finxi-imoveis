<?php

namespace FinxiImoveis\Http\Controllers\Backend;

use Illuminate\Http\Request;

use FinxiImoveis\Http\Requests;
use FinxiImoveis\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('backend.home.index');
    }
}
