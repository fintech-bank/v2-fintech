<?php


namespace App\Services\Yousign;


use Illuminate\Support\Facades\Storage;

class Document extends YousignApi
{
    /**
     * @param string $sign_id
     * @param string $file
     * @param string $nature
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function attachDocumentToSignRequest(string $sign_id, string $file, string $nature)
    {
        $response = $this->client->request('POST', $this->endpoint . '/signature_requests/' . $sign_id . '/documents', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer ' . $this->api_key,
                'content-type' => 'application/json',
            ],
            'multipart' => [
                [
                    'name' => 'file',
                    'filename' => $file,
                    'contents' => 'data:application/pdf;name=' . $file . ';base64,' . base64_encode(Storage::disk('public')->get($file)),
                    'headers' => [
                        'Content-Type' => 'application/pdf'
                    ]
                ],
                [
                    'name' => 'nature',
                    'contents' => $nature
                ],
                [
                    'name' => 'parse_anchors',
                    'contents' => 'true'
                ]
            ],
        ]);


        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $sign_id
     * @param string|null $nature
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listDocumentToSignRequest(string $sign_id, string $nature = null)
    {
        $response = $this->client->request('POST', $this->endpoint . '/signature_requests/' . $sign_id . '/documents?nature=' . $nature, [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer ' . $this->api_key,
                'content-type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $sign_id
     * @param string $document_id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDocument(string $sign_id, string $document_id)
    {
        $response = $this->client->request('POST', $this->endpoint . '/signature_requests/' . $sign_id . '/documents/' . $document_id, [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer ' . $this->api_key,
                'content-type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $sign_id
     * @param string $document_id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteDocument(string $sign_id, string $document_id)
    {
        $response = $this->client->request('DELETE', $this->endpoint . '/signature_requests/' . $sign_id . '/documents/' . $document_id, [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer ' . $this->api_key,
                'content-type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $sign_id
     * @param string $document_id
     * @param array $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateDocument(string $sign_id, string $document_id, array $data)
    {
        $response = $this->client->request('PATCH', $this->endpoint . '/signature_requests/' . $sign_id . '/documents/' . $document_id, [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer ' . $this->api_key,
                'content-type' => 'application/json',
            ],
            'body' => json_encode($data)
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $sign_id
     * @param string $document_id
     * @param string $file
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function replaceDocument(string $sign_id, string $document_id, string $file)
    {
        $response = $this->client->request('POST', $this->endpoint . '/signature_requests/' . $sign_id . '/documents/' . $document_id . '/replace', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer ' . $this->api_key,
                'content-type' => 'application/json',
            ],
            'multipart' => [
                [
                    'name' => 'file',
                    'filename' => $file,
                    'contents' => 'data:application/pdf;name=' . $file . ';base64,' . base64_encode(Storage::disk('public')->get($file)),
                    'headers' => [
                        'Content-Type' => 'application/pdf'
                    ]
                ]
            ]
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $sign_id
     * @param bool $archive
     * @param string $version
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function downloadDocument(string $sign_id, bool $archive, string $version = null)
    {
        $response = $this->client->request('POST', $this->endpoint . '/signature_requests/' . $sign_id . '/documents/download?version=' . $version . '&archive=' . $archive, [
            'headers' => [
                'accept' => 'application/zip, application/pdf',
                'authorization' => 'Bearer ' . $this->api_key,
                'content-type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $file
     * @param string $nature
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadDocument(string $file, string $nature)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->endpoint . '/documents',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => array(
                'file' => new \CURLFile(public_path('/storage/'.$file), 'application/pdf'),
                'nature' => $nature,
                'parse_anchors' => 'true'
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->api_key
            ),
        ));

        $document = curl_exec($curl);
        return json_decode($document, true);
    }

}
