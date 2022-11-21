<?php

namespace App\Helper;

use App\Models\Core\DocumentCategory;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerDocument;
use App\Services\Yousign\Document;
use App\Services\Yousign\Signature;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class DocumentFile
{
    /**
     * @param $name
     * @param $customer
     * @param $category_id
     * @param null $reference
     * @param bool $signable
     * @param bool $signed_by_client
     * @param bool $signed_by_bank
     * @param null $signed_at
     * @param bool $pdf
     * @param null $viewPdf
     * @return \Exception
     */
    public function createDocument($name, $customer, $category_id, $reference = null, $signable = false, $signed_by_client = false, $signed_by_bank = false, $signed_at = null, $pdf = true, $viewPdf = null)
    {
        try {
            $category = DocumentCategory::find($category_id);
            $document = $customer->documents()->create([
                'name' => $name,
                'reference' => $reference != null ? $reference : \Str::upper(\Str::random(10)),
                'signable' => $signable,
                'signed_by_client' => $signed_by_client,
                'signed_by_bank' => $signed_by_bank,
                'signed_at' => $signed_at,
                'customer_id' => $customer->id,
                'document_category_id' => $category_id,
            ]);
            if ($pdf == true) {
                $this->generatePDF(
                    $viewPdf,
                    $customer,
                    $document->id,
                    [],
                    false,
                    true,
                    public_path('/storage/gdd/' . $customer->user->id . '/documents/' . \Str::slug($category->name)),
                    false);
            }

            return $document;
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());

            return $exception;
        }
    }

    /**
     * @param $view
     * @param $customer
     * @param null $document_id
     * @param array $data
     * @param bool $download
     * @param bool $save
     * @param null $savePath
     * @param bool $stream
     * @param string $header_type
     * @return \Illuminate\Http\Response|null
     *
     * @throws \Exception
     */
    public function generatePDF($view, $customer, $document_id = null, $data = [], $download = false, $save = false, $savePath = null, $stream = true, $header_type = 'simple')
    {
        $agence = $customer->agency;
        $document = $document_id != null ? CustomerDocument::find($document_id) : null;
        $document_name = $document != null ? $document->name : 'Document';

        $pdf = PDF::loadView('pdf.' . $view, [
            'data' => (object)$data,
            'agence' => $agence,
            'document' => $document,
            'title' => $document != null ? $document->name : 'Document',
            'header_type' => $header_type,
            'customer' => $customer,
        ]);
        $pdf->setOptions([
            'enable-local-file-access' => true,
            'viewport-size' => '1280x1024',
            'footer-right' => '[page]/[topage]',
            'footer-font-size' => 8,
            'margin-left' => 0,
            'margin-right' => 0,
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        if ($download == true) {
            $pdf->download($document_name . ' - CUS' . $customer->user->identifiant . '.pdf');
        } else {
            return $pdf->stream($document_name . ' - CUS' . $customer->user->identifiant . '.pdf');
        }

        if ($save == true) {
            $pdf->save($savePath . '/' . $document_name . ' - CUS' . $customer->user->identifiant . '.pdf');
        } else {
            return $pdf->stream($document_name . ' - CUS' . $customer->user->identifiant . '.pdf');
        }

        if ($stream == true) {
            return $pdf->stream($document_name . ' - CUS' . $customer->user->identifiant . '.pdf');
        } else {
            return $pdf->render();
        }

        return null;
    }

    public function processSignableDocument($customer_id, $file, $page, $x, $y)
    {
        $documentApi = new Document();
        $signatureApi = new Signature();
        $customer = Customer::find($customer_id);

        try {
            $upload = $documentApi->uploadDocument($file, 'signable_document');
            $sign = $signatureApi->initiate($upload['id'], $customer, ['page' => $page, 'x' => $x, 'y' => $y]);
            $activate = $signatureApi->activate($sign->id);
        } catch (GuzzleException $e) {
            dd($e->getMessage());
        }


        return $activate;
    }

    /**
     * @param Customer $customer // Information Client
     * @param string $name // Nom format snake du document
     * @param string|null $nameless // Nom réel du document
     * @param int $category // Catégorie de document
     * @param string|null $reference // Référence du document
     * @param bool $signable
     * @param bool $signed_bank
     * @param bool $signed_client
     * @param bool $pdf
     * @param array $pdfData
     * @param string $headerType // simple / address
     * @return CustomerDocument|Model
     */
    public static function createDoc(
        Customer $customer,
        string $name,
        string $nameless = null,
        int $category = 3,
        string $reference = null,
        bool $signable = false,
        bool $signed_bank = false,
        bool $signed_client = false,
        bool $pdf = false,
        array $pdfData = [],
        string $provider = 'gdd',
        string $pathProvider = null,
        string $headerType = 'address'
    )
    {
        $categorie = DocumentCategory::find($category);
        $document = CustomerDocument::create([
            'name' => $nameless == null ? $name : $nameless,
            'reference' => $reference == null ? \Str::upper(\Str::random(8)) : $reference,
            'signable' => $signable,
            'signed_by_client' => $signed_client,
            'signed_by_bank' => $signed_bank,
            'signed_at' => $signable == true ? now() : null,
            'customer_id' => $customer->id,
            'document_category_id' => $category,
        ]);

        if ($pdf == true) {
            $pdf = Pdf::loadView('pdf.' . $name, [
                'customer' => $customer,
                'data' => (object)$pdfData,
                'agence' => $customer->agency,
                'title' => $nameless,
                'header_type' => $headerType,
                'document' => $document,
            ]);

            if($provider == 'gdd') {
                $pdf->save(\Storage::disk($provider)->putFile($customer->user->id.'/document/'.$categorie->slug, $nameless.'.pdf'));
            } else {
                $pdf->save(\Storage::disk($provider)->putFile($pathProvider, $nameless.'.pdf', $nameless.'.pdf'));
            }
        }

        return $document;
    }

    public static function getAllFiles($directory)
    {
        $files = \Storage::disk('public')->allFiles($directory);
        $arr = [];

        foreach ($files as $file) {
            $arr[] = $file;
        }

        return (object)$arr;
    }

    public static function getExtensionFileIcon($file)
    {
        $str = explode('.', $file);
        $s = $str[1];

        switch ($s) {
            case 'jpg' || 'png' || 'jpeg':
                return '<i class="fa-solid fa-file-image"></i>';
            case 'pdf':
                return '<i class="fa-solid fa-file-pdf"></i>';
            default:
                return '<i class="fa-solid fa-file"></i>';
        }
    }
}
