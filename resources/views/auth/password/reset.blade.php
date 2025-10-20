<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body class="d-flex align-items-center min-vh-100 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <h4 class="mb-3">Reset Password</h4>
            @if (session('status'))
              <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('password.update') }}">
              @csrf
              <input type="hidden" name="token" value="{{ $token }}">
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $email ?? '') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary">Perbarui Password</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
