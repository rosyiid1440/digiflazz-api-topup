<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;

Class Digiflazz
{
    protected static $endpoint = 'https://api.digiflazz.com/v1';

    protected static function sign($request, $prod = false)
    {
        if ($prod) {
            $config = config('digiflazz.prod_key');
        } else {
            $config = config('digiflazz.dev_key');
        }

        return md5(config('digiflazz.username') . $config . $request);
    }

    public static function generateRefId()
    {
        return IdGenerator::generate([
            'table' => 'transactions',
            'field' => 'ref_id',
            'length' => 12,
            'prefix' => 'TRX-',
        ]);
    }

    public static function getAllProduct()
    {
        $response = Http::accept('application/json')
            ->post(self::$endpoint . "/price-list", [
                'cmd' => 'prepaid',
                'username' => config('digiflazz.username'),
                'sign' => self::sign('pricelist'),
            ]);

        return $response->json('data');
    }

    public static function getSaldo()
    {
        $response = Http::accept('application/json')
        ->post(self::$endpoint . "/cek-saldo", [
            'cmd' => 'deposit',
            'username' => config('digiflazz.username'),
            'sign' => self::sign('depo',true),
        ]);

        return $response->json('data');
    }

    public static function topup($attributes)
    {
        $attributes['testing'] = true; // testing
        $attributes['username'] = config('digiflazz.username');
        $attributes['sign'] = self::sign($attributes['ref_id']);

        $response = Http::post(self::$endpoint . "/transaction", $attributes);

        return $response->json('data');
    }

    public static function deposit($attributes)
    {
        $attributes['username'] = config('digiflazz.username');
        $attributes['sign'] = self::sign('deposit',true);

        $response = Http::post(self::$endpoint . "/deposit", $attributes);

        return $response->json('data');
    }

    public static function cekTagihan($attributes)
    {
        $attributes['commands'] = "inq-pasca";
        $attributes['username'] = config('digiflazz.username');
        $attributes['sign'] = self::sign($attributes['ref_id']);
        $attributes['testing'] = true;

        $response = Http::post(self::$endpoint . "/transaction", $attributes);

        return $response->json('data');
    }

    public static function bayarPasca($attributes)
    {
        $attributes['commands'] = "pay-pasca";
        $attributes['testing'] = true;
        $attributes['username'] = config('digiflazz.username');
        $attributes['sign'] = self::sign($attributes['ref_id']);

        $response = Http::post(self::$endpoint . "/transaction", $attributes);

        return $response->json('data');
    }

    public static function cekStatusPasca($attributes)
    {
        $attributes['commands'] = "status-pasca";
        $attributes['username'] = config('digiflazz.username');
        $attributes['sign'] = self::sign($attributes['ref_id']);

        $response = Http::post(self::$endpoint . "/transaction", $attributes);

        return $response->json('data');
    }

    public static function validasiPln($attributes)
    {
        $attributes['commands'] = "pln-subscribe";

        $response = Http::post(self::$endpoint . "/transaction", $attributes);

        return $response->json('data');
    }
}

?>
