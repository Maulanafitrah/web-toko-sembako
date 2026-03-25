<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Toko 5758</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: linear-gradient(45deg, #1a237e, #0d47a1); box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .img-admin { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; border: 2px solid #eee; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#"><i class="fas fa-boxes me-2"></i> KELOLA PRODUK</a>
        <div class="d-flex">
            <a href="/admin/pesanan" class="btn btn-outline-light btn-sm me-2">Daftar Pesanan</a>
            <a href="/logout" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card p-4">
        <h4 class="fw-bold text-dark mb-4"><i class="fas fa-tags text-primary me-2"></i> Pengaturan Harga & Gambar</h4>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="150">GANTI GAMBAR</th>
                        <th>NAMA PRODUK</th>
                        <th>HARGA (RP)</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                    <tr>
                        <form action="/admin/produk/update/{{ $p->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <td>
                                <div class="text-center">
                                    <img src="{{ asset('images/'.$p->gambar) }}" class="img-admin mb-2">
                                    <input type="file" name="gambar" class="form-control form-control-sm">
                                </div>
                            </td>
                            <td><span class="fw-bold">{{ $p->nama }}</span></td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga" class="form-control fw-bold" value="{{ $p->harga }}" required>
                                </div>
                            </td>
                            <td class="text-center">
                                <button type="submit" class="btn btn-primary shadow-sm">
                                    <i class="fas fa-save me-1"></i> Update
                                </button>
                            </td>
                        </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>