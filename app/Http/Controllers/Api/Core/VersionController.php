<?php

namespace App\Http\Controllers\Api\Core;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\TypeVersion;
use App\Models\Core\Version;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function getTypes()
    {
        return response()->json(TypeVersion::select('name')->get());
    }

    public function info($version_id)
    {
        return response()->json(Version::find($version_id)->load('types'));
    }

    public function update(Request $request, $version_id)
    {
        $version = Version::find($version_id);

        try {
            $version->update($request->except(['_token', 'types']));

            foreach ($version->types as $type) {
                $version->types()->detach($type->id);
            }

            foreach (json_decode($request->get('types')) as $type) {
                $version->types()->attach($type->id);
            }
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json($exception, 500);
        }

        return response()->json($version);
    }

    public function delete($version_id)
    {
        $version = Version::find($version_id);

        try {

            foreach ($version->types as $type) {
                $version->types()->detach($type->id);
            }

            $version->delete();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json($exception, 500);
        }

        return response()->json();
    }
}
