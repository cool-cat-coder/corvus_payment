<?php
namespace CoolCatCoder\Corvus\Services;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 *
 * @property float $amount
 * @property string $currency
 * @property string $order_number
 * @property string $language
 * @property string $cardholder_name
 * @property string $cardholder_surname
 * @property string $cardholder_address
 * @property string $cardholder_city
 * @property string $cardholder_zip_code
 * @property string $cart
 * @property string $require_complete
 * @property string $subscription
 * @property int $store_id
 * @property string $version

 */
class Corvus extends Model
{
    const allowedCodesAndCurrencies = [
        '826' => 'GBP', '840' => 'USD', '978' => 'EUR',
        '208' => 'DKK', '578' => 'NOK', '752' => 'SEK',
        '756' => 'CHF', '124' => 'CAD', '348' => 'HUF' ,
        '048' => 'BHD' , '036' => 'AUD', '643' => 'RUB',
        '985' => 'PLN' , '946' => 'RON', '191' => 'HRK',
        '200' => 'CZK' , '352' => 'ISK' , '977' => 'BAM',
        '941' => 'RSD'
    ];

    protected $fillable = [
        'amount',
        'currency',
        'currencyCode',
        'cardholder_name',
        'cardholder_surname',
        'cardholder_address',
        'cardholder_city',
        'cardholder_zip_code',
        'cardholder_email',
        'cart',
        'language',
        'order_number',
        'store_id',
        'subscription',
        'version',
        'require_complete',
    ];

    public function setCurrencyAttribute($currency = 'USD')
    {
        $allowedCurrency = array_values($this->getCodeAnCurrency($currency));
        if (!$allowedCurrency) {
            throw new Exception('Currency is not supported by Corvus.');
        }
        $this->attributes['currency'] = $allowedCurrency[0];
    }

    public function setCurrencyCodeAttribute($currency = 'USD')
    {
        $allowedCurrency = array_keys($this->getCodeAnCurrency($currency));
        if (!$allowedCurrency) {
            throw new Exception('Currency is not supported by Corvus.');
        }
        $this->attributes['currencyCode'] = $allowedCurrency[0];
    }

    private function getCodeAnCurrency( string $currency): array
    {
        return array_filter(self::allowedCodesAndCurrencies, function($codeAndCurrency) use ($currency) {
            if($codeAndCurrency===$currency) return $codeAndCurrency;
        });
    }
}
