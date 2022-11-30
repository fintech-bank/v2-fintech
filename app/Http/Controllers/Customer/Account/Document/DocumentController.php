<?php

namespace App\Http\Controllers\Customer\Account\Document;

use App\Http\Controllers\Controller;
use App\Models\Core\DocumentCategory;
use App\Models\Customer\Customer;

class DocumentController extends Controller
{
    public function index()
    {
        return view('customer.account.document.index', [
            'customer' => auth()->user()->customers
        ]);
    }

    public function category($category_id)
    {
        $documents = Customer::find(auth()->user()->customers->id)->documents()->where('document_category_id', $category_id)->get();
        $category = DocumentCategory::find($category_id);

        return view('customer.account.document.category', [
            'documents' => $documents,
            'cat' => $category
        ]);
    }
}
