<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mount Carmel — Masuk ke Akun</title>
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
        <span>Menghadirkan keheningan, kenyamanan, dan penghormatan terbaik di tempat peristirahatan terakhir yang asri.</span>
      </h1>
    </div>

    {{-- Bottom Trust Items --}}
    <div class="trust-container">
      <div class="trust-item">
        <div class="trust-item-icon">
          <i class="bi bi-shield-lock-fill"></i>
        </div>
        Keamanan data Anda terlindungi sepenuhnya
      </div>
    </div>
  </div>

  {{-- Right Side: Clean Form Panel --}}
  <div class="form-panel">
    <div class="form-card">
      <div class="form-header">
        <h2 class="form-title">Masuk</h2>
        <p class="form-subtitle">Mari masuk ke akun Anda untuk mengelola pemesanan lahan.</p>
      </div>

      {{-- Session Alerts --}}
      @if ($errors->any())
        <div class="session-alert">
          <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.1rem; shrink: 0;"></i>
          <span>{{ $errors->first() }}</span>
        </div>
      @endif

      @if (session('status'))
        <div class="session-alert-success">
          <i class="bi bi-check-circle-fill" style="font-size: 1.1rem; shrink: 0;"></i>
          <span>{{ session('status') }}</span>
        </div>
      @endif

      {{-- Sign In Form --}}
      <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        {{-- Email Field --}}
        <div class="field-group">
          <label for="lEmail" class="field-label">Alamat Email</label>
          <div class="input-wrapper">
            <input type="email" id="lEmail" name="email"
                   value="{{ old('email') }}"
                   placeholder="contoh: nama@email.com"
                   autocomplete="email"
                   class="{{ $errors->has('email') ? 'is-invalid' : '' }}" required/>
            <i class="bi bi-envelope input-icon"></i>
          </div>
          @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        {{-- Password Field --}}
        <div class="field-group">
          <label for="lPass" class="field-label">Kata Sandi</label>
          <div class="input-wrapper">
            <input type="password" id="lPass" name="password"
                   placeholder="Masukkan kata sandi Anda"
                   autocomplete="current-password"
                   class="{{ $errors->has('password') ? 'is-invalid' : '' }}" required/>
            <i class="bi bi-lock input-icon"></i>
            <button type="button" class="toggle-password" onclick="togglePass('lPass', this)">
              <i class="bi bi-eye"></i>
            </button>
          </div>
          @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        {{-- Extras --}}
        <div class="form-extras">
          <label class="remember-me" for="remember">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>
            Ingat saya
          </label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-link">Lupa kata sandi?</a>
          @endif
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="submit-button" id="btnLogin">Masuk Sekarang</button>
      </form>

      {{-- Social Separator --}}
      <div class="or-divider">
        <div class="or-line"></div>
        <span class="or-text">atau</span>
        <div class="or-line"></div>
      </div>

      {{-- Google Button --}}
      <a href="{{ route('auth.google') }}" class="social-button" style="text-decoration: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48" style="display: block; flex-shrink: 0;">
          <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
          <path fill="#FF3D00" d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691z"/>
          <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.422-5.192l-6.242-5.123C29.172 35.15 26.685 36 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
          <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002l6.242 5.123C41.34 35.138 44 30.2 44 24c0-1.341-.138-2.65-.389-3.917z"/>
        </svg>
        <span style="margin-left: 12px; color: #1f2937; font-weight: 600;">Masuk melalui Google</span>
      </a>

      {{-- Footer Link --}}
      <p class="switch-option">
        Belum memiliki akun?
        <a href="{{ route('register') }}">Yuk, daftar di sini</a>
      </p>
    </div>
  </div>

</div>

{{-- External Premium Script --}}
<script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>