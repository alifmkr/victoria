<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function showInventory()
{
    // Ambil data inventory dari database (misalnya menggunakan model Inventory)
    $inventory = Inventory::all();  // atau query yang sesuai

    // Kirim data ke view
    return view('inventory', compact('inventory'));
}

    //
}
