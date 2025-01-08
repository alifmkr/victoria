<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // get all data product
    public function index()
    {
        $products = Product::all();

        if (isset($products)) {
            return response()->json([
                "success" => true,
                "message" => "Found " . $products->count() . " products",
                "data" => $products
            ]);
        }

        return response()->json([
            "success" => false,
            "message" => "Product Not Found"
        ], 404);
    }

    // strore data products
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => 'required|string|max:255',
            "price" => 'required|numeric|min:0',
            "stock" => 'required|integer|min:0'
        ]);

        $product = Product::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "Successfully stored data",
            "data" => $product
        ], 201);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            "name" => 'sometimes|required|string|max:255',
            "price" => 'sometimes|required|numeric|min:0',
            "stock" => 'sometimes|required|integer|min:0'
        ]);

        $product = Product::findOrFail($request->id);
        $product->update($validated);

        return response()->json([
            "success" => true,
            "message" => "successfully updated"
        ]);
    }

    // Delete 1 row data products
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json([
            "success" => true,
            "message" => "Successfully deleted",
            "id" => $id
        ]);
    }

    // Get 1 row data products
    public function getProduct($id)
    {
        $product = Product::find($id);
        if (isset($product)) {
            return response()->json([
                "success" => true,
                "message" => "Product Founded",
                "data" => $product
            ], 200);
        }
        return response()->json([
            "success" => false,
            "message" => "Product not found"
        ], 404);
    }

    public function getProducts()
    {
        $products = Product::all();

        if (isset($products)) {
            return response()->json([
                "success" => true,
                "message" => "Found " . $products->count() . " products",
                "data" => $products
            ]);
        }

        return response()->json([
            "success" => false,
            "message" => "Product Not Found"
        ], 404);
    }
}
