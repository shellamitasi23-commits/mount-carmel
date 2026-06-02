<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mount Carmel — Pendaftaran Akun</title>
  {{-- Poppins Font --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  {{-- Bootstrap Icons CDN --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  {{-- External Premium Stylesheet --}}
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}"/>
</head>
<body>

<div class="page-container">

  {{-- Left Side: Clean Form Panel --}}
  <div class="form-panel">
    <div class="form-card">
      <div class="form-header">
        <h2 class="form-title">Mari Bergabung</h2>
        <p class="form-subtitle">Buat akun baru Anda untuk kemudahan pemesanan lahan.</p>
      </div>

      {{-- Session Validation Errors --}}
      @if ($errors->any())
        <div class="session-alert">
          <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.1rem; shrink: 0;"></i>
          <span>{{ $errors->first() }}</span>
        </div>
      @endif

      {{-- Registration Form --}}
      <form method="POST" action="{{ route('register.submit') }}" id="registerForm">
        @csrf

        {{-- Row 1: Name and Phone --}}
        <div class="field-row">
          {{-- Name Field --}}
          <div class="field-group">
            <label for="rName" class="field-label">Nama Lengkap</label>
            <div class="input-wrapper">
              <input type="text" id="rName" name="name"
                     value="{{ old('name') }}" placeholder="Nama Anda"
                     class="{{ $errors->has('name') ? 'is-invalid' : '' }}" required/>
              <i class="bi bi-person input-icon"></i>
            </div>
          </div>
          {{-- Phone Field --}}
          <div class="field-group">
            <label for="rTelp" class="field-label">Nomor Telepon / WhatsApp</label>
            <div class="input-wrapper">
              <input type="text" id="rTelp" name="no_telepon"
                     value="{{ old('no_telepon') }}" placeholder="Contoh: 0812..." required/>
              <i class="bi bi-telephone input-icon"></i>
            </div>
          </div>
        </div>

        {{-- Email Field --}}
        <div class="field-group">
          <label for="rEmail" class="field-label">Alamat Email</label>
          <div class="input-wrapper">
            <input type="email" id="rEmail" name="email"
                   value="{{ old('email') }}" placeholder="nama@email.com"
                   autocomplete="email"
                   class="{{ $errors->has('email') ? 'is-invalid' : '' }}" required/>
            <i class="bi bi-envelope input-icon"></i>
          </div>
        </div>
        
        {{-- Address Field --}}
        <div class="field-group">
          <label for="rAddress" class="field-label">Alamat Rumah Lengkap</label>
          <div class="input-wrapper">
            <input type="text" id="rAddress" name="alamat"
                   value="{{ old('alamat') }}" placeholder="Tulis alamat rumah tinggal Anda"
                   class="{{ $errors->has('alamat') ? 'is-invalid' : '' }}" required/>
            <i class="bi bi-geo-alt input-icon"></i>
          </div>
        </div>

        {{-- Password Field --}}
        <div class="field-group">
          <label for="rPass" class="field-label">Kata Sandi Baru</label>
          <div class="input-wrapper">
            <input type="password" id="rPass" name="password"
                   placeholder="Minimal 6 karakter" autocomplete="new-password"
                   class="{{ $errors->has('password') ? 'is-invalid' : '' }}" required/>
            <i class="bi bi-lock input-icon"></i>
            <button type="button" class="toggle-password" onclick="togglePass('rPass', this)">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>

        {{-- Confirm Password Field --}}
        <div class="field-group">
          <label for="rPassConfirm" class="field-label">Ulangi Kata Sandi Baru</label>
          <div class="input-wrapper">
            <input type="password" id="rPassConfirm" name="password_confirmation"
                   placeholder="Ulangi kata sandi di atas" autocomplete="new-password" required/>
            <i class="bi bi-lock-fill input-icon"></i>
            <button type="button" class="toggle-password" onclick="togglePass('rPassConfirm', this)">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>

        {{-- Agreement Row --}}
        <div class="checkbox-row">
          <input type="checkbox" id="rAgree" name="agree" required/>
          <label for="rAgree">
            Saya menyetujui <a href="javascript:void(0)" onclick="openModal('termsModal')">Syarat & Ketentuan</a> serta <a href="javascript:void(0)" onclick="openModal('privacyModal')">Kebijakan Privasi</a> yang berlaku di Mount Carmel.
          </label>
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="submit-button" id="btnRegister">Daftar Akun Sekarang</button>
      </form>

      {{-- Footer Switch Link --}}
      <p class="switch-option">
        Sudah memiliki akun?
        <a href="{{ route('login') }}">Mari masuk di sini</a>
      </p>
    </div>
  </div>

  {{-- Right Side: Beautiful Scenic Visual Panel --}}
  <div class="visual-panel">
    {{-- Brand --}}
    <div class="brand-section">
      <i class="bi bi-symmetry-vertical brand-icon"></i>
      Mount Carmel
    </div>

    {{-- Center Tagline --}}
    <div class="visual-main-content">
      <h1 class="main-tagline">
        Langkah Wisaksana
        <span>Langkah penuh kepedulian mempersiapkan masa depan terbaik bagi kedamaian keluarga tercinta.</span>
      </h1>
    </div>

    {{-- Bottom Trust Items --}}
    <div class="trust-container">
      <div class="trust-item">
        <div class="trust-item-icon">
          <i class="bi bi-heart-fill"></i>
        </div>
        Dipercaya oleh lebih dari 5.000 keluarga
      </div>
      <div class="trust-item">
        <div class="trust-item-icon">
          <i class="bi bi-clock-fill"></i>
        </div>
        Layanan penuh kasih siaga 24 jam
      </div>
    </div>
  </div>

</div>

<!-- Modal Syarat & Ketentuan -->
<div id="termsModal" class="modal-overlay" onclick="closeModalOnBackdrop(event, 'termsModal')">
  <div class="modal-card">
    <div class="modal-header">
      <h3>Syarat & Ketentuan</h3>
      <button type="button" class="close-btn" onclick="closeModal('termsModal')">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <h4>1. Pendahuluan</h4>
      <p>Selamat datang di platform digital Mount Carmel Memorial Park. Dengan membuat akun dan menggunakan layanan kami, Anda dianggap telah membaca, memahami, dan menyetujui seluruh Syarat & Ketentuan yang berlaku di bawah ini.</p>
      
      <h4>2. Pendaftaran & Keamanan Akun</h4>
      <p>Pengguna wajib memberikan data pribadi yang valid, lengkap, dan akurat (seperti nama lengkap, nomor telepon, alamat, dsb) saat melakukan pendaftaran. Anda sepenuhnya bertanggung jawab atas kerahasiaan kata sandi akun Anda.</p>
      
      <h4>3. Ketentuan Reservasi Lahan</h4>
      <ul>
        <li>Pemesanan lahan pemakaman dapat dilakukan kapan saja untuk mengantisipasi dan mempermudah keluarga di masa depan.</li>
        <li>Setiap unit lahan pemakaman yang terdaftar tunduk pada ketersediaan riil di lapangan.</li>
      </ul>

      <h4>4. Ketentuan Pembayaran & Pelunasan</h4>
      <p>Pembayaran dapat diselesaikan secara kontan (lunas) maupun melalui skema cicilan yang telah disetujui secara tertulis oleh pihak Mount Carmel. Hak guna penuh lahan makam hanya akan diserahkan setelah pembayaran dinyatakan lunas.</p>

      <h4>5. Penerbitan Sertifikat</h4>
      <p>Sertifikat Hak Guna Lahan makam akan diterbitkan secara resmi oleh manajemen Mount Carmel setelah proses pelunasan diverifikasi oleh divisi terkait.</p>

      <h4>6. Perubahan Ketentuan</h4>
      <p>Manajemen Mount Carmel berhak mengubah, menambah, atau memperbarui Syarat & Ketentuan ini sewaktu-waktu demi meningkatkan kenyamanan dan kualitas layanan hukum yang sah.</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="modal-btn" onclick="closeModal('termsModal')">Saya Mengerti</button>
    </div>
  </div>
</div>

<!-- Modal Kebijakan Privasi -->
<div id="privacyModal" class="modal-overlay" onclick="closeModalOnBackdrop(event, 'privacyModal')">
  <div class="modal-card">
    <div class="modal-header">
      <h3>Kebijakan Privasi</h3>
      <button type="button" class="close-btn" onclick="closeModal('privacyModal')">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <h4>1. Pengumpulan Data Pribadi</h4>
      <p>Kami mengumpulkan informasi yang Anda berikan secara langsung saat mendaftar, termasuk nama lengkap, alamat email, nomor telepon, alamat domisili, serta berkas verifikasi identitas resmi.</p>
      
      <h4>2. Penggunaan Informasi</h4>
      <p>Seluruh informasi pribadi yang kami kumpulkan digunakan secara eksklusif untuk:</p>
      <ul>
        <li>Memproses administrasi pemesanan dan reservasi lahan makam.</li>
        <li>Memverifikasi transaksi pembayaran bersama divisi terkait.</li>
        <li>Menerbitkan dan mengelola file Sertifikat Hak Guna Lahan Anda.</li>
        <li>Menghubungi Anda terkait pembaruan layanan penting.</li>
      </ul>

      <h4>3. Keamanan Informasi Anda</h4>
      <p>Kami menerapkan standar keamanan terbaik untuk melindungi data pribadi Anda dari akses tanpa izin, kehilangan, penyalahgunaan, atau modifikasi ilegal oleh pihak eksternal.</p>

      <h4>4. Kerahasiaan Pihak Ketiga</h4>
      <p>Mount Carmel berkomitmen tidak akan pernah menjual, menyewakan, atau menyebarluaskan data pribadi Anda kepada pihak ketiga mana pun tanpa persetujuan tertulis dari Anda, kecuali diwajibkan oleh instruksi hukum atau pengadilan.</p>

      <h4>5. Hak Pengguna</h4>
      <p>Anda berhak memperbarui informasi profil, mengubah kata sandi akun, atau mengajukan penutupan akun dengan menghubungi tim dukungan admin kami yang bertugas.</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="modal-btn" onclick="closeModal('privacyModal')">Tutup</button>
    </div>
  </div>
</div>

{{-- External Premium Script --}}
<script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>