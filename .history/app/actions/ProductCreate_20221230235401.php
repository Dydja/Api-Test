<?php

namespace App\Actions;

class ProductCreate{

    public function handle(array $data):User
    {
        DB::beginTransaction();

        $products = Product::create([
            'name'=>$data['name'],
            'detail'=>$data['detail'],
            'user_id'=>$data['user_id']
        ])
    }
}
