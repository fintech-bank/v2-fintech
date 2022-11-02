<?php

namespace App\Http\Controllers\Admin\Configuration;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\DocumentCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.config.category.index', [
            'categories' => DocumentCategory::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $category = DocumentCategory::create([
                'name' => $request->get('name')
            ]);
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json(null, 500);
        }

        return response()->json($category);
    }

}
