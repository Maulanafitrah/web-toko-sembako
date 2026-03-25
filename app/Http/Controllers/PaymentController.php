<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    // Fungsi CreateToken Midtrans dihapus karena diganti QRIS Statis di Blade

    public function prosesBayarManual(Request $request)
    {
        $nama = $request->nama ?? 'Pelanggan';
        $telp = $request->no_telp ?? '08xxxxxxxxxx';
        $metode = $request->metode_pembayaran; // 'transfer' atau 'cod'
        $total_bayar = 0;
        $daftar_produk = "";

        // 1. Logika Pengambilan Data Produk (Beli Sekarang vs Keranjang)
        if ($request->has('produk_id')) {
            $product = DB::table('products')->where('id', $request->produk_id)->first();
            if ($product) {
                $total_bayar = $product->harga;
                $daftar_produk = $product->nama . " (1x)";
            }
        } else {
            $cart = session()->get('cart', []);
            foreach ($cart as $details) {
                $total_bayar += $details['harga'] * $details['quantity'];
                $daftar_produk .= $details['nama'] . " (" . $details['quantity'] . "x), ";
            }
            session()->forget('cart'); 
        }

        // 2. Logika Upload Bukti Transfer (Hanya jika bukan COD)
        $imageName = null;
        if ($metode === 'transfer') {
            if (!$request->hasFile('bukti_transfer')) {
                return back()->with('error', 'Bukti transfer wajib diunggah untuk metode transfer.');
            }
            $imageName = time() . '_' . $request->bukti_transfer->getClientOriginalName();
            $request->bukti_transfer->move(public_path('images'), $imageName);
        }

        try {
            // 3. Simpan ke Database
            $order_prefix = ($metode === 'cod') ? 'COD-' : 'QRIS-';
            $order_id = $order_prefix . strtoupper(uniqid());

            DB::table('orders')->insert([
                'order_id' => $order_id,
                'produk' => rtrim($daftar_produk, ', '),
                'nama_pembeli' => $nama,
                'no_telp' => $telp,
                'total_bayar' => $total_bayar,
                'metode_pembayaran' => $metode,
                'status' => 'pending',
                'bukti_transfer' => $imageName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 4. Format WhatsApp Admin
            $labelMetode = ($metode === 'cod') ? "BAYAR DI TEMPAT (COD)" : "TRANSFER QRIS";
            $instruksi = ($metode === 'cod') 
                ? "Pesanan ini COD, mohon segera disiapkan untuk pengiriman." 
                : "Saya sudah mengirimkan bukti transfer melalui sistem.";

            $urlWa = "https://wa.me/6285694769479?text=" . urlencode(
                "Halo LARAS HANDAYANI,\n" .
                "Saya konfirmasi pesanan baru ($labelMetode).\n\n" .
                "ID Order: $order_id\n" .
                "Nama: $nama\n" .
                "Produk: " . rtrim($daftar_produk, ', ') . "\n" .
                "Total: Rp " . number_format($total_bayar, 0, ',', '.') . "\n\n" .
                $instruksi
            );

            return redirect()->away($urlWa);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    // --- Fungsi Admin Dashboard dengan Statistik Laporan Terintegrasi ---
    public function dashboard() 
    { 
        // Data Dasar
        $orders = DB::table('orders')->orderBy('created_at', 'desc')->get(); 
        $products = DB::table('products')->orderBy('id', 'desc')->get(); 

        // Hitung Statistik Penjualan (Hanya yang Status 'success')
        $total_pendapatan = DB::table('orders')->where('status', 'success')->sum('total_bayar');
        $jumlah_pesanan = DB::table('orders')->where('status', 'success')->count();
        
        // Statistik per Metode
        $pendapatan_qris = DB::table('orders')
                            ->where('status', 'success')
                            ->where('metode_pembayaran', 'transfer')
                            ->sum('total_bayar');
                            
        $pendapatan_cod = DB::table('orders')
                            ->where('status', 'success')
                            ->where('metode_pembayaran', 'cod')
                            ->sum('total_bayar');

        // Kirim semua variabel ke satu view dashboard
        return view('admin_dashboard', compact(
            'orders', 
            'products', 
            'total_pendapatan', 
            'jumlah_pesanan', 
            'pendapatan_qris', 
            'pendapatan_cod'
        )); 
    }
    
    public function setujuiPesanan($order_id) { 
        DB::table('orders')->where('order_id', $order_id)->update([
            'status' => 'success',
            'updated_at' => now()
        ]); 
        return back()->with('success', 'Pesanan berhasil disetujui!'); 
    }
    
    public function hapusPesanan($order_id) { 
        DB::table('orders')->where('order_id', $order_id)->delete(); 
        return back()->with('success', 'Pesanan telah dihapus.'); 
    }

    public function tambahProduk(Request $request) { 
        $imageName = time().'_'.$request->image->getClientOriginalName(); 
        $request->image->move(public_path('images'), $imageName); 
        DB::table('products')->insert([
            'nama' => $request->nama, 
            'harga' => $request->harga, 
            'stok' => $request->stok, 
            'kategori' => $request->kategori, 
            'deskripsi' => $request->deskripsi, 
            'image' => $imageName, 
            'gambar' => $imageName, 
            'created_at' => now()
        ]); 
        return back()->with('success', 'Produk berhasil ditambah!'); 
    }

    public function updateProduk(Request $request, $id) { 
        $data = ['nama' => $request->nama, 'harga' => $request->harga]; 
        if ($request->hasFile('image')) { 
            $img = time() . "_" . $request->file('image')->getClientOriginalName(); 
            $request->file('image')->move(public_path('images'), $img); 
            $data['image'] = $img; 
        } 
        DB::table('products')->where('id', $id)->update($data); 
        return back()->with('success', 'Produk berhasil diupdate!'); 
    }

    public function hapusProduk($id) { 
        DB::table('products')->where('id', $id)->delete(); 
        return back()->with('success', 'Produk berhasil dihapus.'); 
    }
}