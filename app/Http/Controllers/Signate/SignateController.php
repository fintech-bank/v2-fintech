<?php

namespace App\Http\Controllers\Signate;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerDocument;
use Illuminate\Http\Request;

class SignateController extends Controller
{
    public function show($token)
    {
        $token_d = base64_decode($token);
        $document = CustomerDocument::find($token_d);
        dd($document);
    }
}
