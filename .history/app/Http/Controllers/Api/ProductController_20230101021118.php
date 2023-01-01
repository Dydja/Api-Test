<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Actions\ProductCreate;
use App\Actions\ProductDelete;
use App\Actions\ProductUpdate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
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
        return $this->sendResponse(ProductResource::collection($product),"Liste des produits");
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
        $validator = Validator::make($request->all(), [
            'name'=>'required|string',
            'detail' => 'required|',

        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation echouées',$validator->errors());

        }

        $products = $productForm->handle($request->validated());
        $success['Produit'] = $products;

        return $this->sendResponse(new ProductResource($success),"Produit enregistré avec succès");
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $products =  Product::find($id);

        if (is_null($products)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(new ProductResource($products),"Détails du produits");
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
    public function update(Request $request,Product $product,ProductUpdate $productUpdate)
    {

        $validator = Validator::make($request->all(), [
            'name'=>'required|string',
            'detail' => 'required|',
            'price' => 'required|',

        ]);

        dd($validator)

        if($validator->fails())
        {
            return $this->sendError('Validation echouées',$validator->errors());

        }


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
        $action->execute($product);
        return $this->sendResponse("Produit Supprimé avec succès",$action);

    }
}
