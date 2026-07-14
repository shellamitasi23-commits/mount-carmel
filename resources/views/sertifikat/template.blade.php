<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sertifikat Kepemilikan Lahan Pemakaman — Mount Carmel</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600;1,700&family=Cormorant+Garamond:ital,wght@0,400;0,500;1,400;1,500;1,600&family=JetBrains+Mono:wght@400&display=swap');

:root{
  --maroon-deep:#5C1622;
  --maroon:#7A1F2C;
  --gold:#B8925A;
  --gold-bright:#D4AF6A;
  --ivory:#FAF5E9;
  --ink-soft:#6B5F50;
  --near-black:#1E1A16;
}

*{ box-sizing:border-box; }
html,body{ margin:0; padding:0; background:#FAF5E9; font-family:'Cormorant Garamond', serif; color:var(--maroon-deep); }

.page{
  width:1122px; height:794px; margin:0 auto;
  background:var(--ivory);
  position:relative; overflow:hidden;
}

.paper-texture{
  position:absolute; inset:0; pointer-events:none;
  background:
    radial-gradient(ellipse at 15% 10%, rgba(184,146,90,0.05), transparent 40%),
    radial-gradient(ellipse at 88% 92%, rgba(122,31,44,0.04), transparent 45%);
}

.hairline{ position:absolute; inset:15px; border:0.8px solid var(--near-black); pointer-events:none; }
.frame-main{ position:absolute; inset:30px; border:3.5px solid var(--maroon); pointer-events:none; }
.frame-inner{ position:absolute; inset:36px; border:0.7px solid var(--maroon); pointer-events:none; }

.content{
  position:absolute; inset:60px 83px;
  display:flex; flex-direction:column; align-items:center;
  text-align:center;
  height:calc(100% - 120px);
}

/* wordmark */
.wordmark{ display:flex; flex-direction:column; align-items:center; margin-top:8px; }
.wordmark svg{ width:75px; height:45px; }
.wordmark .name{
  font-family:'Cinzel', serif; font-size:11pt; letter-spacing:4px; color:var(--gold);
  margin-top:4px; font-weight:600;
}
.wordmark .dash{ width:34px; height:1px; background:var(--gold); margin-top:6px; }

/* titles */
.subtitle{
  font-family:'Playfair Display', serif; font-weight:600; font-style:italic;
  font-size:14pt; color:var(--maroon); margin-top:15px; letter-spacing:0.4px;
}
.title{
  font-family:'Playfair Display', serif; font-weight:700;
  font-size:26pt; color:var(--maroon-deep); margin-top:4px; line-height:1.15;
  letter-spacing:0.3px;
}

/* owner name */
.owner-name{
  font-family:'Playfair Display', serif; font-style:italic; font-weight:600;
  font-size:24pt; color:var(--maroon); margin-top:25px;
}

.rule-full{
  width:100%; max-width:720px; height:1px; background:var(--gold);
  margin-top:15px; opacity:0.7;
}

/* data lines */
.data-block{ margin-top:20px; display:flex; flex-direction:column; gap:8px; }
.data-line{
  font-family:'Cormorant Garamond', serif; font-style:italic; font-weight:500;
  font-size:14pt; color:var(--maroon);
}
.data-line b{ font-style:normal; font-weight:600; color:var(--maroon-deep); }

.rule-short{
  width:220px; height:1px; background:var(--maroon); opacity:0.4; margin:4px auto;
}

/* footer / signatures */
.footer{
  margin-top:auto;
  width:100%; max-width:800px;
  display:grid; grid-template-columns:1fr auto 1fr;
  align-items:end; column-gap:40px;
  padding-bottom:10px;
}
.sign-block{ text-align:center; display:flex; flex-direction:column; align-items:center; width:100%; }
.sign-space{ height:65px; display:flex; align-items:center; justify-content:center; position:relative; width:100%; }
.sign-img{ max-height:60px; max-width:170px; object-fit:contain; z-index:10; }
.sign-line{ border-top:0.8px solid var(--ink-soft); padding-top:6px; width:80%; margin:0 auto; }
.sign-role{
  font-family:'Cormorant Garamond', serif; font-style:italic; font-size:10.5pt; color:var(--ink-soft);
}
.sign-name{
  font-family:'Cormorant Garamond', serif; font-weight:600; font-size:11pt; color:var(--near-black);
  margin-bottom:2px;
}

.medallion{ display:flex; flex-direction:column; align-items:center; }
.medallion svg{ width:98px; height:98px; }

.serial{
  position:absolute; bottom:20px; right:53px;
  font-family:'JetBrains Mono', monospace; font-size:6.5pt; color:var(--ink-soft);
  letter-spacing:1px; opacity:0.65;
}
</style>
</head>
<body>

<div class="page" id="certificate-page">
  <div class="paper-texture"></div>
  <div class="hairline"></div>
  <div class="frame-main"></div>
  <div class="frame-inner"></div>

  <div class="content">

    <div class="wordmark">
      <svg viewBox="0 0 120 70">
        <path d="M10 60 L38 20 L52 40 L68 12 L110 60 Z" fill="none" stroke="#7A1F2C" stroke-width="4" stroke-linejoin="round"/>
      </svg>
      <div class="name">MOUNT CARMEL</div>
      <div class="dash"></div>
    </div>

    <div class="subtitle">
        Mount Carmel Cluster {{ $sertifikat->reservasi->lahan->cluster->nama_cluster ?? 'Madina' }}
    </div>
    
    <div class="title">
        @if($sertifikat->nama_jenazah)
            Sertifikat Pemanfaatan<br>Lahan Pemakaman
        @else
            Sertifikat Kepemilikan<br>Lahan Pemakaman
        @endif
    </div>

    <div class="owner-name">
        @if($sertifikat->nama_jenazah)
            Alm. {{ ucwords(strtolower($sertifikat->nama_jenazah)) }}
        @else
            {{ ucwords(strtolower($sertifikat->nama_pemilik)) }}
        @endif
    </div>

    <div class="rule-full"></div>

    <div class="data-block">
      <div class="data-line"><b>Nomor Sertifikat</b> &nbsp;—&nbsp; {{ $sertifikat->nomor_sertifikat }}</div>
      <div class="rule-short"></div>
      <div class="data-line"><b>Lokasi Lahan</b> &nbsp;—&nbsp; {{ $sertifikat->lokasi_lahan }}</div>
      <div class="rule-short"></div>
      <div class="data-line"><b>Tanggal Terbitan</b> &nbsp;—&nbsp; {{ \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->translatedFormat('d F Y') }}</div>
      @if($sertifikat->nama_jenazah)
        <div class="rule-short"></div>
        <div class="data-line"><b>Pemilik Hak Lahan</b> &nbsp;—&nbsp; {{ ucwords(strtolower($sertifikat->nama_pemilik)) }}</div>
      @endif
    </div>

    <div class="footer">
      
      <div class="sign-block">
        <div class="sign-space">
          @if($sertifikat->ttd_pemilik && file_exists(storage_path('app/' . $sertifikat->ttd_pemilik)))
            <img class="sign-img" src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/' . $sertifikat->ttd_pemilik))) }}" alt="Tanda Tangan Pemilik">
          @endif
        </div>
        <div class="sign-line">
          <div class="sign-name">{{ ucwords(strtolower($sertifikat->nama_pemilik)) }}</div>
          <div class="sign-role">Pemilik Lahan</div>
        </div>
      </div>

      
      <div class="medallion">
        <svg viewBox="0 0 100 100">
          <defs>
            <path id="seal-edge" d="M50 4 L58 10 L68 6 L73 15 L84 15 L86 25 L96 30 L92 40 L98 50 L92 60 L96 70 L86 75 L84 85 L73 85 L68 94 L58 90 L50 96 L42 90 L32 94 L27 85 L16 85 L14 75 L4 70 L8 60 L2 50 L8 40 L4 30 L14 25 L16 15 L27 15 L32 6 L42 10 Z"/>
          </defs>
          <use href="#seal-edge" fill="#C9A15E" stroke="#8A6A3A" stroke-width="1"/>
          <circle cx="50" cy="50" r="34" fill="none" stroke="#8A6A3A" stroke-width="0.8"/>
          <path d="M50 30 C 42 40 42 50 50 62 C 58 50 58 40 50 30 Z" fill="none" stroke="#5C1622" stroke-width="1.4"/>
          <path d="M50 62 V 72" stroke="#5C1622" stroke-width="1.4"/>
          <path d="M50 44 C 44 42 40 44 38 48" fill="none" stroke="#5C1622" stroke-width="1.1"/>
          <path d="M50 44 C 56 42 60 44 62 48" fill="none" stroke="#5C1622" stroke-width="1.1"/>
          <path d="M50 54 C 44 52 40 54 38 58" fill="none" stroke="#5C1622" stroke-width="1.1"/>
          <path d="M50 54 C 56 52 60 54 62 58" fill="none" stroke="#5C1622" stroke-width="1.1"/>
        </svg>
      </div>

      
      <div class="sign-block">
        <div class="sign-space">
          @if($sertifikat->ttd_manajer && file_exists(storage_path('app/' . $sertifikat->ttd_manajer)))
            <img class="sign-img" src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/' . $sertifikat->ttd_manajer))) }}" alt="Tanda Tangan Manajer">
          @endif
        </div>
        <div class="sign-line">
          <div class="sign-name">Operational Manager</div>
          <div class="sign-role">Pengelola Pemakaman</div>
        </div>
      </div>
    </div>

  </div>

  <div class="serial">{{ $sertifikat->nomor_sertifikat }} / {{ $sertifikat->serial_number }}</div>
</div>

</body>
</html>
