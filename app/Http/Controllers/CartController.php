<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
        }
        return view('cart', compact('cart', 'total'));
    }

    public function add($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $cart = session()->get('cart', []);

        // Jika produk sudah ada, tambah jumlahnya
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Jika belum ada, tambah ke keranjang
            $cart[$id] = [
                "nama" => $product->nama,
                "quantity" => 1,
                "harga" => $product->harga,
                "gambar" => $product->gambar // Sesuai kolom di DB
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk masuk keranjang!');
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
        }
    }

    public function remove($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Produk dihapus!');
    }
}