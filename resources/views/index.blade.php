<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - Toko Sembako Hafila</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            /* Perubahan: Warna Hijau Sage agar seragam dengan welcome page */
            --primary-color: #7FB069; 
            --secondary-color: #ff5722;
            /* Perubahan: Latar belakang Mint Sage yang segar */
            --bg-light: #f2f7f0; 
            --white: #ffffff;
            --text-dark: #2d3436;
        }

        body { 
            font-family: 'Poppins', sans-serif; 
            margin: 0; 
            background-color: var(--bg-light); 
            color: var(--text-dark);
        }

        header {
            background: var(--white);
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .katalog-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 25px;
        }

        .produk-card {
            background: var(--white);
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: 0.3s;
            border: 1px solid rgba(127, 176, 105, 0.1); /* Border halus warna sage */
            display: flex;
            flex-direction: column;
        }

        .produk-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(127, 176, 105, 0.2);
            border-color: var(--primary-color);
        }

        .produk-card img {
            width: 100%;
            height: 180px;
            object-fit: contain;
            margin-bottom: 15px;
            border-radius: 10px;
            background: #f9f9f9;
        }

        .badge-kategori {
            font-size: 11px;
            background: #e9ecef;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 10px;
            color: #666;
            text-transform: uppercase;
        }

        .price {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stock {
            font-size: 13px;
            color: #777;
            margin-bottom: 20px;
        }

        .card-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: auto;
        }

        .btn-cart {
            background-color: var(--white);
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 10px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
        }

        .btn-cart:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-buy-now {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 11px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .floating-cart {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--primary-color);
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            text-decoration: none;
            font-weight: 700;
            z-index: 9999;
            display: flex;
            align-items: center;
        }

        .cart-badge {
            background: red;
            color: white;
            font-size: 12px;
            padding: 2px 8px;
            border-radius: 50%;
            margin-left: 10px;
        }
    </style>
</head>
<body>

    <header>
        <a href="{{ url('/') }}" class="brand-name">Toko Sembako Hafila</a>
        <a href="{{ url('/cart') }}" style="text-decoration: none; color: #666; font-size: 14px;">
            <i class="fas fa-shopping-cart"></i> Keranjang
        </a>
    </header>

    <div class="container">
        <div class="nav-actions" style="margin-bottom: 20px;">
            <a href="{{ url('/') }}" style="display: inline-flex; align-items: center; background: var(--white); color: var(--text-dark); text-decoration: none; padding: 10px 20px; border-radius: 12px; font-weight: 600; border: 1px solid #ddd;">
                <span style="margin-right: 8px;">←</span> Kembali ke Menu Awal
            </a>
        </div>

        <h1 style="text-transform: uppercase; color: var(--primary-color);">
            KATALOG {{ request('kategori') ? request('kategori') : 'PRODUK' }}
        </h1>

        <div class="katalog-container">
            @forelse($products as $p)
                <div class="produk-card">
                    <img src="{{ asset('images/' . ($p->gambar ?? $p->image)) }}" alt="{{ $p->nama }}">
                    
                    <div><span class="badge-kategori">{{ $p->kategori }}</span></div>
                    
                    <h3 style="font-size: 18px; margin: 10px 0; height: 50px; overflow: hidden;">{{ $p->nama }}</h3>
                    <div class="price">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                    <div class="stock">Stok: {{ $p->stok }}</div>
                    
                    <div class="card-actions">
                        <form action="{{ route('cart.add', $p->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-cart">
                                <i class="fas fa-cart-plus"></i> + Keranjang
                            </button>
                        </form>

                        <a href="{{ url('/produk/' . $p->id) }}" class="btn-buy-now">
                            <i class="fas fa-shopping-bag"></i> Beli Sekarang
                        </a>
                    </div>

                    <a href="{{ url('/produk/' . $p->id) }}" style="font-size: 12px; color: #888; text-decoration: none; margin-top: 10px;">Lihat Detail</a>
                </div>
            @empty
                <div style="grid-column: 1 / -1; padding: 50px; background: var(--white); border-radius: 15px; text-align: center; color: #666;">
                    <p>Maaf, produk untuk kategori "{{ request('kategori') }}" belum tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>

    @if(session('cart') && count(session('cart')) > 0)
        <a href="{{ url('/cart') }}" class="floating-cart">
            <i class="fas fa-shopping-basket"></i>
            <span>Lihat Keranjang</span>
            <span class="cart-badge">{{ count(session('cart')) }}</span>
        </a>
    @endif

</body>
</html>