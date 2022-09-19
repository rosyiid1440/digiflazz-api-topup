<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Digiflazz;
use App\Helpers\Response;
use Str;

class KategoriController extends Controller
{
    public function index()
    {
        $data = collect(Digiflazz::getAllProduct());

        $grouped = $data->groupBy('category');

        $response = $grouped->keys()->map(function($item){
            return [
                'nama_kategori' => $item,
                'slug' => Str::slug($item),
            ];
        });

        return Response::status('success')
        ->result($response);
    }

    public function brand($slug)
    {
        $data = collect(Digiflazz::getAllProduct());

        $grouped = $data->groupBy(function ($item, $key) {
            return Str::slug($item['category']);
        });

        $response = $grouped->get($slug)->groupBy('brand')->keys()->map(function($item){
            return [
                'nama_brand' => $item,
                'slug' => Str::slug($item),
            ];
        });

        return Response::status('success')
        ->result($response);
    }

    public function produk($slugkategori,$slug)
    {
        $data = collect(Digiflazz::getAllProduct());

        $grouped = $data->groupBy(function ($item, $key) {
            return Str::slug($item['category']);
        });

        $produk = $grouped->get($slugkategori)->groupBy(function ($item, $key) {
            return Str::slug($item['brand']);
        });

        return $produk->get($slug);
    }
}
