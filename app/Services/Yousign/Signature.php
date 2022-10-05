<?php


namespace App\Services\Yousign;


use App\Models\Customer\Customer;

class Signature extends YousignApi
{
    public function initiate($document_id,Customer $customer, array $data)
    {
        $response = $this->client->request('POST', $this->endpoint.'/signature_requests', [
            'body' => '{"documents":["'.$document_id.'"],"signers":[{"info":{"first_name":"'.$customer->info->firstname.'","last_name":"'.$customer->info->lastname.'","email":"'.$customer->user->email.'","phone_number":"'.$customer->info->mobile.'","locale":"fr"},"fields":[{"type":"signature","document_id":"'.$document_id.'","page":'.$data['page'].',"x":'.$data['x'].',"y":'.$data['y'].'}],"signature_level":"electronic_signature","signature_authentication_mode":"no_otp"}],"name":"Signature","delivery_mode":"none"}',
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer '.$this->api_key,
                'content-type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function lists($status = null) {
        $response = $this->client->request('GET', $this->endpoint.'/signature_requests?status='.$status, [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer '.$this->api_key,
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function fetch($signature_id) {
        $response = $this->client->request('GET', $this->endpoint.'/signature_requests/'.$signature_id, [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer '.$this->api_key,
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $signature_id
     * @param $data || name/delivery_mode(none,email)/ordered_signers/expiration_date
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update($signature_id, $data) {

        $response = $this->client->request('PATCH', $this->endpoint.'/signature_requests/'.$signature_id, [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer '.$this->api_key,
            ],
            'body' => json_decode($data)
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $signature_id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($signature_id) {

        $response = $this->client->request('DELETE', $this->endpoint.'/signature_requests/'.$signature_id, [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer '.$this->api_key,
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $signature_id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function activate($signature_id) {

        $response = $this->client->request('POST', $this->endpoint.'/signature_requests/'.$signature_id.'/activate', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer '.$this->api_key,
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $signature_id
     * @param $data || reason/custom_note
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancel($signature_id, $data) {

        $response = $this->client->request('POST', $this->endpoint.'/signature_requests/'.$signature_id.'/cancel', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer '.$this->api_key,
                'content-type' => 'application/json',
            ],
            'body' => json_encode($data)
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $signature_id
     * @param $signerId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendReminder($signature_id, $signerId) {

        $response = $this->client->request('POST', $this->endpoint.'/signature_requests/'.$signature_id.'/signers/'.$signerId.'/send_reminder', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer '.$this->api_key,
                'content-type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $signature_id
     * @param $data || expiration_date
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function reactivate($signature_id, $data) {

        $response = $this->client->request('POST', $this->endpoint.'/signature_requests/'.$signature_id.'/reactivate', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer '.$this->api_key,
                'content-type' => 'application/json',
            ],
            'body' => json_encode($data)
        ]);

        return json_decode($response->getBody()->getContents());
    }
    public function auditTrails($signature_id) {

        $response = $this->client->request('GET', $this->endpoint.'/signature_requests/'.$signature_id.'/audit_trails/download', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer '.$this->api_key,
                'content-type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }


}
