<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Core\LogBanque;
use Illuminate\Http\Request;

class LogBanqueController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.system.logbanque.index', [
            'logs' => LogBanque::orderBy('created_at', 'desc')->get()
        ]);
    }
}
