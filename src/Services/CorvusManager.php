<?php

namespace CoolCatCoder\Corvus\Services;

use Illuminate\Support\Carbon;
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
            'order_number' => $corvus->order_number,
            'store_id' => Config::get('corvus.store_id'),
            'currency_code' => $corvus->currencyCode,
            'timestamp' => Carbon::now()->format('yyyyMMddHHmmss'),
            'version' => Config::get('corvus.version'),
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