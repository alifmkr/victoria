<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pos.index', compact('products'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Insufficient stock.');
        }

        $transaction = Transaction::create([
            'product_name' => $product->name,
            'quantity' => $request->quantity,
            'price' => $product->price,
            'total' => $product->price * $request->quantity
        ]);

        $product->update([
            'stock' => $product->stock - $request->quantity
        ]);

        return back()->with('success', 'Product added to cart.');
    }

    public function checkout(){
        $transactions = Transaction::all();
        $total = $transactions->sum('total');

        Transaction::truncate(); //Clear cart

        return back()->with('success', "Transaction completed. Total Rp {$total}");
    }
}
