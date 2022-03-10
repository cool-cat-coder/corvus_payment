<?php

namespace Corvus\Services;

use \Illuminate\Support\Facades\Config;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class CorvusRequest
{

    public function getEndpoint()
    {
        return Config::get('corvus.endpoint');
    }

    public function makeRequest($data)
    {
        $client = new Client();
        $result = $client->post($this->getEndpoint(), ['form_params' => $data]);

        // Validate if response is equal 200
        if (200 != $result->getStatusCode()) {
            throw new ClientException('The response is '.$result->getStatusCode());
        }

        // Convert json response into object
        return \GuzzleHttp\json_decode($result->getBody()->getContents());
    }

}