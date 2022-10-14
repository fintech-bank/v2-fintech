<?php

namespace App\Http\Controllers\Admin\Configuration;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\TypeVersion;
use App\Models\Core\Version;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function index()
    {
        return view('admin.config.version.index', [
            'versions' => Version::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $version = Version::create([
                'name' => $request->get('name'),
                'content' => $request->get('content'),
                'publish' => $request->has('publish')
            ]);

            foreach (json_decode($request->get('types')) as $type) {
                $ty = TypeVersion::where('name', 'LIKE', '%'.$type->value.'%')->first();

                $version->types()->attach($ty->id);
            }
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json($exception, 500);
        }

        return response()->json($version);
    }
}
