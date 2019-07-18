<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasirController extends Controller
{
    function index(){
    	return view('pages.kasir');
    }
}
