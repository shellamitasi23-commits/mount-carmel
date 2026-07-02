<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Mount Carmel — Verifikasi OTP</title>
    {{-- Roboto Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet"/>
    {{-- Bootstrap Icons CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    {{-- External Premium Stylesheet --}}
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}"/>
    <style>
        :root {
            --font-sans: 'Roboto', sans-serif;
        }
        body {
            font-family: var(--font-sans);
        }
        /* Disable excessive bolding and uppercase */
        .font-black, .font-extrabold {
            font-weight: 600 !important;
        }
        .font-bold {
            font-weight: 500 !important;
        }
        .uppercase {
            text-transform: none !important;
        }
        .btn-submit {
            width: 100%;
            background-color: var(--maroon);
            color: var(--white);
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-family: var(--font-sans);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.25s, transform 0.25s;
            margin-top: 1rem;
        }
        .btn-submit:hover {
            background-color: var(--maroon-soft);
        }
        .btn-submit:active {
            transform: scale(0.98);
        }
        .otp-input-container {
            margin: 2rem 0;
            position: relative;
        }
        .otp-input-field {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 0.6rem;
            padding: 0.9rem 1rem;
            font-family: monospace;
            border: 1.5px solid var(--border);
            background-color: var(--cream);
            border-radius: 12px;
            width: 100%;
            outline: none;
            transition: all 0.25s;
        }
        .otp-input-field:focus {
            background-color: var(--white);
            border-color: var(--maroon);
            box-shadow: 0 0 0 4px rgba(128, 0, 0, 0.1);
        }
    </style>
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
                Verifikasi Akun Anda
                <span>Masukkan kode OTP yang telah dikirimkan ke alamat email terdaftar untuk mulai menggunakan layanan kami.</span>
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
                <h2 class="form-title" style="margin-bottom: 0.25rem;">Masukkan OTP</h2>
                <p class="form-subtitle">Kami telah mengirimkan 6 digit kode keamanan ke email <strong>{{ Auth::user()->email }}</strong>.</p>
            </div>

            @if(session('success'))
            <div style="background-color: rgba(16, 185, 129, 0.1); border: 1.5px solid rgba(16, 185, 129, 0.2); color: #10b981; border-radius: 12px; padding: 0.9rem; font-size: 0.85rem; font-weight: 500; margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div style="background-color: rgba(239, 68, 68, 0.1); border: 1.5px solid rgba(239, 68, 68, 0.2); color: #ef4444; border-radius: 12px; padding: 0.9rem; font-size: 0.85rem; font-weight: 500; margin-bottom: 1.5rem;">
                {{ session('error') }}
            </div>
            @endif

            {{-- Form Verifikasi --}}
            <form action="{{ route('otp.verify.submit') }}" method="POST">
                @csrf
                <div class="otp-input-container">
                    <input type="text" name="otp" id="otp" maxlength="6" required autocomplete="one-time-code"
                           class="otp-input-field @error('otp') is-invalid @enderror"
                           placeholder="------" autofocus/>
                    
                    @error('otp')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    Verifikasi Akun
                </button>
            </form>

            {{-- Form Kirim Ulang OTP --}}
            <div style="margin-top: 2rem; text-align: center;">
                <p style="font-size: 0.85rem; color: var(--gray-muted); margin-bottom: 0.5rem;">Tidak menerima kode OTP?</p>
                <form action="{{ route('otp.resend') }}" method="POST">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: var(--maroon); font-size: 0.85rem; font-weight: 600; cursor: pointer; text-decoration: underline;">
                        Kirim Ulang Kode OTP
                    </button>
                </form>
            </div>

            {{-- Helper hint untuk lingkungan lokal agar mudah ditest --}}
            @if(config('app.env') === 'local' && session('otp_code'))
            <div style="margin-top: 3rem; background-color: #f8f9fc; border: 1px solid #eeeeee; border-radius: 12px; padding: 1rem; text-align: center;">
                <p style="font-size: 0.75rem; color: #7e8694; margin: 0;">
                    <i class="bi bi-bug-fill"></i> <strong>Mode Pengujian Lokal:</strong>
                </p>
                <p style="font-size: 1.25rem; font-weight: 700; color: var(--maroon); margin: 0.25rem 0 0 0; letter-spacing: 0.2rem;">
                    {{ session('otp_code') }}
                </p>
                <span style="font-size: 0.65rem; color: #a0aec0; display: block; margin-top: 0.25rem;">(Gunakan kode ini atau cek berkas storage/logs/laravel.log)</span>
            </div>
            @endif

            <div style="margin-top: 3rem; text-align: center;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #7e8694; font-size: 0.8rem; cursor: pointer;">
                        <i class="bi bi-box-arrow-left"></i> Keluar / Log Out
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>

</body>
</html>
