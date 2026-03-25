<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - Toko Sembako Hafila</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root { 
            /* Perubahan: Warna Hijau Sage dan Mint agar seragam */
            --primary: #7FB069; 
            --secondary: #ff5722; 
            --bg: #f2f7f0; 
            --text-dark: #2d3436;
        }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background: var(--bg); 
            margin: 0; 
            color: var(--text-dark);
        }

        header { 
            background: white; 
            padding: 15px 5%; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            position: sticky; 
            top: 0; 
            z-index: 1000; 
        }

        .brand { 
            font-weight: 700; 
            color: var(--primary); 
            text-decoration: none; 
            font-size: 20px; 
        }

        .container { 
            max-width: 900px; 
            margin: 40px auto; 
            padding: 20px; 
        }

        .detail-card { 
            background: white; 
            border-radius: 20px; 
            display: flex; 
            gap: 30px; 
            padding: 30px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
            border: 1px solid rgba(127, 176, 105, 0.1); /* Border halus warna sage */
        }

        .product-img { 
            width: 40%; 
            border-radius: 15px; 
            object-fit: contain; 
            background: #f9f9f9; 
        }

        .product-info { flex: 1; }

        .price { 
            font-size: 28px; 
            color: var(--primary); 
            font-weight: 700; 
            margin: 15px 0; 
        }

        .btn-checkout { 
            background: var(--secondary); 
            color: white; 
            border: none; 
            padding: 15px 30px; 
            border-radius: 12px; 
            font-weight: 600; 
            cursor: pointer; 
            width: 100%; 
            font-size: 16px; 
            transition: 0.3s; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 10px; 
        }

        .btn-checkout:hover { 
            background: #e64a19; 
            transform: translateY(-3px); 
            box-shadow: 0 5px 15px rgba(255, 87, 34, 0.3);
        }

        /* MODAL STYLING */
        .modal { 
            display: none; 
            position: fixed; 
            z-index: 2000; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            background: rgba(0,0,0,0.6); 
            align-items: center; 
            justify-content: center; 
            backdrop-filter: blur(4px); 
        }

        .modal-content { 
            background: white; 
            padding: 30px; 
            border-radius: 20px; 
            width: 90%; 
            max-width: 450px; 
            text-align: center; 
            max-height: 90vh; 
            overflow-y: auto; 
        }

        .btn-method { 
            padding: 15px; 
            border-radius: 12px; 
            font-weight: 700; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 10px; 
            width: 100%; 
            border: none; 
            cursor: pointer; 
            margin-bottom: 15px; 
            transition: 0.2s; 
        }

        .qris-box { 
            background: #fff; 
            border: 2px solid var(--bg); 
            border-radius: 15px; 
            padding: 15px; 
            margin-bottom: 15px; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.05); 
        }

        .bank-info-box { 
            background: var(--bg); 
            border: 1px dashed var(--primary); 
            border-radius: 12px; 
            padding: 15px; 
            margin-bottom: 15px; 
            text-align: left; 
        }

        .form-select-custom { 
            width: 100%; 
            padding: 10px; 
            border-radius: 8px; 
            border: 1px solid #ddd; 
            margin-bottom: 15px; 
            font-family: 'Poppins'; 
        }

        @media (max-width: 768px) {
            .detail-card { flex-direction: column; align-items: center; }
            .product-img { width: 80%; }
        }
    </style>
</head>
<body>

<header>
    <a href="{{ url('/') }}" class="brand">Toko Sembako Hafila</a>
    <a href="{{ url('/katalog') }}" style="text-decoration:none; color: #666; font-weight: 600;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</header>

<div class="container">
    <div class="detail-card">
        <img src="{{ asset('images/' . ($product->gambar ?? $product->image)) }}" class="product-img">
        <div class="product-info">
            <h1 style="margin: 0; color: var(--text-dark);">{{ $product->nama }}</h1>
            <div class="price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
            <p style="color: #666;">Stok: <strong style="color: var(--primary);">{{ $product->stok }}</strong></p>
            <p style="line-height: 1.6; color: #555;">{{ $product->deskripsi }}</p>
            <button class="btn-checkout" onclick="openModal()">
                <i class="fas fa-shopping-cart"></i> Beli Sekarang
            </button>
        </div>
    </div>
</div>

<div id="paymentModal" class="modal">
    <div class="modal-content">
        <h5 style="font-weight: 700; margin-bottom: 10px; color: var(--text-dark);">Metode Pembayaran</h5>
        <p style="color: #888; font-size: 14px; margin-bottom: 5px;">Total Tagihan:</p>
        <h3 style="color: var(--primary); font-weight: 700; margin-bottom: 20px;">Rp {{ number_format($product->harga, 0, ',', '.') }}</h3>

        <div class="qris-box">
            <p style="font-size: 12px; font-weight: 700; margin-bottom: 10px; color: var(--primary);">Scan QRIS Toko Hafila</p>
            <img src="{{ asset('images/qris_hafila.jpg') }}" style="max-width: 180px; border-radius: 10px; margin-bottom: 10px;" alt="QRIS">
            <br>
            <a href="{{ asset('images/qris_hafila.jpg') }}" download="QRIS_Toko_Hafila.jpg" style="text-decoration: none; font-size: 11px; color: #007bff; font-weight: 600;">
                <i class="fas fa-download"></i> Unduh Gambar QRIS
            </a>
        </div>

        <div style="font-size: 11px; color: #bbb; margin: 10px 0;">—— ATAU TRANSFER MANUAL ——</div>

        <div class="bank-info-box">
            <p style="margin-bottom: 5px; font-weight: 600; font-size: 13px; color: var(--primary);">
                <i class="fas fa-university"></i> Bank BCA
            </p>
            <p style="margin-bottom: 5px; color: var(--text-dark); font-weight: 700; font-size: 18px;">8760791823</p>
            <p style="margin-bottom: 0; font-size: 11px; color: #777;">A/N: LARAS HANDAYANI</p>
        </div>

        <form action="{{ route('payment.manual') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="produk_id" value="{{ $product->id }}">
            <input type="hidden" name="nama" value="Pembeli Beli Sekarang">
            <input type="hidden" name="total_akumulasi" value="{{ $product->harga }}">

            <div style="text-align: left; margin-bottom: 15px;">
                <label style="font-size: 12px; font-weight: 600; color: #555;">Pilih Opsi Pembayaran</label>
                <select name="metode_pembayaran" id="pilihMetode" class="form-select-custom" onchange="aturForm()" required>
                    <option value="transfer">Transfer (QRIS / Bank)</option>
                    <option value="cod">Bayar di Tempat (COD)</option>
                </select>
            </div>

            <div id="areaBukti" style="text-align: left; margin-bottom: 15px;">
                <label style="font-size: 12px; font-weight: 600; color: #555;">Upload Bukti Transfer</label>
                <input type="file" name="bukti_transfer" id="inputBukti" required style="width: 100%; font-size: 12px;">
            </div>

            <button type="submit" class="btn-method" style="background: var(--primary); color: white;">
                <i class="fab fa-whatsapp"></i> Konfirmasi Pesanan Ke WA
            </button>
        </form>
        
        <button onclick="closeModal()" style="background:none; border:none; color:#999; margin-top:5px; cursor:pointer; font-size: 13px;">Batal</button>
    </div>
</div>

<script>
    function openModal() { document.getElementById('paymentModal').style.display = 'flex'; }
    function closeModal() { document.getElementById('paymentModal').style.display = 'none'; }

    function aturForm() {
        const metode = document.getElementById('pilihMetode').value;
        const areaBukti = document.getElementById('areaBukti');
        const inputBukti = document.getElementById('inputBukti');

        if (metode === 'cod') {
            areaBukti.style.display = 'none';
            inputBukti.required = false;
        } else {
            areaBukti.style.display = 'block';
            inputBukti.required = true;
        }
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('paymentModal')) { closeModal(); }
    }
</script>
</body>
</html>