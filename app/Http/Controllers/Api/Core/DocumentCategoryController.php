<?php

namespace App\Http\Controllers\Api\Core;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\DocumentCategory;
use Illuminate\Http\Request;

class DocumentCategoryController extends Controller
{
    public function info($category_id)
    {
        $category = DocumentCategory::find($category_id);

        return response()->json($category);
    }

    public function update(Request $request, $category_id)
    {
        $category = DocumentCategory::find($category_id);

        try {
            $category->update($request->all());
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json(null, 500);
        }

        return response()->json($category);
    }

    public function delete($category_id)
    {
        $category = DocumentCategory::find($category_id);

        try {
            $category->delete();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json(null, 500);
        }

        return response()->json();
    }
}
