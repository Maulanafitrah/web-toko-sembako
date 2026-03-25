<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Toko 5758</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%); height: 100vh; display: flex; align-items: center; font-family: 'Segoe UI', sans-serif; }
        .login-card { border: none; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2); }
        .brand-icon { font-size: 50px; color: #0d47a1; margin-bottom: 15px; }
        .btn-login { background: #0d47a1; border: none; border-radius: 10px; padding: 12px; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card login-card p-4">
                <div class="text-center mb-4">
                    <div class="brand-icon"><i class="fas fa-user-shield"></i></div>
                    <h4 class="fw-bold">Admin Login</h4>
                </div>
                @if(session('error'))
                    <div class="alert alert-danger small">{{ session('error') }}</div>
                @endif
                <form action="/login-proses" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="username" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-login w-100">MASUK <i class="fas fa-sign-in-alt ms-2"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>