<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use Session;
use App\Models\Product;
use App\Models\TransactionDetails;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transactions::all();
        $transactionDetails = TransactionDetails::all();
        $products = Product::all();

        return view("transactions", [
            "transactions" => $transactions,
            "transaction_details" => $transactionDetails,
            "products" => $products
        ]);
    }

    // public function store(Request $request)
    // {
    //     $cartItems = Session::get("cart", []);
    //     $cartIds = array_keys($cartItems);
    //     $products = Product::whereIn("id", $cartIds)->get();
    //     $total = 0;


    //     foreach ($products as $key => $value) {
    //         $price = $value["price"];
    //         $quantity = $cartItems[$value['id']]["quantity"];
    //         $total += $price * $quantity;

    //         // get last id in transactions
    //         $transactionLastInput = Transactions::all()->last();
    //         $transactionLastInputId = ($transactionLastInput == null ? 0 : $transactionLastInput["id"]); // akan menghasilkan 0

    //         $transactionDetail = new TransactionDetails;
    //         $transactionDetail->transaction_id = $transactionLastInputId + 1; // 0 + 1 = 1
    //         $transactionDetail->product_id = $value["id"];
    //         $transactionDetail->quantity = $quantity;
    //         $transactionDetail->save();
    //     }

    //     // store data to transactions table
    //     $transaction = new Transactions;
    //     $transaction->user_id = $request->user_id;

    //     if ($request->email != "") {
    //         $transaction->email = $request->email;
    //     }

    //     $transaction->total = $total;
    //     $transaction->save();

    //     Session::forget("cart");

    //     // send email
    //     Mail::to($request->email)->send(new InvoiceMail());

    //     return response()->json([
    //         "success" => true,
    //         "message" => "Successfully Checkout",
    //         "products" => $products,
    //         "trsctnLast" => $transactionLastInput["id"],
    //         "transactions" => Transactions::all(),
    //         "transaction_details" => TransactionDetails::all(),
    //         "total" => $total,
    //         "cart" => $cartItems,
    //         "email" => $request->email
    //     ]);
    // }

    public function store(Request $request)
{
    // Mendapatkan semua item yang ada di cart
    $cartItems = Session::get("cart", []);
    $cartIds = array_keys($cartItems);
    
    // Ambil data produk yang diperlukan dengan satu query
    $products = Product::whereIn('id', $cartIds)->get()->keyBy('id');
    $total = 0;
    $transactionId = null;

    // Mulai transaksi database untuk memastikan atomik
    // DB::beginTransaction();

    try {
        // Menyimpan transaksi
        $transaction = new Transactions;
        $transaction->user_id = $request->user_id;
        $transaction->email = $request->email ?: null;
        $transaction->total = $total;
        $transaction->save();
        $transactionId = $transaction->id; // Ambil ID transaksi yang baru saja dibuat

        // Iterasi melalui produk di cart dan simpan detail transaksi
        foreach ($cartItems as $productId => $cartItem) {
            $product = $products->get($productId);

            // Hitung total harga
            $quantity = $cartItem['quantity'];
            $total += $product->price * $quantity;

            // Simpan detail transaksi
            $transactionDetail = new TransactionDetails;
            $transactionDetail->transaction_id = $transactionId;
            $transactionDetail->product_id = $productId;
            $transactionDetail->quantity = $quantity;
            $transactionDetail->save();

            // Kurangi stok produk setelah checkout
            $product->decrement('stock', $quantity);
        }

        // Update total transaksi setelah semua detail transaksi disimpan
        $transaction->total = $total;
        $transaction->save();

        // Hapus semua item di cart setelah transaksi berhasil
        Session::forget('cart');

        // Kirim email konfirmasi
        Mail::to($request->email)->send(new InvoiceMail());

        // Commit transaksi
        // DB::commit();

        // Kembalikan response sukses
        return response()->json([
            "success" => true,
            "message" => "Successfully Checkout",
            "products" => $products,
            "transaction" => $transaction,
            "transaction_details" => $transaction->details,
            "total" => $total,
            "cart" => $cartItems,
            "email" => $request->email
        ]);
    } catch (\Exception $e) {
        // Rollback jika ada error
        // DB::rollback();
        return response()->json([
            "success" => false,
            "message" => "Checkout failed: " . $e->getMessage()
        ], 500);
    }
}


    public function destroy($id)
    {

    }

    public function downloadInvoice($id)
    {

    }
}
