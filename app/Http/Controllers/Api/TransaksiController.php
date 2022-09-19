<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\Digiflazz;
use App\Helpers\Repsonse;

class TransaksiController extends Controller
{
    public function topup(Request $request)
    {
        $buyer_sku_code = $request->buyer_sku_code;
        $customer_no = $request->customer_no;
        $ref_id = 'TRX-'.Carbon::now()->format('Ymd').$customer_no;
        return Digiflazz::topup([
            'buyer_sku_code' => $buyer_sku_code,
            'customer_no' => $customer_no,
            'ref_id' => $ref_id
        ]);
    }
}
