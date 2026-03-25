<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Toko Sembako Hafila</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root { 
            /* Perubahan: Menggunakan Mint Sage yang konsisten */
            --primary-color: #7FB069; 
            --bg-light: #f2f7f0; 
            --white: #ffffff; 
            --text-dark: #2d3436;
        }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: var(--bg-light); 
            margin: 0; 
            color: var(--text-dark);
        }

        header { 
            background: var(--white); 
            padding: 15px 5%; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }

        .brand-name { 
            font-size: 22px; 
            font-weight: 700; 
            color: var(--primary-color); 
            text-decoration: none; 
        }

        .container-custom { 
            max-width: 1000px; 
            margin: 40px auto; 
            padding: 30px; 
            background: white; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
            border: 1px solid rgba(127, 176, 105, 0.1);
        }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 15px; border-bottom: 2px solid var(--bg-light); color: #666; font-size: 14px; }
        td { padding: 15px; border-bottom: 1px solid #eee; vertical-align: middle; }
        
        .product-info { display: flex; align-items: center; gap: 15px; }
        .product-info img { width: 60px; height: 60px; object-fit: contain; background: #f9f9f9; border-radius: 10px; }
        
        .btn-remove { color: #dc3545; text-decoration: none; font-size: 14px; font-weight: 600; }
        .btn-remove:hover { text-decoration: underline; color: #a71d2a; }
        
        .cart-footer { 
            margin-top: 30px; 
            padding-top: 20px; 
            border-top: 2px solid var(--bg-light); 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }

        .total-price { font-size: 24px; font-weight: 700; color: var(--primary-color); }
        
        .btn-checkout { 
            background: var(--primary-color); 
            color: white; 
            padding: 15px 40px; 
            border-radius: 12px; 
            font-weight: 700; 
            transition: 0.3s; 
            border: none; 
            cursor: pointer; 
            text-decoration: none; 
        }
        .btn-checkout:hover { 
            background: #6a9657; 
            transform: translateY(-3px); 
            color: white; 
            box-shadow: 0 5px 15px rgba(127, 176, 105, 0.3);
        }

        .modal-content { border-radius: 20px; border: none; }
        .btn-method { padding: 12px; border-radius: 12px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.2s; border: none; text-decoration: none; }
        
        .qris-box { background: #fff; border: 2px solid var(--bg-light); border-radius: 15px; padding: 15px; margin-bottom: 15px; }
        .bank-info-box { background: var(--bg-light); border: 1px dashed var(--primary-color); border-radius: 12px; padding: 15px; margin-bottom: 15px; text-align: left; }
    </style>
</head>
<body>

@php 
    $totalAccumulated = 0; 
    $cart = session('cart', []);
    foreach($cart as $details) {
        $totalAccumulated += $details['harga'] * $details['quantity'];
    }
@endphp

<header>
    <a href="{{ url('/') }}" class="brand-name">Toko Sembako Hafila</a>
    <a href="{{ url('/katalog') }}" style="text-decoration: none; color: #666; font-weight: 600;">
        <i class="fas fa-arrow-left"></i> Kembali Belanja
    </a>
</header>

<div class="container container-custom">
    <h2 class="fw-bold" style="color: var(--text-dark);">Keranjang Belanja 🛒</h2>

    @if(count($cart) > 0)
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $details)
                        <tr>
                            <td>
                                <div class="product-info">
                                    <img src="{{ asset('images/' . $details['gambar']) }}" alt="{{ $details['nama'] }}">
                                    <div><div style="font-weight: 600; color: var(--text-dark);">{{ $details['nama'] }}</div></div>
                                </div>
                            </td>
                            <td>Rp {{ number_format($details['harga'], 0, ',', '.') }}</td>
                            <td>{{ $details['quantity'] }}x</td>
                            <td style="font-weight: 600; color: var(--primary-color);">Rp {{ number_format($details['harga'] * $details['quantity'], 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('cart.remove', $id) }}" class="btn-remove"><i class="fas fa-trash"></i> Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="cart-footer">
            <div>
                <span style="color: #888;">Total Pembayaran:</span>
                <div class="total-price">Rp {{ number_format($totalAccumulated, 0, ',', '.') }}</div>
            </div>
            <button type="button" class="btn-checkout" data-bs-toggle="modal" data-bs-target="#paymentModal">Bayar Sekarang</button>
        </div>
    @else
        <div class="text-center p-5">
            <i class="fas fa-shopping-basket fa-4x mb-3" style="color: var(--primary-color); opacity: 0.2;"></i>
            <p style="color: #666;">Keranjang kamu masih kosong nih.</p>
            <a href="{{ url('/katalog') }}" class="btn-checkout d-inline-block">Mulai Belanja</a>
        </div>
    @endif
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold text-center w-100" style="color: var(--text-dark);">Metode Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="text-muted mb-1">Total tagihan Anda:</p>
                <h3 class="fw-bold mb-4" style="color: var(--primary-color);">Rp {{ number_format($totalAccumulated, 0, ',', '.') }}</h3>
                
                <div class="qris-box shadow-sm">
                    <p class="small fw-bold mb-2" style="color: var(--primary-color);">Scan QRIS Toko Hafila</p>
                    <img src="{{ asset('images/qris_hafila.jpg') }}" class="img-fluid rounded mb-2" style="max-width: 200px;" alt="QRIS Toko Hafila">
                    <br>
                    <a href="{{ asset('images/qris_hafila.jpg') }}" download="QRIS_Toko_Hafila.jpg" class="btn btn-sm btn-outline-primary" style="border-color: var(--primary-color); color: var(--primary-color);">
                        <i class="fas fa-download me-1"></i> Unduh Gambar QRIS
                    </a>
                </div>

                <div class="text-muted small mb-3">—— ATAU TRANSFER MANUAL ——</div>

                <div class="bank-info-box">
                    <p class="mb-1"><strong><i class="fas fa-university me-2" style="color: var(--primary-color);"></i> Bank BCA</strong></p>
                    <p class="mb-1 fw-bold fs-5" style="color: var(--text-dark);">8760791823</p>
                    <p class="mb-0 small text-muted">A/N: LARAS HANDAYANI</p>
                </div>

                <form action="{{ route('payment.manual') }}" method="POST" id="form-manual" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="nama" value="Pembeli Web">
                    <input type="hidden" name="total_akumulasi" value="{{ $totalAccumulated }}">

                    <div class="mb-3 mt-2 text-start">
                        <label class="form-label small fw-bold" style="color: #555;">Pilih Opsi Pembayaran</label>
                        <select name="metode_pembayaran" id="metodePilih" class="form-select" onchange="toggleBukti()" required>
                            <option value="transfer">Transfer (QRIS / Bank)</option>
                            <option value="cod">Bayar di Tempat (COD)</option>
                        </select>
                    </div>

                    <div id="sectionBukti" class="mb-3 text-start">
                        <label class="form-label small fw-bold" style="color: #555;">Upload Bukti Transfer (Wajib Gambar)</label>
                        <input type="file" name="bukti_transfer" id="inputBukti" class="form-control" required>
                    </div>

                    <button type="submit" id="btn-konfirmasi-wa" class="btn btn-method w-100" style="background-color: var(--primary-color); color: white;">
                        <i class="fab fa-whatsapp"></i> Konfirmasi Pesanan ke WA
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleBukti() {
        const metode = document.getElementById('metodePilih').value;
        const section = document.getElementById('sectionBukti');
        const input = document.getElementById('inputBukti');

        if (metode === 'cod') {
            section.style.display = 'none';
            input.required = false;
        } else {
            section.style.display = 'block';
            input.required = true;
        }
    }

    document.getElementById('form-manual').onsubmit = function() {
        const modalElement = document.getElementById('paymentModal');
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
        }
        return true; 
    };

    window.onload = toggleBukti;
</script>
</body>
</html>