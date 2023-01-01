<?php

namespace App\Actions;

use App\Models\Product;

class ProductUpdate{
    public function update(array $data,Product $product)
    {
        DB::beginTransaction();
        $product->update([
            'name'=>$data['name'],
            'detail'=>$data['detail']
        ]);

        DB::commit();
        return $product;
    }
}
