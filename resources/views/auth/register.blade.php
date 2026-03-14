<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mount Carmel — Daftar</title>
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
    .form-panel { background: var(--white); display: flex; align-items: center; justify-content: center; padding: 2.5rem 3.5rem; }
    .form-box { width: 100%; max-width: 440px; animation: slideUp .8s cubic-bezier(.22,.68,0,1.2) both; }
    @keyframes slideUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: none; } }
    .brand-panel {
      position: relative; background: linear-gradient(160deg, #b8ddf0 0%, #8bc9e4 50%, #58adc8 100%);
      display: flex; flex-direction: column; justify-content: center; align-items: flex-end;
      padding: 4rem 5rem 4rem 4rem; overflow: hidden; text-align: right;
    }
    .brand-panel::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 70% 60% at 20% 110%, rgba(255,255,255,.3) 0%, transparent 60%); }
    .blob { position: absolute; border-radius: 50%; filter: blur(60px); opacity: .3; animation: blobFloat var(--dur) ease-in-out infinite alternate; }
    @keyframes blobFloat { from { transform: translateY(0) scale(1); } to { transform: translateY(-20px) scale(1.06); } }
    .trees { position: absolute; bottom: 0; left: 0; right: 0; height: 220px; opacity: .12; transform: scaleX(-1); }
    .brand-content { position: relative; z-index: 2; display: flex; flex-direction: column; align-items: flex-end; }
    .brand { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.4rem; margin-bottom: 3.5rem; display: flex; align-items: center; gap: .6rem; }
    .brand-dot { width: 8px; height: 8px; background: var(--navy); border-radius: 50%; }
    .tagline { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 2.2rem; line-height: 1.3; margin-bottom: 1rem; }
    .trust-badges { display: flex; flex-direction: column; align-items: flex-end; gap: .6rem; margin-top: 2.5rem; }
    .badge { display: flex; align-items: center; gap: .6rem; font-size: .82rem; color: var(--navy-soft); flex-direction: row-reverse; }
    .badge-icon { width: 28px; height: 28px; background: rgba(255,255,255,.6); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .alert-error { background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: .75rem 1rem; margin-bottom: 1.25rem; font-size: .83rem; color: #b91c1c; display: flex; align-items: flex-start; gap: .5rem; }
    .form-title { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.8rem; margin-bottom: .3rem; color: var(--teal-dark); }
    .form-sub { font-size: .85rem; color: var(--gray); margin-bottom: 2rem; }
    .field { margin-bottom: 1.2rem; }
    .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .field label { display: block; font-size: .78rem; font-weight: 600; color: var(--navy-soft); margin-bottom: .4rem; font-family: 'Poppins', sans-serif; }
    .input-wrap { position: relative; }
    .input-wrap .ico { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--gray-lt); transition: color .25s; pointer-events: none; }
    .input-wrap input { width: 100%; border: 1.5px solid var(--border); border-radius: 10px; padding: .8rem 1rem .8rem 2.8rem; font-family: 'Inter', sans-serif; font-size: .92rem; transition: all .25s; }
    .input-wrap input:focus { border-color: var(--teal); box-shadow: 0 0 0 3.5px rgba(74,159,181,.15); outline: none; }
    .input-wrap input.is-invalid { border-color: var(--red); }
    .invalid-feedback { font-size: .75rem; color: var(--red); margin-top: .3rem; }
    .check-row { display: flex; align-items: flex-start; gap: .6rem; margin-bottom: 1.5rem; margin-top: .5rem; }
    .check-row input { accent-color: var(--teal); margin-top: .2rem; flex-shrink: 0; transform: scale(1.1); }
    .check-row span { font-size: .8rem; color: var(--gray); line-height: 1.5; }
    .check-row a { color: var(--teal); text-decoration: none; font-weight: 600; }
    .btn { width: 100%; background: var(--teal); color: #fff; border: none; border-radius: 10px; padding: .9rem; font-family: 'Poppins', sans-serif; font-weight: 600; font-size: .95rem; cursor: pointer; position: relative; overflow: hidden; transition: all .2s; }
    .btn:hover { background: var(--teal-dark); box-shadow: 0 6px 20px rgba(74,159,181,.3); }
    .btn:active { transform: scale(.97); }
    .switch-link { text-align: center; margin-top: 2rem; font-size: .85rem; color: var(--gray); }
    .switch-link a { color: var(--navy); font-weight: 700; text-decoration: none; margin-left: .25rem; }
    .ripple { position: absolute; border-radius: 50%; background: rgba(255,255,255,.3); transform: scale(0); animation: rpl .55s linear; pointer-events: none; }
    @keyframes rpl { to { transform: scale(4); opacity: 0; } }
    @media (max-width: 768px) { .page { grid-template-columns: 1fr; } .brand-panel { display: none; } .form-panel { padding: 2rem 1.5rem; } }
  </style>
</head>
<body>
<div class="page">
  <div class="form-panel">
    <div class="form-box">
      <h2 class="form-title">Buat Akun Baru</h2>
      <p class="form-sub">Daftarkan diri untuk mengakses layanan Mount Carmel.</p>

      {{-- ── Tampilkan error validasi Laravel ── --}}
      @if ($errors->any())
        <div class="alert-error">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          <span>{{ $errors->first() }}</span>
        </div>
      @endif

      {{-- ── Form POST ke Laravel Register Controller ── --}}
      <form method="POST" action="{{ route('register.submit') }}" id="registerForm">
        @csrf

        <div class="row-2">
          <div class="field">
            <label for="rName">Nama Lengkap</label>
            <div class="input-wrap">
              <input type="text" id="rName" name="name"
                     value="{{ old('name') }}" placeholder="Budi Santoso"
                     class="{{ $errors->has('name') ? 'is-invalid' : '' }}" required/>
              <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            </div>
          </div>
          <div class="field">
            <label for="rTelp">No. Telepon</label>
            <div class="input-wrap">
              <input type="text" id="rTelp" name="no_telepon"
                     value="{{ old('no_telepon') }}" placeholder="0812..."/>
              <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </div>
          </div>
        </div>

        <div class="field">
          <label for="rEmail">Alamat Email</label>
          <div class="input-wrap">
            <input type="email" id="rEmail" name="email"
                   value="{{ old('email') }}" placeholder="nama@email.com"
                   autocomplete="email"
                   class="{{ $errors->has('email') ? 'is-invalid' : '' }}" required/>
            <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/></svg>
          </div>
        </div>
        
        <div class="field">
          <label for="rAddress">Alamat Lengkap</label>
          <div class="input-wrap">
            <input type="text" id="rAddress" name="alamat"
                   value="{{ old('alamat') }}" placeholder="Jl. Raya No. 123"
                   class="{{ $errors->has('alamat') ? 'is-invalid' : '' }}" required/>
          </div>
        </div>

        <div class="field">
          <label for="rPass">Password</label>
          <div class="input-wrap">
            <input type="password" id="rPass" name="password"
                   placeholder="Minimal 8 karakter" autocomplete="new-password"
                   class="{{ $errors->has('password') ? 'is-invalid' : '' }}" required/>
            <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </div>
        </div>

        <div class="field">
          <label for="rPassConfirm">Konfirmasi Password</label>
          <div class="input-wrap">
            <input type="password" id="rPassConfirm" name="password_confirmation"
                   placeholder="Ulangi password" autocomplete="new-password" required/>
            <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </div>
        </div>

        <div class="check-row">
          <input type="checkbox" id="rAgree" name="agree" required/>
          <span>Saya menyetujui <a href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan Privasi</a> yang berlaku.</span>
        </div>

        <button type="submit" class="btn" id="btnRegister">Daftar Sekarang</button>
      </form>

      <p class="switch-link">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
    </div>
  </div>

  <div class="brand-panel">
    <div class="blob" style="width:250px;height:250px;background:#c6e8f5;top:20px;left:-60px;--dur:7s;"></div>
    <div class="blob" style="width:180px;height:180px;background:#8bc9e4;bottom:40px;right:-20px;--dur:5s;animation-delay:-2s;"></div>
    <svg class="trees" viewBox="0 0 800 220" preserveAspectRatio="xMidYMax meet" fill="var(--navy)">
      <polygon points="180,200 155,130 205,130"/><polygon points="180,155 150,85 210,85"/><polygon points="180,110 145,45 215,45"/><rect x="176" y="200" width="8" height="20"/>
      <polygon points="420,200 400,155 440,155"/><polygon points="420,170 394,110 446,110"/><polygon points="420,132 390,72 450,72"/><rect x="416" y="200" width="8" height="20"/>
      <polygon points="660,200 640,150 680,150"/><polygon points="660,168 634,108 686,108"/><polygon points="660,128 630,68 690,68"/><rect x="656" y="200" width="8" height="20"/>
    </svg>
    <div class="brand-content">
      <div class="brand"><div class="brand-dot"></div> Mount Carmel</div>
      <div class="tagline">"Berikan yang terbaik untuk terakhir kalinya"</div>
      <div class="trust-badges">
        <div class="badge">Telah melayani 5000+ keluarga
          <div class="badge-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1a2332" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
        </div>
        <div class="badge">Layanan eksklusif 24 jam
          <div class="badge-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1a2332" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('registerForm').addEventListener('submit', function() {
    const btn = document.getElementById('btnRegister');
    btn.textContent = 'Mendaftarkan...';
    btn.style.opacity = '.7';
  });
  document.querySelectorAll('.btn').forEach(btn => {
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