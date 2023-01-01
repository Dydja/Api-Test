<?php

namespace App\Actions;

use App\Models\Product;

class ProductDelete{

    public function execute(Product $product):bool
    {
        $product->destroy;
        return true;
    }
}
