<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        // Obtenemos los productos con su dueño
        $products = Product::with('user')->latest()->get();
        return view('tienda', compact('products'));
    }

  public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'required',
            'price' => 'required|numeric'
        ]);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back();
    }
}