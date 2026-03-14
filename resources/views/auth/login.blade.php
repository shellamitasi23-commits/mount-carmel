<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mount Carmel — Masuk</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --navy: #1a2332; --navy-soft: #2d3f55; --teal: #4a9fb5; --teal-dark: #357f96;
      --teal-pale: #e8f6fa; --gray: #6b7a8d; --gray-lt: #b0bcc8; --border: #d4e4ed;
      --bg: #f0f7fb; --white: #ffffff; --red: #e53e3e;
    }
    html, body { height: 100%; font-family: 'Inter', sans-serif; background: var(--bg); color: var(--navy); overflow-x: hidden; }
    .page { min-height: 100vh; display: grid; grid-template-columns: 1fr 1fr; }
    .brand-panel {
      position: relative; background: linear-gradient(160deg, #c6e8f5 0%, #a8d8ed 40%, #8bc9e4 100%);
      display: flex; flex-direction: column; justify-content: center; align-items: flex-start;
      padding: 4rem 4rem 4rem 5rem; overflow: hidden;
    }
    .brand-panel::before {
      content: ''; position: absolute; inset: 0;
      background: radial-gradient(ellipse 70% 60% at 80% 110%, rgba(255,255,255,.35) 0%, transparent 60%),
                  radial-gradient(ellipse 50% 40% at -10% 20%, rgba(255,255,255,.2) 0%, transparent 60%);
    }
    .blob { position: absolute; border-radius: 50%; filter: blur(60px); opacity: .35; animation: blobFloat var(--dur) ease-in-out infinite alternate; }
    @keyframes blobFloat { from { transform: translateY(0) scale(1); } to { transform: translateY(-20px) scale(1.06); } }
    .trees { position: absolute; bottom: 0; left: 0; right: 0; height: 220px; opacity: .12; }
    .brand-content { position: relative; z-index: 2; }
    .brand { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.4rem; margin-bottom: 3.5rem; display: flex; align-items: center; gap: .6rem; }
    .brand-dot { width: 8px; height: 8px; background: var(--navy); border-radius: 50%; }
    .tagline { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 2.4rem; line-height: 1.25; margin-bottom: 1rem; }
    .tagline em { font-style: italic; font-weight: 400; color: var(--navy-soft); display: block; font-size: 1rem; margin-top: .75rem; font-family: 'Inter', sans-serif; }
    .trust-badges { display: flex; flex-direction: column; gap: .6rem; margin-top: 2.5rem; }
    .badge { display: flex; align-items: center; gap: .6rem; font-size: .82rem; color: var(--navy-soft); }
    .badge-icon { width: 28px; height: 28px; background: rgba(255,255,255,.6); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .form-panel { background: var(--white); display: flex; align-items: center; justify-content: center; padding: 2.5rem 3.5rem; }
    .form-box { width: 100%; max-width: 400px; animation: slideInRight .8s cubic-bezier(.22,.68,0,1.2) both; }
    @keyframes slideInRight { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: none; } }
    .form-title { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.8rem; margin-bottom: .3rem; }
    .form-sub { font-size: .85rem; color: var(--gray); margin-bottom: 2rem; }

    /* Laravel session error banner */
    .alert-error { background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: .75rem 1rem; margin-bottom: 1.25rem; font-size: .83rem; color: #b91c1c; display: flex; align-items: flex-start; gap: .5rem; }
    .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: .75rem 1rem; margin-bottom: 1.25rem; font-size: .83rem; color: #166534; }

    .field { margin-bottom: 1.2rem; }
    .field label { display: block; font-size: .78rem; font-weight: 600; color: var(--navy-soft); margin-bottom: .4rem; font-family: 'Poppins', sans-serif; }
    .input-wrap { position: relative; }
    .input-wrap .ico { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--gray-lt); transition: color .25s; pointer-events: none; }
    .input-wrap input { width: 100%; border: 1.5px solid var(--border); border-radius: 10px; padding: .8rem 1rem .8rem 2.8rem; font-family: 'Inter', sans-serif; font-size: .92rem; transition: all .25s; }
    .input-wrap input:focus { border-color: var(--teal); box-shadow: 0 0 0 3.5px rgba(74,159,181,.15); outline: none; }
    .input-wrap input.is-invalid { border-color: var(--red); }
    .invalid-feedback { font-size: .75rem; color: var(--red); margin-top: .3rem; }
    .extras { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
    .remember { display: flex; align-items: center; gap: .4rem; font-size: .8rem; color: var(--gray); cursor: pointer; }
    .forgot { font-size: .8rem; color: var(--teal); text-decoration: none; font-weight: 600; }
    .btn { width: 100%; background: var(--navy); color: #fff; border: none; border-radius: 10px; padding: .9rem; font-family: 'Poppins', sans-serif; font-weight: 600; font-size: .95rem; cursor: pointer; position: relative; overflow: hidden; transition: all .2s; }
    .btn:hover { background: var(--navy-soft); box-shadow: 0 6px 20px rgba(26,35,50,.2); }
    .btn:active { transform: scale(.97); }
    .or { display: flex; align-items: center; gap: .75rem; margin: 1.5rem 0; }
    .or::before, .or::after { content: ''; flex: 1; height: 1px; background: var(--border); }
    .or span { font-size: .75rem; color: var(--gray-lt); }
    .social-btn { width: 100%; border: 1.5px solid var(--border); background: var(--white); border-radius: 10px; padding: .8rem; font-family: 'Inter', sans-serif; font-weight: 500; color: var(--navy-soft); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: .5rem; transition: all .2s; }
    .social-btn:hover { border-color: var(--teal); background: var(--teal-pale); }
    .switch-link { text-align: center; margin-top: 2rem; font-size: .85rem; color: var(--gray); }
    .switch-link a { color: var(--teal); font-weight: 700; text-decoration: none; margin-left: .25rem; }
    .ripple { position: absolute; border-radius: 50%; background: rgba(255,255,255,.3); transform: scale(0); animation: rpl .55s linear; pointer-events: none; }
    @keyframes rpl { to { transform: scale(4); opacity: 0; } }
    @media (max-width: 768px) { .page { grid-template-columns: 1fr; } .brand-panel { display: none; } .form-panel { padding: 2rem 1.5rem; } }
  </style>
</head>
<body>
<div class="page">
  <div class="brand-panel">
    <div class="blob" style="width:300px;height:300px;background:#a0d8ef;top:-80px;right:-60px;--dur:6s;"></div>
    <div class="blob" style="width:200px;height:200px;background:#c5e8f5;bottom:80px;left:-40px;--dur:8s;animation-delay:-3s;"></div>
    <svg class="trees" viewBox="0 0 800 220" preserveAspectRatio="xMidYMax meet" fill="var(--navy)">
      <polygon points="80,200 60,140 100,140"/><polygon points="80,160 55,100 105,100"/><polygon points="80,120 50,60 110,60"/><rect x="76" y="200" width="8" height="20"/>
      <polygon points="300,200 278,145 322,145"/><polygon points="300,163 272,103 328,103"/><polygon points="300,125 268,68 332,68"/><rect x="296" y="200" width="8" height="20"/>
      <polygon points="540,200 515,130 565,130"/><polygon points="540,155 508,85 572,85"/><polygon points="540,112 504,48 576,48"/><rect x="536" y="200" width="8" height="20"/>
    </svg>
    <div class="brand-content">
      <div class="brand"><div class="brand-dot"></div> Mount Carmel</div>
      <div class="tagline">Welcome Back<em>"Silakan masuk ke akun Anda"</em></div>
      <div class="trust-badges">
        <div class="badge">
          <div class="badge-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1a2332" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
          Keamanan data terjamin 100%
        </div>
      </div>
    </div>
  </div>

  <div class="form-panel">
    <div class="form-box">
      <h2 class="form-title">Masuk</h2>
      <p class="form-sub">Masuk untuk melanjutkan.</p>

      {{-- ── Laravel: tampilkan error session (mis. credentials salah) ── --}}
      @if ($errors->any())
        <div class="alert-error">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          <span>{{ $errors->first() }}</span>
        </div>
      @endif

      @if (session('status'))
        <div class="alert-success">{{ session('status') }}</div>
      @endif

      {{-- ── Form POST ke Laravel Auth ── --}}
      <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <div class="field">
          <label for="lEmail">Email</label>
          <div class="input-wrap">
            <input type="email" id="lEmail" name="email"
                   value="{{ old('email') }}"
                   placeholder="nama@email.com"
                   autocomplete="email"
                   class="{{ $errors->has('email') ? 'is-invalid' : '' }}" required/>
            <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/></svg>
          </div>
          @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="field">
          <label for="lPass">Password</label>
          <div class="input-wrap">
            <input type="password" id="lPass" name="password"
                   placeholder="Password"
                   autocomplete="current-password"
                   class="{{ $errors->has('password') ? 'is-invalid' : '' }}" required/>
            <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </div>
          @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="extras">
          <label class="remember">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}/> Ingat saya
          </label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot">Lupa password?</a>
          @endif
        </div>

        {{-- ── Tombol submit — form POST, tidak pakai JS onclick ── --}}
        <button type="submit" class="btn" id="btnLogin">Masuk</button>
      </form>

      <div class="or"><span>atau</span></div>

      <button class="social-btn" type="button">
        <svg width="16" height="16" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
        Masuk dengan Google
      </button>

      <p class="switch-link">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
    </div>
  </div>
</div>

<script>
  /* Ripple visual feedback saja — submit tetap via form POST */
  document.getElementById('loginForm').addEventListener('submit', function() {
    const btn = document.getElementById('btnLogin');
    btn.textContent = 'Memproses...';
    btn.style.opacity = '.7';
  });
  document.querySelectorAll('.btn, .social-btn').forEach(btn => {
    btn.addEventListener('click', e => {
      const r = document.createElement('span'); r.className = 'ripple';
      const rect = btn.getBoundingClientRect();
      const sz = Math.max(rect.width, rect.height) * 1.5;
      r.style.cssText = `width:${sz}px;height:${sz}px;left:${e.clientX-rect.left-sz/2}px;top:${e.clientY-rect.top-sz/2}px`;
      btn.appendChild(r); setTimeout(() => r.remove(), 700);
    });
  });
</script>
</body>
</html>