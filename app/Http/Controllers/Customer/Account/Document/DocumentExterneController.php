<?php

namespace App\Http\Controllers\Customer\Account\Document;

use App\Http\Controllers\Controller;
use function Sodium\crypto_box_publickey_from_secretkey;

class DocumentExterneController extends Controller
{
    public function index()
    {
        return view('customer.account.document.external.index');
    }
}
