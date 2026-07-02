<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode OTP Verifikasi Akun</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8f9fc;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #eef2ff;
        }
        .header {
            background-color: #800000;
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .content {
            padding: 40px 30px;
            line-height: 1.6;
        }
        .content p {
            margin: 0 0 20px 0;
            font-size: 15px;
            color: #555555;
        }
        .otp-box {
            background-color: #fcfcfc;
            border: 2px dashed #800000;
            border-radius: 12px;
            text-align: center;
            padding: 20px;
            margin: 30px 0;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 6px;
            color: #800000;
            margin: 0;
        }
        .footer {
            background-color: #f8f9fc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999999;
            border-top: 1px solid #eeeeee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Mount Carmel</h1>
        </div>
        <div class="content">
            <p>Halo,</p>
            <p>Terima kasih telah mendaftar di portal Mount Carmel. Untuk menyelesaikan pendaftaran dan memverifikasi akun Anda, silakan gunakan kode OTP di bawah ini:</p>
            
            <div class="otp-box">
                <p class="otp-code">{{ $otpCode }}</p>
            </div>
            
            <p>Kode OTP ini berlaku selama 10 menit. Jangan membagikan kode ini kepada siapa pun demi keamanan akun Anda.</p>
            <p>Jika Anda tidak merasa mendaftar di portal kami, silakan abaikan email ini.</p>
            
            <p>Salam hangat,<br><strong>Tim Mount Carmel</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Mount Carmel. Hak Cipta Dilindungi.
        </div>
    </div>
</body>
</html>
