<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mount Carmel — Atur Ulang Kata Sandi</title>
  {{-- Poppins Font --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  {{-- Bootstrap Icons CDN --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  {{-- External Premium Stylesheet --}}
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}"/>
</head>
<body>

<div class="page-container">

  {{-- Left Side: Beautiful Scenic Visual Panel --}}
  <div class="visual-panel">
    {{-- Brand --}}
    <div class="brand-section">
      <i class="bi bi-symmetry-vertical brand-icon"></i>
      Mount Carmel
    </div>

    {{-- Center Tagline --}}
    <div class="visual-main-content">
      <h1 class="main-tagline">
        Menemukan Kedamaian Sejati
        <span>Kami siap membantu Anda memulihkan akses masuk ke dalam akun Anda dengan cepat dan aman.</span>
      </h1>
    </div>

    {{-- Bottom Trust Items --}}
    <div class="trust-container">
      <div class="trust-item">
        <div class="trust-item-icon">
          <i class="bi bi-shield-lock-fill"></i>
        </div>
        Sistem pemulihan sandi terenkripsi aman
      </div>
    </div>
  </div>

  {{-- Right Side: Clean Form Panel --}}
  <div class="form-panel">
    <div class="form-card">
      <div class="icon-wrapper">
        <i class="bi bi-key"></i>
      </div>
      
      <div class="form-header">
        <h2 class="form-title">Atur Ulang Sandi</h2>
        <p class="form-subtitle">Buat kata sandi baru yang kuat untuk mengamankan kembali akun Mount Carmel Anda.</p>
      </div>

      {{-- Session Alerts --}}
      @if ($errors->any())
        <div class="session-alert">
          <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.1rem; flex-shrink: 0;"></i>
          <span>{{ $errors->first() }}</span>
        </div>
      @endif

      <form method="POST" action="{{ route('password.update') }}" id="resetForm">
        @csrf
        
        {{-- Hidden Token Field --}}
        <input type="hidden" name="token" value="{{ $token }}"/>
        
        {{-- Email Field (ReadOnly but submitted) --}}
        <div class="field-group">
          <label class="field-label" for="rEmail">Alamat Email</label>
          <div class="input-wrapper">
            <input type="email" id="rEmail" name="email" value="{{ old('email', $email) }}" required readonly/>
            <i class="bi bi-envelope input-icon"></i>
          </div>
          @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        {{-- Password Field --}}
        <div class="field-group">
          <label class="field-label" for="rPass">Kata Sandi Baru</label>
          <div class="input-wrapper">
            <input type="password" id="rPass" name="password" placeholder="Minimal 8 karakter" required autofocus/>
            <i class="bi bi-lock input-icon"></i>
            <button type="button" class="toggle-password" onclick="togglePass('rPass', this)">
              <i class="bi bi-eye"></i>
            </button>
          </div>
          @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        {{-- Confirm Password Field --}}
        <div class="field-group">
          <label class="field-label" for="rPassConfirm">Konfirmasi Kata Sandi Baru</label>
          <div class="input-wrapper">
            <input type="password" id="rPassConfirm" name="password_confirmation" placeholder="Ulangi kata sandi baru" required/>
            <i class="bi bi-lock-fill input-icon"></i>
            <button type="button" class="toggle-password" onclick="togglePass('rPassConfirm', this)">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="submit-button" id="btnSubmitReset">Atur Ulang Kata Sandi</button>
      </form>

      <a href="{{ url('/login') }}" class="back-link" style="margin-top: 1.5rem;">
        <i class="bi bi-arrow-left"></i>
        Kembali ke halaman Masuk
      </a>
    </div>
  </div>

</div>

{{-- External Premium Script --}}
<script src="{{ asset('js/auth.js') }}"></script>
<script>
  // Add submission loading state to reset form
  document.addEventListener("DOMContentLoaded", function() {
    const resetForm = document.getElementById('resetForm');
    if (resetForm) {
      resetForm.addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmitReset');
        if (btn) {
          btn.textContent = 'Memproses atur ulang...';
          btn.style.opacity = '.75';
          btn.style.pointerEvents = 'none';
        }
      });
    }
  });
</script>
</body>
</html>
