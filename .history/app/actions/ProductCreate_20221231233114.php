<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductCreate{

    public function handle(array $data):User
    {
        DB::beginTransaction();
        $slug = Str::slug($data['detail']);
        $products = Product::create([
            'name'=>$data['name'],
            'detail'=>$data['detail'],
            'slug'=>$slug,
            'price'=>$data['price'],
        ]);

        $proposition = auth()->user()->propositions()->create([
            'content' => $request->content,
          ]);


        DB::commit();
        return $products;
    }
}
