<?php

namespace App\Http\Controllers\Agent\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $folders = collect(Storage::disk('public')->allDirectories('gdd/'.$user->id))->map([$this, 'toArray']);

        return view('admin.account.documents.index', compact('user', 'folders'));
    }

    public function toArray(string $file): array
    {
        $path = explode('/', trim($file, '/'));
        $dirname = array_pop($path);
        return [
            // use the filepath as an ID
            'id' => $file,
            'name' => $dirname,
            'parent' => implode('/', $path) ?: null,
        ];
    }
}
