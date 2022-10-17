<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FoldersController extends Controller
{
    public function lists(Request $request)
    {
        $folders = collect(Storage::disk('public')
            ->allDirectories('gdd/'.$request->query->get('user_id')))
            ->map([$this, 'toArray']);

        return response()->json($folders);
    }

    public function toArray(string $file): array
    {
        $path = explode('/', trim($file, '/'));
        $dirname = array_pop($path);
        return [
            // use the filepath as an ID
            'id' => $file,
            'name' => Str::ucfirst($dirname),
            'parent' => implode('/', $path) ?: null,
        ];
    }
}
