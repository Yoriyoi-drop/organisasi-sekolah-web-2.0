<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verifikasi Email</title>
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body class="d-flex align-items-center min-vh-100 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <h4 class="mb-3">Verifikasi Email</h4>
            @if (session('status'))
              <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <p>Kami telah mengirim link verifikasi ke email Anda. Jika belum menerima, klik tombol di bawah untuk mengirim ulang.</p>
            <form method="POST" action="{{ route('verification.send') }}">
              @csrf
              <button type="submit" class="btn btn-primary">Kirim Ulang Email Verifikasi</button>
            </form>
            <hr>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
              @csrf
              <button type="submit" class="btn btn-outline-secondary">Keluar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
