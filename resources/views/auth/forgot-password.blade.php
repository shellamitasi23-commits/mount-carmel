<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mount Carmel — Lupa Kata Sandi</title>
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
        <i class="bi bi-shield-lock"></i>
      </div>
      
      <div class="form-header">
        <h2 class="form-title">Lupa Kata Sandi?</h2>
        <p class="form-subtitle">Tidak perlu khawatir. Masukkan alamat email Anda, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>
      </div>

      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        
        {{-- Email Field --}}
        <div class="field-group">
          <label class="field-label">Alamat Email</label>
          <div class="input-wrapper">
            <input type="email" name="email" placeholder="contoh: nama@email.com" value="{{ old('email') }}" required autofocus/>
            <i class="bi bi-envelope input-icon"></i>
          </div>
          @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <button type="submit" class="submit-button">Kirim Tautan Atur Ulang</button>
      </form>

      <a href="{{ url('/login') }}" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Kembali ke halaman Masuk
      </a>
    </div>
  </div>

</div>

<div class="toast" id="toast"></div>

{{-- External Premium Script --}}
<script src="{{ asset('js/auth.js') }}"></script>
<script>
  /* Trigger Toast dari Session Laravel */
  document.addEventListener("DOMContentLoaded", function() {
    @if(session('status'))
      showToast("{{ session('status') }}", true);
    @endif

    @if($errors->any())
      showToast("Terdapat kesalahan, silakan periksa alamat email Anda.", false);
    @endif
  });
</script>
</body>
</html>