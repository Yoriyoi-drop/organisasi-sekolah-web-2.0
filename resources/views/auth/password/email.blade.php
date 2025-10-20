<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password</title>
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body class="d-flex align-items-center min-vh-100 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <h4 class="mb-3">Lupa Password</h4>
            @if (session('status'))
              <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
              @csrf
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <button type="submit" class="btn btn-primary">Kirim Link Reset</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
