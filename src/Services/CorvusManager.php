<?php


namespace CoolCatCoder\Corvus\Services;


use Illuminate\Support\Facades\Config;

class CorvusManager
{
    public function preparePostData($data = []) :array
    {
        $corvus = Corvus::make($data);
        $corvus->store_id = Config::get('corvus.store_id');
        $corvus->version = Config::get('corvus.version');
        $corvus->require_complete = Config::get('corvus.require_complete');
        $formData = $corvus->toArray();
        ksort($formData);

        return array_merge($formData, ['signature' => $this->createSignature($formData)]);
    }

    private function createSignature(array $formData = []): string
    {
        $signatureData = '';

        foreach($formData as $key => $value) {
            $signatureData .= $key.$value;
        }
        return hash_hmac('sha256', $signatureData, Config::get('corvus.api_key'));
    }
}