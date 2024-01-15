<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::select('products.id', 'category_id', 'products.name AS product_name', 'quantity', 'categories.name AS category_name')->join('categories', 'categories.id', '=', 'products.category_id')->get();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validate = Validator::make(
            $request->all(),
            [
                'category_id' => ['required'],
                'name' => ['required'],
                'quantity' => ['required'],
            ]
        );
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }
        if ($request->id != null) {
            $product = Product::findOrFail($request->id);
        } else {
            $product = new Product();
        }
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->quantity = $request->quantity;
        try {
            $product->save();
            return response()->json(['success' => 'data saved successfully']);
        } catch (\Throwable $th) {
            return response()->json(['db' => 'product failed to save']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if ($product == null) {
            return response()->json(['errors' => ['data' => 'data was not found or an internet error occurred']]);
        }
        return response()->json(['result' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product == null) {
            return response()->json(['errors' => ['data' => 'data was not found or an internet error occurred']]);
        }
        try {
            $product->delete();
            return response()->json(['success' => 'product deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['data' => 'product failed to delete']]);
        }
    }
}
