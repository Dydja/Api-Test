<?php

namespace App\Actions;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

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
