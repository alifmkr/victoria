<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class CartController extends Controller
{
    public function index()
    {
        // Session::flush();

        $cartItems = Session::get("cart", []);
        if ($cartItems == []) {
            return response()->json([
                "success" => false,
                "message" => "Cart is Empty"
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Success to display " . count($cartItems) . " products",
            "cart" => Session::get("cart", [])
        ]);
    }

    public function store(Request $request)
    {
        $productId = $request->productId;
        $quantity = $request->quantity;

        $cartItems = Session::get("cart", []);

        if (isset($cartItems[$productId])) {
            $cartItems[$productId]["quantity"] += $quantity;
        } else {
            $cartItems[$productId] = array(
                "product_id" => $productId,
                "quantity" => number_format($quantity)
            );
        }

        Session::put("cart", $cartItems);

        return response()->json([
            "success" => true,
            "message" => "Product added to cart succesfully",
            "cart" => Session::get("cart", [])
        ]);
    }


    public function remove($id)
    {
        // Session::flush();
        $productId = $id;
        $cartItems = Session::get("cart", []);

        if (isset($cartItems[$productId])) {
            unset($cartItems[$productId]);

            Session::put("cart", $cartItems);

            return response()->json([
                "success" => true,
                "message" => "Product Removed in cart succesfully",
            ]);
        }

        return response()->json([
            "success" => false,
            "message" => "Failed to Remove the item in Cart"
        ]);
    }

    public function destroy()
    {
        Session::forget("cart");
    }
}
