<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mount Carmel — Lupa Kata Sandi</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --navy: #1a2332; --navy-soft: #2d3f55; --teal: #4a9fb5; --teal-dark: #357f96;
      --teal-pale: #e8f6fa; --gray: #6b7a8d; --gray-lt: #b0bcc8; --border: #d4e4ed;
      --bg: #f0f7fb; --white: #ffffff;
    }
    html, body { height: 100%; font-family: 'Inter', sans-serif; background: var(--bg); color: var(--navy); overflow-x: hidden; }

    .page { min-height: 100vh; display: grid; grid-template-columns: 1fr 1fr; }

    /* BRAND PANEL (KIRI) */
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

    /* FORM PANEL (KANAN) */
    .form-panel { background: var(--white); display: flex; align-items: center; justify-content: center; padding: 2.5rem 3.5rem; }
    
    .form-box { width: 100%; max-width: 400px; animation: fadeInUp .8s cubic-bezier(.22,.68,0,1.2) both; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: none; } }

    /* FORM STYLES */
    .icon-wrapper { width: 56px; height: 56px; background: var(--teal-pale); color: var(--teal); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; }
    .form-title { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.8rem; margin-bottom: .3rem; }
    .form-sub { font-size: .85rem; color: var(--gray); margin-bottom: 2rem; line-height: 1.5; }
    .field { margin-bottom: 1.5rem; }
    .field label { display: block; font-size: .78rem; font-weight: 600; color: var(--navy-soft); margin-bottom: .4rem; font-family: 'Poppins', sans-serif; }
    .input-wrap { position: relative; }
    .input-wrap .ico { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--gray-lt); transition: color .25s; }
    .input-wrap input { width: 100%; border: 1.5px solid var(--border); border-radius: 10px; padding: .8rem 1rem .8rem 2.8rem; font-family: 'Inter', sans-serif; font-size: .92rem; transition: all .25s; }
    .input-wrap input:focus { border-color: var(--teal); box-shadow: 0 0 0 3.5px rgba(74,159,181,.15); outline: none; }
    .input-wrap input:focus ~ .ico { color: var(--teal); }
    
    .error-text { color: #c0392b; font-size: 0.8rem; margin-top: 0.5rem; display: block; }

    .btn { width: 100%; background: var(--teal); color: #fff; border: none; border-radius: 10px; padding: .9rem; font-family: 'Poppins', sans-serif; font-weight: 600; cursor: pointer; position: relative; overflow: hidden; transition: all .2s; margin-bottom: 1rem;}
    .btn:hover { background: var(--teal-dark); box-shadow: 0 6px 20px rgba(74,159,181,.3); }
    .btn:active { transform: scale(.97); }
    
    .back-link { display: flex; align-items: center; justify-content: center; gap: .5rem; font-size: .85rem; color: var(--gray); text-decoration: none; font-weight: 500; transition: color .2s;}
    .back-link:hover { color: var(--navy); }

    /* RIPPLE & TOAST */
    .ripple { position: absolute; border-radius: 50%; background: rgba(255,255,255,.3); transform: scale(0); animation: rpl .55s linear; pointer-events: none; }
    @keyframes rpl { to { transform: scale(4); opacity: 0; } }
    .toast { position: fixed; bottom: 2rem; left: 50%; transform: translateX(-50%) translateY(60px); background: var(--navy); color: #fff; padding: .75rem 1.5rem; border-radius: 10px; font-size: .85rem; opacity: 0; transition: all .4s; z-index: 999; }
    .toast.show { transform: translateX(-50%) translateY(0); opacity: 1; }

    @media (max-width: 768px) { .page { grid-template-columns: 1fr; } .brand-panel { display: none; } .form-panel { padding: 2rem 1.5rem; } }
  </style>
</head>
<body>

<div class="page">
  <div class="brand-panel">
    <div class="blob" style="width:300px;height:300px;background:#a0d8ef;top:-80px;right:-60px;--dur:6s;"></div>
    <div class="blob" style="width:200px;height:200px;background:#c5e8f5;bottom:80px;left:-40px;--dur:8s;animation-delay:-3s;"></div>
    <svg class="trees" viewBox="0 0 800 220" preserveAspectRatio="xMidYMax meet" fill="var(--navy)">
        <polygon points="80,200 60,140 100,140"/><polygon points="80,160 55,100  105,100"/><polygon points="80,120 50,60   110,60"/><rect x="76" y="200" width="8" height="20"/>
        <polygon points="300,200 278,145 322,145"/><polygon points="300,163 272,103 328,103"/><polygon points="300,125 268,68  332,68"/><rect x="296" y="200" width="8" height="20"/>
        <polygon points="540,200 515,130 565,130"/><polygon points="540,155 508,85  572,85"/><polygon points="540,112 504,48  576,48"/><rect x="536" y="200" width="8" height="20"/>
    </svg>

    <div class="brand-content">
      <div class="brand"><div class="brand-dot"></div>Mount Carmel</div>
      <div class="tagline">Jangan Khawatir<em>"Kami akan membantu Anda memulihkan akses ke akun Anda."</em></div>
    </div>
  </div>

  <div class="form-panel">
    <div class="form-box">
      <div class="icon-wrapper">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
      </div>
      <h2 class="form-title">Lupa Kata Sandi?</h2>
      <p class="form-sub">Tidak masalah. Masukkan alamat email yang terhubung dengan akun Anda, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.</p>

      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        
        <div class="field">
          <label>Alamat Email</label>
          <div class="input-wrap">
            <input type="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus/>
            <svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/></svg>
          </div>
          @error('email')
            <span class="error-text">{{ $message }}</span>
          @enderror
        </div>

        <button type="submit" class="btn">Kirim Tautan Reset</button>
      </form>

      <a href="{{ url('/login') }}" class="back-link" style="margin-top: 1.5rem;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Kembali ke halaman Masuk
      </a>
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>

<script>
  /* Ripple Effect untuk tombol */
  document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      // Jika form tidak valid, jangan buat animasi terlalu lama
      if(this.closest('form') && !this.closest('form').checkValidity()) return;

      const r = document.createElement('span'); r.className = 'ripple';
      const rect = btn.getBoundingClientRect(); const sz = Math.max(rect.width, rect.height) * 1.5;
      r.style.cssText = `width:${sz}px;height:${sz}px;left:${e.clientX-rect.left-sz/2}px;top:${e.clientY-rect.top-sz/2}px`;
      btn.appendChild(r); setTimeout(() => r.remove(), 700);
    });
  });

  /* Toast Function */
  function showToast(msg, success = true) {
    const t = document.getElementById('toast');
    t.textContent = msg; 
    t.style.background = success ? '#1a2332' : '#c0392b';
    t.classList.add('show'); 
    setTimeout(() => t.classList.remove('show'), 4000);
  }

  /* Trigger Toast dari Session Laravel */
  document.addEventListener("DOMContentLoaded", function() {
    @if(session('success'))
      showToast("{{ session('success') }}", true);
    @endif

    @if($errors->any())
      showToast("Terdapat kesalahan, silakan periksa input Anda.", false);
    @endif
  });
</script>
</body>
</html>