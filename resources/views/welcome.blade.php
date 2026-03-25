<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Sembako Hafila</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            /* Warna Hijau Sage yang lebih dalam untuk brand */
            --primary-color: #7FB069; 
            /* Warna latar belakang: Mint Sage yang sangat lembut dan segar */
            --bg-light: #f2f7f0; 
            --text-dark: #2d3436;
            --white: #ffffff;
            --promo-orange: #ff7675;
            --promo-blue: #74b9ff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        /* --- Header --- */
        .top-header {
            background-color: var(--white);
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .store-logo-text {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }

        /* --- Hero Section --- */
        .hero-section {
            /* Gradasi lembut agar terlihat lebih premium */
            background: linear-gradient(180deg, var(--white) 0%, var(--bg-light) 100%);
            padding: 80px 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .hero-content {
            flex: 1;
            max-width: 600px;
            padding-right: 40px;
        }

        .hero-content h1 {
            font-size: 48px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0 0 20px 0;
            line-height: 1.2;
        }

        .hero-content p {
            font-size: 18px;
            color: #636e72;
            margin: 0;
            font-weight: 300;
        }

        .hero-image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-store-image {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        }

        /* --- Promo Carousel Styling --- */
        .carousel-wrapper {
            max-width: 1200px;
            margin: 20px auto 50px auto;
            padding: 0 20px;
        }

        .promo-banner {
            height: 300px;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .bg-promo-1 { background: linear-gradient(135deg, #7FB069, #5d8e48); }
        .bg-promo-2 { background: linear-gradient(135deg, #ff7675, #d63031); }
        .bg-promo-3 { background: linear-gradient(135deg, #74b9ff, #0984e3); }

        .promo-banner h2 { font-size: 42px; font-weight: 700; margin-bottom: 10px; }
        .promo-banner p { font-size: 20px; margin-bottom: 20px; }
        .promo-btn {
            background: white;
            color: var(--text-dark);
            padding: 10px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .promo-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* --- Main Container --- */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 60px 20px;
            text-align: center;
        }

        .section-title {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 40px;
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background-color: var(--primary-color);
            margin: 10px auto 0 auto;
            border-radius: 2px;
        }

        /* --- Grid Kategori --- */
        .kategori-grid {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        .kategori-card {
            background-color: var(--white);
            border-radius: 15px;
            width: 220px;
            padding: 25px;
            text-decoration: none;
            color: var(--text-dark);
            box-shadow: 0 5px 20px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 1px solid rgba(127, 176, 105, 0.1);
        }

        .kategori-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(127, 176, 105, 0.15);
            border-color: var(--primary-color);
        }

        .card-icon-container {
            width: 150px;
            height: 150px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .kategori-card img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .kategori-card p {
            font-weight: 600;
            font-size: 18px;
            margin: 0;
        }

        /* --- Footer Section --- */
        footer {
            /* Footer dibuat sedikit lebih gelap agar terlihat rapi sebagai penutup */
            background-color: #e8f0e5; 
            padding: 60px 20px 30px 20px;
            text-align: center;
            border-top: 1px solid rgba(0,0,0,0.05);
            color: #555;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-store-name {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .footer-address {
            font-size: 14px;
            color: #636e72;
            line-height: 1.6;
            max-width: 500px;
            margin: 0 auto 25px auto;
        }

        .footer-bottom {
            border-top: 1px solid rgba(0,0,0,0.05);
            padding-top: 20px;
            font-size: 13px;
            color: #999;
        }

        .admin-link {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s;
        }

        .admin-link:hover {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .hero-section { flex-direction: column; text-align: center; padding: 40px 20px; }
            .hero-content { padding-right: 0; margin-bottom: 30px; }
            .promo-banner h2 { font-size: 28px; }
            .kategori-card { width: calc(50% - 15px); }
        }
    </style>
</head>
<body>

    <header class="top-header">
        <a href="{{ url('/') }}" class="store-logo-text">Toko Sembako Hafila</a>
    </header>

    <section class="hero-section">
        <div class="hero-content">
            <h1>Selamat Datang</h1>
            <p>Solusi mudah dan cepat untuk memenuhi kebutuhan pokok harian keluarga Anda.</p>
        </div>
        
        <div class="hero-image-container">
            <img src="{{ asset('images/coba1.jpg') }}" alt="Toko Sembako Hafila" class="hero-store-image">
        </div>
    </section>

    <div class="carousel-wrapper">
        <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3500">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="promo-banner bg-promo-1">
                        <h2>GRATIS ONGKIR!</h2>
                        <p>Khusus pengiriman area sekitar toko dengan minimal belanja Rp 50.000</p>
                        <a href="{{ url('/katalog') }}" class="promo-btn">Belanja Sekarang</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="promo-banner bg-promo-2">
                        <h2>DISKON BERAS JUMAT</h2>
                        <p>Dapatkan potongan harga khusus untuk setiap pembelian beras 5kg & 10kg</p>
                        <a href="{{ url('/katalog?kategori=beras') }}" class="promo-btn">Cek Beras</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="promo-banner bg-promo-3">
                        <h2>PAKET SEMBAKO HEMAT</h2>
                        <p>Lebih hemat dengan paket Minyak + Telur + Beras mulai dari Rp 85.000</p>
                        <a href="{{ url('/katalog') }}" class="promo-btn">Lihat Paket</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <main class="main-container">
        <h2 class="section-title">Pilih Kategori Produk</h2>
        
        <div class="kategori-grid">
            <a href="{{ url('/katalog?kategori=beras') }}" class="kategori-card">
                <div class="card-icon-container">
                    <img src="{{ asset('images/Beras fortune.webp') }}" alt="Beras">
                </div>
                <p>Beras</p>
            </a>

            <a href="{{ url('/katalog?kategori=telur') }}" class="kategori-card">
                <div class="card-icon-container">
                    <img src="{{ asset('images/telur ayam negeri.jpg') }}" alt="Telur Ayam">
                </div>
                <p>Telur Ayam</p>
            </a>

            <a href="{{ url('/katalog?kategori=Air Mineral') }}" class="kategori-card">
                <div class="card-icon-container">
                    <img src="{{ asset('images/Vit Galon.jpg') }}" alt="Air Mineral">
                </div>
                <p>Air Mineral</p>
            </a>

            <a href="{{ url('/katalog?kategori=minyak') }}" class="kategori-card">
                <div class="card-icon-container">
                    <img src="{{ asset('images/minyak bimoli.jpg') }}" alt="Minyak Goreng">
                </div>
                <p>Minyak Goreng</p>
            </a>
            
            <a href="{{ url('/katalog') }}" class="kategori-card">
                <div class="card-icon-container">
                    <div style="font-size: 60px;">🛒</div>
                </div>
                <p>Semua Produk</p>
            </a>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-store-name">Toko Sembako Hafila</div>
            <p class="footer-address">
                Jl. Blk. I No.16, Simpangan, Kec. Cikarang Utara,<br>
                Kabupaten Bekasi, Jawa Barat 17530
            </p>

            <div class="footer-bottom">
                <p>&copy; 2026 Toko Sembako Hafila. Hak Cipta Dilindungi.</p>
                <p><a href="{{ url('/login') }}" class="admin-link">Masuk sebagai Admin</a></p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>