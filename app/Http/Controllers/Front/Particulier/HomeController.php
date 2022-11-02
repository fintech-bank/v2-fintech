<?php

namespace App\Http\Controllers\Front\Particulier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('front.part.home');
    }
}
