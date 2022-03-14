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
    const allowedCurrencies = [
        'GBP', 'USD', 'EUR',
        'DKK', 'NOK', 'SEK',
        'CHF', 'CAD', 'HUF',
        'BHD', 'AUD', 'RUB',
        'PLN', 'RON', 'HRK',
        'CZK', 'ISK', 'BAM',
        'RSD'
    ];
    protected $fillable = [
        'amount',
        'currency',
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
        if (!in_array($currency, self::allowedCurrencies, true)) {
            throw new Exception('Currency is not supported by Corvus.');
        }
        $this->attributes['currency'] = $currency;
    }
}
