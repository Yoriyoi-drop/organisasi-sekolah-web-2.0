@extends('layouts.app')

@section('title', 'Ubah Password - MA NU Nusantara')

@section('content')
<section class="page-header">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="{{ route('profile.show') }}">Profil</a></li>
        <li class="breadcrumb-item"><a href="{{ route('profile.edit') }}">Edit Profil</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ubah Password</li>
      </ol>
    </nav>
    <h1 class="display-6 fw-bold">Ubah Password</h1>
  </div>
</section>

<section class="py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <form method="POST" action="{{ route('profile.password.update') }}" id="password-form">
              @csrf
              @method('PUT')
              <div class="row g-3">
                <div class="col-md-4">
                  <label for="channel" class="form-label">Kirim Kode Via</label>
                  <select id="channel" name="channel" class="form-select">
                    <option value="email" {{ old('channel','email')==='email' ? 'selected' : '' }}>Email</option>
                    <option value="phone" {{ old('channel')==='phone' ? 'selected' : '' }}>Telepon</option>
                  </select>
                </div>
                <div class="col-md-8" id="email-wrap">
                  <label for="email" class="form-label">Email Akun</label>
                  <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control @error('email') is-invalid @enderror">
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-8 d-none" id="phone-wrap">
                  <label for="phone" class="form-label">Nomor Telepon</label>
                  <input type="tel" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="Contoh: +62812xxxxxxx">
                  @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Kode Verifikasi</label>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                  <div class="d-flex gap-2">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="form-control text-center otp-digit" style="width: 48px;" aria-label="digit 1">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="form-control text-center otp-digit" style="width: 48px;" aria-label="digit 2">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="form-control text-center otp-digit" style="width: 48px;" aria-label="digit 3">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="form-control text-center otp-digit" style="width: 48px;" aria-label="digit 4">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="form-control text-center otp-digit" style="width: 48px;" aria-label="digit 5">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="form-control text-center otp-digit" style="width: 48px;" aria-label="digit 6">
                  </div>
                  <button type="button" class="btn btn-outline-secondary" id="send-code-btn" onclick="sendVerificationCode()">Kirim</button>
                  <span class="text-muted ms-2" id="cooldown-text" style="display:none"></span>
                </div>
                <input type="hidden" id="code" name="code" value="{{ old('code') }}" class="@error('code') is-invalid @enderror">
                @error('code')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3">
                <label for="current_password" class="form-label">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                @error('current_password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru</label>
                <input type="password" id="new_password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" minlength="8" required>
                <div class="form-text">Minimal 8 karakter.</div>
                @error('new_password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
              </div>

              <div class="d-flex justify-content-between">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                  <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-check-lg me-1"></i>Simpan Password
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Libraries -->
<script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  async function sendVerificationCode() {
    const btn = document.getElementById('send-code-btn');
    const channel = document.getElementById('channel').value;
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const cooldownEl = document.getElementById('cooldown-text');

    if (channel === 'email' && !emailInput.value) {
      Swal.fire('Perhatian', 'Masukkan email terlebih dahulu.', 'warning');
      return;
    }
    if (channel === 'phone' && !phoneInput.value) {
      Swal.fire('Perhatian', 'Masukkan nomor telepon terlebih dahulu.', 'warning');
      return;
    }

    const payload = new URLSearchParams();
    payload.append('channel', channel);
    if (channel === 'email') payload.append('email', emailInput.value);
    if (channel === 'phone') payload.append('phone', phoneInput.value);

    try {
      btn.disabled = true; btn.textContent = 'Mengirim...';
      const res = await axios.post(
        "{{ route('profile.password.code') }}",
        payload,
        {
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-Requested-With': 'XMLHttpRequest'
          },
          validateStatus: () => true
        }
      );

      if (res.status >= 200 && res.status < 300) {
        Swal.fire('Berhasil', (res.data && res.data.message) || 'Kode verifikasi telah dikirim.', 'success');
        // cooldown 60s
        let remaining = 60;
        cooldownEl.style.display = '';
        const tick = () => {
          cooldownEl.textContent = `Tunggu ${remaining}s untuk kirim ulang`;
          remaining--;
          if (remaining < 0) {
            cooldownEl.style.display = 'none';
            btn.disabled = false; btn.textContent = 'Kirim';
          } else {
            setTimeout(tick, 1000);
          }
        };
        tick();
        return;
      } else {
        const msg = (res.data && res.data.message) || `Gagal mengirim kode (status ${res.status})`;
        Swal.fire('Gagal', msg, 'error');
      }
    } catch (e) {
      Swal.fire('Kesalahan', e.message || 'Terjadi kesalahan saat mengirim kode.', 'error');
    } finally {
      if (btn.disabled && cooldownEl.style.display === 'none') { btn.disabled = false; btn.textContent = 'Kirim'; }
    }
  }

  // OTP input behavior
  (function initOtpInputs(){
    const boxes = Array.from(document.querySelectorAll('.otp-digit'));
    const hidden = document.getElementById('code');
    // Pre-fill from old value
    if (hidden.value && hidden.value.length === 6) {
      hidden.value.split('').forEach((c, i) => { if (boxes[i]) boxes[i].value = c; });
    }

    function syncHidden() {
      hidden.value = boxes.map(b => (b.value || '').replace(/\D/g,'')).join('').slice(0,6);
    }

    boxes.forEach((box, idx) => {
      box.addEventListener('input', e => {
        // keep only digits
        box.value = box.value.replace(/\D/g,'');
        if (box.value.length === 1 && idx < boxes.length - 1) {
          boxes[idx+1].focus();
        }
        syncHidden();
      });

      box.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !box.value && idx > 0) {
          boxes[idx-1].focus();
        }
      });

      box.addEventListener('paste', e => {
        e.preventDefault();
        const text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g,'').slice(0,6);
        if (!text) return;
        for (let i=0; i<boxes.length; i++) {
          boxes[i].value = text[i] || '';
        }
        syncHidden();
        const next = text.length >= 6 ? boxes[boxes.length-1] : boxes[text.length] || boxes[boxes.length-1];
        next.focus();
      });
    });

    // Sync on submit
    const form = document.getElementById('password-form');
    if (form) {
      form.addEventListener('submit', () => syncHidden());
    }
  })();

  // Channel toggle
  (function initChannelToggle(){
    const channelSel = document.getElementById('channel');
    const emailWrap = document.getElementById('email-wrap');
    const phoneWrap = document.getElementById('phone-wrap');
    function update(){
      if (channelSel.value === 'email') {
        emailWrap.classList.remove('d-none');
        phoneWrap.classList.add('d-none');
      } else {
        emailWrap.classList.add('d-none');
        phoneWrap.classList.remove('d-none');
      }
    }
    channelSel.addEventListener('change', update);
    update();
  })();
</script>
@endsection
