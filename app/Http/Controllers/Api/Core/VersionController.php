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

    public function info($versionId)
    {
        return response()->json(Version::find($versionId)->load('types'));
    }

    public function update(Request $request, $versionId)
    {
        $version = Version::find($versionId);

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

    public function delete($versionId)
    {
        $version = Version::find($versionId);

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
