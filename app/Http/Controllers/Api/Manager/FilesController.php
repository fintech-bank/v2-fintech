<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function lists(Request $request)
    {
        $customer = Customer::find($request->get('customer'));
        $folder = $request->query->get('folder');
        $files = $customer->documents()->where('document_category_id', $folder)->with('category')->get();

        return response()->json($files);
    }

    public function store(UploadFileRequest $request)
    {
        $file = $request->file('file');
        $folder = $request->post('folder');
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $path = $file->storeAs($folder, $filename . '_' . $file->hashName());
        return $this->toArray($path);
    }

    public function delete(string $file)
    {
        Storage::disk()->delete($file);
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function toArray(CustomerDocument $document): array
    {

    }
}
