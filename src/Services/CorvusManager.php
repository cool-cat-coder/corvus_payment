<?php

namespace CoolCatCoder\Corvus\Services;

use Illuminate\Support\Facades\Config;

class CorvusManager
{
    private $transaction;

    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    public function getTransactionStatus(array $data)
    {

        $corvus = Corvus::make($data);

        $transactionData = [
            'order_number' => $data['order_number'],
            'store_id' => Config::get('corvus.store_id'),
            'currency_code' => '191',
            'timestamp' => '201302041605',
            'version' => 1.2,
        ];
        $signature = $this->transaction->createApiRequestSignature($transactionData);
        return $this->transaction->checkTransactionStatus(array_merge($transactionData,['hash' => $signature] ));
    }

    public function preparePostData($data = []) :array
    {
        $corvus = Corvus::make($data);
        $corvus->store_id = Config::get('corvus.store_id');
        $corvus->version = Config::get('corvus.version');
        $corvus->require_complete = Config::get('corvus.require_complete');
        $formData = $corvus->toArray();

        return array_merge($formData, ['signature' => $this->transaction->createPostSignature($formData)]);
    }
}