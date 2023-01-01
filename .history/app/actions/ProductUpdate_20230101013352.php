<?php

namespace App\Actions;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductUpdate{
    public function update(array $data,Product $product):Product
    {
        DB::beginTransaction();
        // $product->update([
        //     'name'=>$data['name'],
        //     'detail'=>$data['detail']
        // ]);

        $product = auth()->user()->products()->update([
            'name'=>$data['name'],
            'detail'=>$data['detail'],
            'price'=>$data['price'],
        ]);

        DB::commit();
        return $product;


    }
}
