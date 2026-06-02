<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atur Ulang Kata Sandi — Mount Carmel</title>
  <style>
    body {
      font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      background-color: #FAF8F5;
      color: #1E2229;
      margin: 0;
      padding: 0;
      -webkit-font-smoothing: antialiased;
    }
    .wrapper {
      width: 100%;
      table-layout: fixed;
      background-color: #FAF8F5;
      padding-top: 40px;
      padding-bottom: 40px;
    }
    .main-table {
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
      background-color: #FFFFFF;
      border: 1px solid #EADBCC;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(30, 34, 41, 0.05);
    }
    .header {
      background-color: #1E2229;
      padding: 30px 40px;
      text-align: center;
    }
    .header-logo {
      color: #EADBCC;
      font-size: 24px;
      font-weight: 700;
      letter-spacing: 2px;
      text-decoration: none;
      display: inline-block;
    }
    .content {
      padding: 40px;
    }
    h1 {
      font-size: 22px;
      font-weight: 700;
      color: #1E2229;
      margin-top: 0;
      margin-bottom: 20px;
    }
    p {
      font-size: 15px;
      line-height: 1.6;
      color: #4D525D;
      margin-top: 0;
      margin-bottom: 20px;
    }
    .btn-container {
      text-align: center;
      margin: 30px 0;
    }
    .btn {
      display: inline-block;
      background-color: #1E2229;
      color: #FFFFFF !important;
      text-decoration: none;
      padding: 14px 30px;
      font-size: 15px;
      font-weight: 600;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(30, 34, 41, 0.15);
    }
    .btn:hover {
      background-color: #2D323E;
    }
    .divider {
      height: 1px;
      background-color: #EADBCC;
      margin: 30px 0;
    }
    .footer {
      padding: 0 40px 40px;
      text-align: center;
      font-size: 12px;
      color: #7E8694;
      line-height: 1.5;
    }
    .footer a {
      color: #1E2229;
      text-decoration: none;
      font-weight: 600;
    }
    .meta-text {
      font-size: 12px;
      color: #7E8694;
      background-color: #FAF8F5;
      padding: 15px;
      border-radius: 8px;
      word-break: break-all;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <table class="main-table" cellpadding="0" cellspacing="0">
      <!-- HEADER -->
      <tr>
        <td class="header">
          <span class="header-logo">MOUNT CARMEL</span>
        </td>
      </tr>

      <!-- CONTENT -->
      <tr>
        <td class="content">
          <h1>Halo, {{ $name }}</h1>
          <p>Anda menerima email ini karena kami menerima permintaan untuk mengatur ulang kata sandi akun Mount Carmel Anda.</p>
          
          <div class="btn-container">
            <a href="{{ $url }}" class="btn">Atur Ulang Kata Sandi</a>
          </div>

          <p>Tautan pengaturan ulang kata sandi ini akan kedaluwarsa dalam waktu <strong>{{ $expire }} menit</strong>.</p>
          <p>Jika Anda tidak merasa melakukan permintaan ini, tidak perlu melakukan tindakan lebih lanjut. Keamanan akun Anda tetap terjaga.</p>
          
          <div class="divider"></div>
          
          <p style="font-size: 13px; color: #7E8694; margin-bottom: 8px;">Jika Anda mengalami kendala saat menekan tombol di atas, silakan salin dan tempel tautan di bawah ini ke peramban web Anda:</p>
          <div class="meta-text">
            {{ $url }}
          </div>
        </td>
      </tr>

      <!-- FOOTER -->
      <tr>
        <td class="footer">
          <p style="font-size: 12px; margin-bottom: 5px;">&copy; {{ date('Y') }} Mount Carmel. Semua Hak Dilindungi Undang-Undang.</p>
          <p style="font-size: 11px;">Ini adalah email otomatis, mohon tidak membalas email ini.</p>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>
