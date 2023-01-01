<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Actions\ProductCreate;
use App\Actions\ProductDelete;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $product = Product::orderBy('created_at','desc')->get();
        return $this->sendResponse("Liste des produits",$product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request,ProductCreate $productForm)
    {
        //
        $validator = Validator::make($request->all);

        if($validator->fails())
        {
            return $this->sendError("Enregistrement échoué",$validator->errors());
        }

        $products = $productForm->handle(array_merge($request->except("_token"),['user_id'=>Auth()->user()->id]));
        $success['Produit'] = $products;

        return $this->sendResponse($success,"Produit enregistré avec succès");
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        $products =  Product::find($product);
        return $this->sendResponse("Détails du produits",$products);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,ProductDelete $action)
    {
        //
        $action = $productDestroy->execute($product);
        return $this->sendResponse("Produit Supprimé avec succès",$action);

    }
}
