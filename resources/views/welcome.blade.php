<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMPELAJU — Sistem Pendukung Keputusan RTLH</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cream:   #F6F3EE;
            --paper:   #EDEAE3;
            --forest:  #1A3A2A;
            --forest2: #274D39;
            --amber:   #B5850A;
            --amber-lt:#D4A017;
            --muted:   #6B6659;
            --border:  #D8D4CB;
            --white:   #FFFFFF;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--cream);
            color: var(--forest);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            line-height: 1.7;
            overflow-x: hidden;
        }

        /* ─── NAV ─────────────────────────────────────────── */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 48px;
            background: rgba(246,243,238,0.88);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }

        .nav-brand {
            font-family: 'Lora', serif;
            font-weight: 700;
            font-size: 18px;
            letter-spacing: -0.3px;
            color: var(--forest);
            text-decoration: none;
        }

        .nav-brand span { color: var(--amber); }

        .nav-right { display: flex; align-items: center; gap: 12px; }

        .btn-ghost {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: var(--muted);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            transition: color .2s, background .2s;
        }
        .btn-ghost:hover { color: var(--forest); background: var(--paper); }

        .btn-primary {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: var(--white);
            background: var(--forest);
            text-decoration: none;
            padding: 9px 22px;
            border-radius: 6px;
            border: none; cursor: pointer;
            transition: background .2s, transform .15s;
        }
        .btn-primary:hover { background: var(--forest2); transform: translateY(-1px); }

        /* ─── HERO ────────────────────────────────────────── */
        .hero {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            padding-top: 76px;
        }

        .hero-left {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px 64px 80px 48px;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--amber);
            margin-bottom: 24px;
        }

        .hero-eyebrow::before {
            content: '';
            display: block;
            width: 24px; height: 1px;
            background: var(--amber);
        }

        h1 {
            font-family: 'Lora', serif;
            font-size: clamp(38px, 4.5vw, 58px);
            font-weight: 700;
            line-height: 1.15;
            letter-spacing: -0.5px;
            color: var(--forest);
            margin-bottom: 20px;
        }

        h1 em {
            font-style: italic;
            color: var(--amber);
        }

        .hero-desc {
            font-size: 15px;
            font-weight: 400;
            color: var(--muted);
            line-height: 1.75;
            max-width: 400px;
            margin-bottom: 40px;
        }

        .hero-cta {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-hero {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: var(--white);
            background: var(--forest);
            text-decoration: none;
            padding: 13px 30px;
            border-radius: 8px;
            transition: background .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 2px 12px rgba(26,58,42,0.18);
        }
        .btn-hero:hover { background: var(--forest2); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(26,58,42,0.22); }

        .hero-note {
            font-size: 13px;
            color: var(--muted);
        }

        .hero-note strong {
            font-weight: 600;
            color: var(--forest);
        }

        .hero-right {
            background: var(--forest);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Map-like decorative grid */
        .hero-right::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .hero-right::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            border: 1px solid rgba(181,133,10,0.25);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 0 60px rgba(181,133,10,0.04),
                        0 0 0 120px rgba(181,133,10,0.025);
        }

        .hero-visual {
            position: relative; z-index: 2;
            text-align: center;
        }

        .hero-badge {
            display: inline-block;
            font-family: 'Lora', serif;
            font-size: clamp(56px, 7vw, 86px);
            font-weight: 700;
            color: var(--white);
            letter-spacing: -2px;
            line-height: 1;
            margin-bottom: 16px;
        }

        .hero-badge-sub {
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.45);
        }

        /* ─── TAGS ────────────────────────────────────────── */
        .tags-bar {
            background: var(--forest);
            padding: 14px 48px;
            display: flex;
            align-items: center;
            gap: 32px;
            overflow-x: auto;
        }

        .tag-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.5px;
            color: rgba(255,255,255,0.55);
            white-space: nowrap;
        }

        .tag-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: var(--amber-lt);
            flex-shrink: 0;
        }

        /* ─── SECTION BASE ────────────────────────────────── */
        section { padding: 96px 48px; }

        .section-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--amber);
            margin-bottom: 12px;
        }

        h2 {
            font-family: 'Lora', serif;
            font-size: clamp(28px, 3vw, 40px);
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.3px;
            color: var(--forest);
            margin-bottom: 16px;
        }

        .section-desc {
            font-size: 15px;
            color: var(--muted);
            max-width: 520px;
            line-height: 1.75;
        }

        /* ─── ABOUT ───────────────────────────────────────── */
        .about {
            background: var(--white);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .about-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1px;
            background: var(--border);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .stat-cell {
            background: var(--white);
            padding: 32px 28px;
        }

        .stat-num {
            font-family: 'Lora', serif;
            font-size: 36px;
            font-weight: 700;
            color: var(--forest);
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-num span { color: var(--amber); }

        .stat-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ─── KRITERIA ────────────────────────────────────── */
        .kriteria { background: var(--cream); }

        .kriteria-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 48px;
        }

        .kriteria-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1px;
            background: var(--border);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .kriteria-card {
            background: var(--white);
            padding: 28px 24px;
            transition: background .2s;
        }
        .kriteria-card:hover { background: #F9F7F3; }

        .kriteria-num {
            font-family: 'Lora', serif;
            font-size: 13px;
            font-weight: 600;
            color: var(--amber);
            margin-bottom: 12px;
        }

        .kriteria-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--forest);
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .kriteria-meta {
            font-size: 12px;
            color: var(--muted);
        }

        .kriteria-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            margin-top: 12px;
        }

        .kriteria-tag {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.3px;
            padding: 3px 8px;
            border-radius: 3px;
            background: var(--paper);
            color: var(--muted);
        }

        /* ─── ALUR ────────────────────────────────────────── */
        .alur { background: var(--forest); }

        .alur .section-label { color: var(--amber-lt); }
        .alur h2 { color: var(--white); }
        .alur .section-desc { color: rgba(255,255,255,0.5); }

        .alur-steps {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 0;
            margin-top: 56px;
            position: relative;
        }

        .alur-steps::before {
            content: '';
            position: absolute;
            top: 24px; left: 48px; right: 48px;
            height: 1px;
            background: rgba(255,255,255,0.12);
        }

        .step {
            padding: 0 12px;
            text-align: center;
        }

        .step-icon {
            width: 48px; height: 48px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            font-family: 'Lora', serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--amber-lt);
            position: relative; z-index: 1;
        }

        .step-title {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.9);
            margin-bottom: 6px;
        }

        .step-desc {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            line-height: 1.6;
        }

        /* ─── FITUR ───────────────────────────────────────── */
        .fitur { background: var(--paper); }

        .fitur-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-top: 48px;
        }

        .fitur-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 32px 28px;
            transition: transform .2s, box-shadow .2s;
        }
        .fitur-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(26,58,42,0.08); }

        .fitur-icon {
            width: 40px; height: 40px;
            background: var(--forest);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px;
        }

        .fitur-icon svg { width: 20px; height: 20px; }

        .fitur-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--forest);
            margin-bottom: 8px;
        }

        .fitur-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.7;
        }

        /* ─── CTA ─────────────────────────────────────────── */
        .cta-section {
            background: var(--cream);
            padding: 96px 48px;
            text-align: center;
            border-top: 1px solid var(--border);
        }

        .cta-box {
            max-width: 560px;
            margin: 0 auto;
        }

        .cta-section h2 { margin-bottom: 16px; }
        .cta-section .section-desc { margin: 0 auto 36px; text-align: center; }

        /* ─── FOOTER ──────────────────────────────────────── */
        footer {
            background: var(--forest);
            padding: 40px 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .footer-brand {
            font-family: 'Lora', serif;
            font-weight: 700;
            font-size: 15px;
            color: var(--white);
        }

        .footer-brand span { color: var(--amber-lt); }

        .footer-meta {
            font-size: 12px;
            color: rgba(255,255,255,0.35);
        }

        /* ─── RESPONSIVE ──────────────────────────────────── */
        @media (max-width: 900px) {
            nav { padding: 16px 24px; }
            .hero { grid-template-columns: 1fr; min-height: auto; }
            .hero-right { min-height: 280px; }
            .hero-left { padding: 60px 24px 40px; }
            .about { grid-template-columns: 1fr; gap: 40px; padding: 60px 24px; }
            .kriteria-header { flex-direction: column; align-items: flex-start; gap: 16px; }
            .alur-steps { grid-template-columns: 1fr 1fr; gap: 32px; }
            .alur-steps::before { display: none; }
            .fitur-grid { grid-template-columns: 1fr 1fr; }
            section { padding: 60px 24px; }
            .tags-bar { padding: 14px 24px; }
            footer { flex-direction: column; gap: 12px; text-align: center; padding: 32px 24px; }
        }

        @media (max-width: 600px) {
            .fitur-grid { grid-template-columns: 1fr; }
            .alur-steps { grid-template-columns: 1fr; }
            h1 { font-size: 32px; }
        }

        /* ─── ANIMATION ───────────────────────────────────── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .hero-left > * {
            animation: fadeUp .6s ease both;
        }
        .hero-eyebrow { animation-delay: .1s; }
        h1 { animation-delay: .2s; }
        .hero-desc { animation-delay: .3s; }
        .hero-cta { animation-delay: .4s; }
    </style>
</head>
<body>

    <!-- NAV -->
    <nav>
        <a href="#" class="nav-brand">SIMPEL<span>AJU</span></a>
        <div class="nav-right">
            <a href="#tentang" class="btn-ghost">Tentang</a>
            <a href="#fitur" class="btn-ghost">Fitur</a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">Masuk</a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero" style="padding:0;">
        <div class="hero-left">
            <div class="hero-eyebrow">Kecamatan Plaju · Kota Palembang</div>
            <h1>Keputusan <em>Adil</em> untuk Bantuan Rumah Layak</h1>
            <p class="hero-desc">
                Platform digital berbasis Fuzzy Mamdani dan Web GIS untuk menentukan kelayakan penerima bantuan Rumah Tidak Layak Huni (RTLH) secara objektif dan transparan.
            </p>
            <div class="hero-cta">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-hero">Buka Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-hero">Masuk ke Sistem</a>
                    @endauth
                @else
                    <a href="#" class="btn-hero">Masuk ke Sistem</a>
                @endif
                <span class="hero-note">SPK RTLH &mdash; <strong>Menggantikan proses Excel</strong></span>
            </div>
        </div>
        <div class="hero-right">
            <div class="hero-visual">
                <div class="hero-badge">SPK</div>
                <div class="hero-badge-sub">Sistem Pendukung Keputusan · RTLH</div>
            </div>
        </div>
    </section>

    <!-- TAGS BAR -->
    <div class="tags-bar">
        <div class="tag-item"><span class="tag-dot"></span> Fuzzy Mamdani</div>
        <div class="tag-item"><span class="tag-dot"></span> Web GIS · Leaflet.js</div>
        <div class="tag-item"><span class="tag-dot"></span> Laravel 12</div>
        <div class="tag-item"><span class="tag-dot"></span> 7 Variabel Kriteria</div>
        <div class="tag-item"><span class="tag-dot"></span> Export PDF & Excel</div>
        <div class="tag-item"><span class="tag-dot"></span> Transparan & Akuntabel</div>
    </div>

    <!-- ABOUT -->
    <section class="about" id="tentang">
        <div>
            <div class="section-label">Tentang Sistem</div>
            <h2>Dari Excel manual ke platform yang terstruktur</h2>
            <p class="section-desc">
                SIMPELAJU menggantikan proses penilaian RTLH berbasis spreadsheet menjadi sistem digital yang menggunakan logika fuzzy untuk menangani ketidakpastian data lapangan — lebih adil, lebih cepat, lebih dapat dipertanggungjawabkan.
            </p>
        </div>
        <div class="about-stats">
            <div class="stat-cell">
                <div class="stat-num">7<span>+</span></div>
                <div class="stat-label">Variabel Kriteria</div>
            </div>
            <div class="stat-cell">
                <div class="stat-num">7</div>
                <div class="stat-label">Kelurahan di Kec. Plaju</div>
            </div>
            <div class="stat-cell">
                <div class="stat-num">0<span>–1</span></div>
                <div class="stat-label">Derajat Keanggotaan</div>
            </div>
            <div class="stat-cell">
                <div class="stat-num">GIS</div>
                <div class="stat-label">Peta Interaktif</div>
            </div>
        </div>
    </section>

    <!-- KRITERIA -->
    <section class="kriteria">
        <div class="kriteria-header">
            <div>
                <div class="section-label">Variabel Penilaian</div>
                <h2>7 Kriteria Kelayakan RTLH</h2>
            </div>
            <p class="section-desc" style="margin-bottom:0;">Setiap variabel diproses menggunakan himpunan fuzzy untuk menghasilkan nilai derajat keanggotaan yang akurat.</p>
        </div>
        <div class="kriteria-grid">
            <div class="kriteria-card">
                <div class="kriteria-num">01</div>
                <div class="kriteria-title">Kondisi Atap</div>
                <div class="kriteria-meta">Skor 0–100</div>
                <div class="kriteria-tags">
                    <span class="kriteria-tag">Buruk</span>
                    <span class="kriteria-tag">Sedang</span>
                    <span class="kriteria-tag">Baik</span>
                </div>
            </div>
            <div class="kriteria-card">
                <div class="kriteria-num">02</div>
                <div class="kriteria-title">Kondisi Dinding</div>
                <div class="kriteria-meta">Skor 0–100</div>
                <div class="kriteria-tags">
                    <span class="kriteria-tag">Buruk</span>
                    <span class="kriteria-tag">Sedang</span>
                    <span class="kriteria-tag">Baik</span>
                </div>
            </div>
            <div class="kriteria-card">
                <div class="kriteria-num">03</div>
                <div class="kriteria-title">Kondisi Lantai</div>
                <div class="kriteria-meta">Skor 0–100</div>
                <div class="kriteria-tags">
                    <span class="kriteria-tag">Buruk</span>
                    <span class="kriteria-tag">Sedang</span>
                    <span class="kriteria-tag">Baik</span>
                </div>
            </div>
            <div class="kriteria-card">
                <div class="kriteria-num">04</div>
                <div class="kriteria-title">Luas Bangunan</div>
                <div class="kriteria-meta">0–100 m²</div>
                <div class="kriteria-tags">
                    <span class="kriteria-tag">Kecil</span>
                    <span class="kriteria-tag">Sedang</span>
                    <span class="kriteria-tag">Luas</span>
                </div>
            </div>
            <div class="kriteria-card">
                <div class="kriteria-num">05</div>
                <div class="kriteria-title">Penghasilan</div>
                <div class="kriteria-meta">0–5.000.000 Rp/bln</div>
                <div class="kriteria-tags">
                    <span class="kriteria-tag">Rendah</span>
                    <span class="kriteria-tag">Sedang</span>
                    <span class="kriteria-tag">Tinggi</span>
                </div>
            </div>
            <div class="kriteria-card">
                <div class="kriteria-num">06</div>
                <div class="kriteria-title">Jumlah Tanggungan</div>
                <div class="kriteria-meta">0–10 orang</div>
                <div class="kriteria-tags">
                    <span class="kriteria-tag">Sedikit</span>
                    <span class="kriteria-tag">Sedang</span>
                    <span class="kriteria-tag">Banyak</span>
                </div>
            </div>
            <div class="kriteria-card">
                <div class="kriteria-num">07</div>
                <div class="kriteria-title">Status Kepemilikan</div>
                <div class="kriteria-meta">Skor 0–100</div>
                <div class="kriteria-tags">
                    <span class="kriteria-tag">Tidak Milik</span>
                    <span class="kriteria-tag">Sewa</span>
                    <span class="kriteria-tag">Milik Sendiri</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ALUR -->
    <section class="alur">
        <div style="max-width:900px; margin:0 auto; text-align:center;">
            <div class="section-label">Cara Kerja</div>
            <h2 style="color:white;">Tahapan Metode Fuzzy Mamdani</h2>
            <p class="section-desc" style="margin:0 auto;">Lima tahap sistematis dari input data mentah hingga keputusan kelayakan yang dapat dipertanggungjawabkan.</p>
        </div>
        <div class="alur-steps" style="max-width:900px; margin:56px auto 0;">
            <div class="step">
                <div class="step-icon">1</div>
                <div class="step-title">Input Crisp</div>
                <div class="step-desc">Entri data lapangan dari 7 variabel kriteria RTLH</div>
            </div>
            <div class="step">
                <div class="step-icon">2</div>
                <div class="step-title">Fuzzifikasi</div>
                <div class="step-desc">Konversi nilai tegas menjadi derajat keanggotaan fuzzy</div>
            </div>
            <div class="step">
                <div class="step-icon">3</div>
                <div class="step-title">Rule Base</div>
                <div class="step-desc">Evaluasi aturan IF–THEN berdasarkan kombinasi variabel</div>
            </div>
            <div class="step">
                <div class="step-icon">4</div>
                <div class="step-title">Inferensi</div>
                <div class="step-desc">Komposisi aturan dengan operator MAX–MIN</div>
            </div>
            <div class="step">
                <div class="step-icon">5</div>
                <div class="step-title">Defuzzifikasi</div>
                <div class="step-desc">Centroid method menghasilkan nilai crisp akhir</div>
            </div>
            <div class="step">
                <div class="step-icon">6</div>
                <div class="step-title">Output Keputusan</div>
                <div class="step-desc">Nilai 0–50: Tidak Layak · Nilai 51–100: Layak</div>
            </div>
        </div>
    </section>

    <!-- FITUR -->
    <section class="fitur" id="fitur">
        <div style="max-width:600px;">
            <div class="section-label">Fitur Utama</div>
            <h2>Satu platform, semua kebutuhan</h2>
        </div>
        <div class="fitur-grid">
            <div class="fitur-card">
                <div class="fitur-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/>
                    </svg>
                </div>
                <div class="fitur-title">Manajemen Data Penduduk & Rumah</div>
                <div class="fitur-desc">Input, edit, dan kelola data penduduk beserta kondisi rumah dari 7 variabel kriteria RTLH secara terpusat.</div>
            </div>
            <div class="fitur-card">
                <div class="fitur-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20"/>
                    </svg>
                </div>
                <div class="fitur-title">Peta Web GIS Interaktif</div>
                <div class="fitur-desc">Visualisasi sebaran rumah penerima bantuan di peta Kecamatan Plaju berbasis Leaflet.js dan OpenStreetMap.</div>
            </div>
            <div class="fitur-card">
                <div class="fitur-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                </div>
                <div class="fitur-title">Kalkulasi Fuzzy Otomatis</div>
                <div class="fitur-desc">Engine Fuzzy Mamdani berbasis PHP memproses data dan menghasilkan nilai kelayakan secara real-time.</div>
            </div>
            <div class="fitur-card">
                <div class="fitur-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/>
                    </svg>
                </div>
                <div class="fitur-title">Dashboard & Statistik</div>
                <div class="fitur-desc">Ringkasan data, grafik distribusi kelayakan, dan rekap kecamatan dalam tampilan dashboard yang informatif.</div>
            </div>
            <div class="fitur-card">
                <div class="fitur-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                </div>
                <div class="fitur-title">Hak Akses Berbasis Role</div>
                <div class="fitur-desc">Tiga level pengguna — Admin, Operator, dan Viewer — dengan hak akses yang terpisah dan terkelola.</div>
            </div>
            <div class="fitur-card">
                <div class="fitur-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                </div>
                <div class="fitur-title">Export PDF & Excel</div>
                <div class="fitur-desc">Ekspor laporan resmi ke PDF siap cetak atau ke Excel (.xlsx) untuk arsip dan pelaporan dinas.</div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="cta-box">
            <div class="section-label" style="text-align:center;">Mulai Sekarang</div>
            <h2>Siap mendigitalisasi penilaian RTLH?</h2>
            <p class="section-desc">Masuk ke sistem menggunakan akun yang telah diberikan oleh administrator untuk mulai mengelola dan menilai data warga.</p>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-hero">Buka Dashboard →</a>
                @else
                    <a href="{{ route('login') }}" class="btn-hero">Masuk ke SIMPELAJU →</a>
                @endauth
            @else
                <a href="#" class="btn-hero">Masuk ke SIMPELAJU →</a>
            @endif
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-brand">SIMPEL<span>AJU</span></div>
        <div class="footer-meta">SPK RTLH Fuzzy Mamdani · Kecamatan Plaju, Kota Palembang · Laravel 12</div>
    </footer>

</body>
</html>