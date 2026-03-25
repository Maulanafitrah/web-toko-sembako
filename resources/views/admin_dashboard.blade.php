<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Toko Sembako 5 7 5 8</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .sidebar { min-height: 100vh; background: #28a745; color: white; padding: 20px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .status-success { color: #28a745; font-weight: bold; }
        .status-pending { color: #ffc107; font-weight: bold; }
        .status-failed { color: #dc3545; font-weight: bold; }
        .img-admin { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 1px solid #ddd; }
        .nav-link:hover { background: rgba(255,255,255,0.1); border-radius: 8px; }
        .card-laporan { background: linear-gradient(45deg, #1e7e34, #28a745); color: white; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar d-none d-md-block text-center">
            <h4 class="mb-4">Admin Panel</h4>
            <ul class="nav flex-column text-start">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/" class="nav-link text-white">
                        <i class="fas fa-store me-2"></i> Lihat Toko
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <a href="{{ route('logout') }}" class="nav-link text-white">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Kelola Toko Sembako 5758</h2>
                <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
                    <i class="fas fa-plus me-2"></i> Tambah Produk
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card card-laporan p-3 shadow-sm h-100">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-money-bill-wave fa-2x opacity-50 me-3"></i>
                            <div>
                                <small class="opacity-75">Total Pendapatan (Sukses)</small>
                                <h4 class="fw-bold mb-0">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-white p-3 shadow-sm h-100 border-start border-success border-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shopping-cart fa-2x text-success opacity-25 me-3"></i>
                            <div>
                                <small class="text-muted">Pesanan Selesai</small>
                                <h4 class="fw-bold mb-0 text-dark">{{ $jumlah_pesanan }} Transaksi</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-white p-3 shadow-sm h-100">
                        <div class="row text-center align-items-center h-100">
                            <div class="col-6 border-end">
                                <small class="text-muted d-block">QRIS/Transfer</small>
                                <span class="fw-bold text-success">Rp {{ number_format($pendapatan_qris, 0, ',', '.') }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">COD</small>
                                <span class="fw-bold text-primary">Rp {{ number_format($pendapatan_cod, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white font-weight-bold py-3">
                    <i class="fas fa-list me-2 text-success"></i> Daftar Pesanan Terbaru
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID Order</th>
                                <th>Pembeli</th>
                                <th>Produk</th>
                                <th>Total</th>
                                <th>Bukti</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $o)
                            <tr>
                                <td><small class="text-muted">{{ $o->order_id }}</small></td>
                                <td>
                                    <strong>{{ $o->nama_pembeli }}</strong><br>
                                    <small class="text-muted">{{ $o->no_telp ?? '-' }}</small>
                                </td>
                                <td>{{ $o->produk }}</td>
                                <td>Rp {{ number_format($o->total_bayar, 0, ',', '.') }}</td>
                                <td>
                                    @if($o->bukti_transfer)
                                        <img src="{{ asset('images/' . $o->bukti_transfer) }}" 
                                             class="img-admin" 
                                             data-bs-toggle="modal" 
                                             data-bs-target="#modalBukti{{ $o->id }}"
                                             alt="Bukti">
                                    @else
                                        <span class="text-muted small">COD / Tidak ada</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-{{ $o->status }}">{{ strtoupper($o->status) }}</span>
                                </td>
                                <td>
                                    @if($o->status == 'pending')
                                    <form action="{{ route('admin.setujui', $o->order_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success">Setujui</button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.hapus', $o->order_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pesanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm text-danger border-0"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white font-weight-bold py-3">
                    <i class="fas fa-box me-2 text-success"></i> Stok Produk
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $p)
                            <tr>
                                <td><img src="{{ asset('images/' . ($p->gambar ?? $p->image)) }}" class="img-admin"></td>
                                <td>{{ $p->nama }}</td>
                                <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                                <td>{{ $p->stok }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-warning me-2 text-white" data-bs-toggle="modal" data-bs-target="#modalEditProduk{{ $p->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.produk.hapus', $p->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.produk.tambah') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Nama Produk</label><input type="text" name="nama" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Kategori</label><input type="text" name="kategori" class="form-control" required></div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Harga</label><input type="number" name="harga" class="form-control" required></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Stok</label><input type="number" name="stok" class="form-control" required></div>
                </div>
                <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control"></textarea></div>
                <div class="mb-3"><label class="form-label">Foto Produk</label><input type="file" name="image" class="form-control" required></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success w-100">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>

@foreach($products as $p)
<div class="modal fade" id="modalEditProduk{{ $p->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.produk.update', $p->id) }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit Produk: {{ $p->nama }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama" class="form-control" value="{{ $p->nama }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" value="{{ $p->harga }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" value="{{ $p->stok }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="{{ $p->kategori }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ganti Foto (Opsional)</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@foreach($orders as $o)
    @if($o->bukti_transfer)
    <div class="modal fade" id="modalBukti{{ $o->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bukti Transfer - {{ $o->nama_pembeli }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('images/' . $o->bukti_transfer) }}" class="img-fluid rounded" alt="Bukti Full">
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>