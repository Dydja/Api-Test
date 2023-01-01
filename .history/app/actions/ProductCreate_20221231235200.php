<?php

namespace App\Actions;


use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductCreate{

    public function handle(array $data):Product
    {
        DB::beginTransaction();

        $slug = Str::slug($data['detail']);
        $products = auth()->user()->products()->create([
             'name'=>$data['name'],


        ]);

        DB::commit();
        return $products;
    }
}
