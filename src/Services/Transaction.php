<?php

namespace CoolCatCoder\Corvus\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class Transaction
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }
    public function checkTransactionStatus(array $bodyData)
    {
        return $this->makeRequest($bodyData, Config::get('corvus.status'));
    }

    private function makeRequest($requestBody, $endpoint)
    {            Log::error('makeRequest');

        try{
            $response =  $this->client->request('POST', $endpoint, [
                'headers' => ['Content-type: application/x-www-form-urlencoded'],
                'json' => $requestBody,
                'connect_timeout' => 650,
                'cert' => storage_path('cert/CorvusPay.crt.pem'),
                'ssl_key' => storage_path('cert/CorvusPay.key.pem'),
                'timeout' => 20,
            ]);
            $xml = simplexml_load_string($response->getBody(),'SimpleXMLElement',LIBXML_NOCDATA);

            return json_encode($xml);
        }catch (ClientException $e) {
            $response = $e->getResponse();
            Log::error('Exception');
            Log::error(json_encode($response));
            throw $e;
        }
    }
    public function createPostSignature(array $formData = []): string
    {
        ksort($formData);
        return $this->createHashSignature($formData);
    }

    public function createApiRequestSignature(array $formData = []): string
    {
        return $this->createHashSignature($formData);
    }

    private function createHashSignature(array $formData = [])
    {
        $signatureData = '';

        foreach($formData as $key => $value) {
            $signatureData .= $key.$value;
        }

        return hash_hmac('sha256', $signatureData, Config::get('corvus.api_key'));
    }
}
