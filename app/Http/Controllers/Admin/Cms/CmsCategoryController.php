<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\CmsCategory;
use Illuminate\Http\Request;

class CmsCategoryController extends Controller
{
    public function index()
    {
        return view('admin.cms.category.index', [
            'categories' => CmsCategory::all()
        ]);
    }
}
