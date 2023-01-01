<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductCreate{

    public function handle(array $data):User
    {
        DB::beginTransaction();

        $products = Product::create([
            'name'=>$data['name'],
            'detail'=>$data['detail'],
            'user_id'=>$data['user_id']
        ]);

        DB::commit();
        return $products;
    }
}
