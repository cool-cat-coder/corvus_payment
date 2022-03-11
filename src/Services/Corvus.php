<?php
namespace CoolCatCoder\Corvus\Services;


use Exception;
use \Illuminate\Support\Facades\Config;

class Corvus
{

    protected $accessToken;
    protected $currency;

    const allowedCurrencies = [
        'GBP', 'USD', 'EUR',
        'DKK', 'NOK', 'SEK',
        'CHF', 'CAD', 'HUF',
        'BHD', 'AUD', 'RUB',
        'PLN', 'RON', 'HRK',
        'CZK', 'ISK', 'BAM',
        'RSD'
    ];

    public function __construct()
    {
        $this->client = new CorvusRequest();

    }

    public function setCorvusCheckout ( array $data = [])
    {
        $this->setCurrency($data);
        $this->post = [
            'amount'       => $data['total'],
            'cardholder_address'           => $data['cardholder_address'],
            'cardholder_city' => $data['cardholder_city'],
            'cardholder_email'  => $data['cardholder_email'],
            'cardholder_name'          => $data['cardholder_name'],
            'cardholder_surname'        => $data['cardholder_surname'],
            'cardholder_zip_code'   => $data['cardholder_zip'],
            'cart'                      => $data['cart_description'],
            'currency'                      => $this->getCurrency(),
            'language'                      => $data['language'],
            'order_number'                      => $data['order_number'],
            'require_complete'                      => $data['require_complete'],
            'store_id'                      => Config::get('corvus.store_id'),
            'subscription'                      => $data['subscription'],
            'version'                      => Config::get('corvus.version'),
        ];

        return $this->client->makeRequest($this->post);
    }

    public function setCurrency($currency = 'USD')
    {
        if (!in_array($currency, self::allowedCurrencies, true)) {
            throw new Exception('Currency is not supported by Corvus.');
        }

        $this->currency = $currency;
    }

    public function getCurrency() :string
    {
        return $this->currency;
    }
}