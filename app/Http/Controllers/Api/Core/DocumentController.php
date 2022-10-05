<?php

namespace App\Http\Controllers\Api\Core;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function upload(Request $request)
    {
        try {
            $request->file('file')->storeAs('/public/gdd/'.$request->get('customer_id').'/account/', $request->get('name').'.'.$request->file('file')->getClientOriginalExtension());
            return api()->ok();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return api()->error($exception->getMessage());
        }
    }
}
