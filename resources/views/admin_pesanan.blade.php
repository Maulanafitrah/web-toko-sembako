<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Toko 5758</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: linear-gradient(45deg, #1a237e, #0d47a1); }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .img-preview { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; cursor: pointer; transition: 0.2s; }
        .img-preview:hover { transform: scale(1.1); }
        
        /* Badge Status Custom */
        .badge-pending { background-color: #fff3cd; color: #856404; }
        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-cod { background-color: #e1f5fe; color: #01579b; border: 1px solid #b3e5fc; }
        .badge-transfer { background-color: #f3e5f5; color: #4a148c; border: 1px solid #e1bee7; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#"><i class="fas fa-store me-2"></i> TOKO 5758 ADMIN</a>
        <div class="d-flex">
            <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm me-2">Ke Toko</a>
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-light btn-sm me-2">Dashboard</a>
        </div>
    </div>
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card p-4">
        <h4 class="fw-bold mb-4"><i class="fas fa-clipboard-list text-primary me-2"></i> Pesanan Masuk</h4>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>PRODUK</th>
                        <th>PEMBELI</th>
                        <th class="text-center">METODE</th>
                        <th class="text-center">BUKTI</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $o)
                    <tr>
                        <td>
                            <strong style="font-size: 0.9rem;">{{ $o->produk }}</strong><br>
                            <small class="text-success fw-bold">Rp{{ number_format($o->total_bayar, 0, ',', '.') }}</small>
                        </td>
                        <td>
                            {{ $o->nama_pembeli }}<br>
                            <small class="text-muted"><i class="fab fa-whatsapp"></i> {{ $o->no_telp ?? '-' }}</small>
                        </td>
                        <td class="text-center">
                            @if($o->metode_pembayaran == 'cod')
                                <span class="badge badge-cod px-3 py-2">COD</span>
                            @else
                                <span class="badge badge-transfer px-3 py-2">TRANSFER / QRIS</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($o->bukti_transfer)
                                <a href="{{ asset('images/'.$o->bukti_transfer) }}" target="_blank">
                                    <img src="{{ asset('images/'.$o->bukti_transfer) }}" class="img-preview" title="Klik untuk memperbesar">
                                </a>
                            @else
                                <small class="text-muted italic">Tidak Ada (COD)</small>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge badge-{{ $o->status }} px-3 py-2">
                                {{ strtoupper($o->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                @if($o->status != 'success')
                                    <form action="{{ url('/admin/pesanan/setujui/'.$o->order_id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success btn-sm" title="Setujui Pesanan"><i class="fas fa-check"></i></button>
                                    </form>
                                @endif
                                <form action="{{ url('/admin/pesanan/hapus/'.$o->order_id) }}" method="POST" onsubmit="return confirm('Hapus pesanan ini?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5 text-muted">Belum ada pesanan masuk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>