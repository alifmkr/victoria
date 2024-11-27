<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $cartItems = Session::get("cart", []);
        return view('pos.index')->with("products", $products)->with("cart", $cartItems);
    }
}
