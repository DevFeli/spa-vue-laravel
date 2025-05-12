<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Http\Controllers\Controller;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;
use App\Services\Products\ProductService;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::with('images')->orderBy('is_active', 'DESC')->paginate(10);
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $descriptionSanitize = Purifier::clean($request->input('description'), 'custom');

        $product = Products::create([
            'title' => $request->input('title'),
            'sale_price' => $request->input('sale_price'),
            'cost_price' => $request->input('cost_price'),
            'description' => $descriptionSanitize,
            'is_active' => true,
        ]);

        if ($request->file('images')) {
            ProductService::handleCreateImages($request->file('images'), $product->id);
        }

        return response()->json($product, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $product = Products::where('id', $request->id)->first();

        if ($product) {

            $descriptionSanitize = Purifier::clean($request->input('description'), 'custom');

            $product->update(
                [
                    'title' => $request->input('title'),
                    'sale_price' => $request->input('sale_price'),
                    'cost_price' => $request->input('cost_price'),
                    'description' => $descriptionSanitize,
                    'is_active' => true,
                ]
            );

            if ($request->file('images')) {
                ProductService::handleCreateImages($request->file('images'), $product->id);
            }
            return response()->json($product, 200);
        }
        return response()->json(['message' => 'Produto não encontrado'], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product = Products::where('id', $request->id)->first();

        if ($product) {
            $product->update(['is_active' => $request->is_active]);
            return response()->json($product, 200);
        }
        return response()->json(['message' => 'Produto não encontrado'], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        //
    }
}
