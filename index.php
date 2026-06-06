<?php
// ============================================
// index.php — Halaman Formulir Tamu
// ============================================

require_once 'koneksi.php';

$pesan   = '';
$tipe    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim(mysqli_real_escape_string($koneksi, $_POST['nama']));
    $instansi = trim(mysqli_real_escape_string($koneksi, $_POST['instansi']));
    $tujuan   = trim(mysqli_real_escape_string($koneksi, $_POST['tujuan']));
    $tanggal  = date('Y-m-d');   // Otomatis hari ini
    $waktu    = date('H:i:s');   // Otomatis jam sekarang

    if ($nama === '' || $instansi === '' || $tujuan === '') {
        $pesan = 'Semua field wajib diisi!';
        $tipe  = 'danger';
    } else {
        $sql = "INSERT INTO buku_tamu (nama, instansi, tujuan, tanggal, waktu)
                VALUES ('$nama', '$instansi', '$tujuan', '$tanggal', '$waktu')";

        if (mysqli_query($koneksi, $sql)) {
            $pesan = 'Data tamu berhasil disimpan! Terima kasih telah mengisi buku tamu.';
            $tipe  = 'success';
        } else {
            $pesan = 'Gagal menyimpan data: ' . mysqli_error($koneksi);
            $tipe  = 'danger';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Buku Tamu Digital — SMKN 1 Contoh</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet" />

  <style>
    :root {
      --clr-primary:   #1a3a5c;
      --clr-accent:    #e8a020;
      --clr-light-bg:  #f0f4f8;
      --clr-card:      #ffffff;
      --clr-border:    #d0dce8;
      --clr-text:      #1e2d3d;
      --clr-muted:     #6b7e93;
      --radius:        14px;
    }

    *, *::before, *::after { box-sizing: border-box; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--clr-light-bg);
      color: var(--clr-text);
      min-height: 100vh;
    }

    /* ---- NAVBAR ---- */
    .navbar-brand-text {
      font-family: 'Lora', serif;
      font-size: 1.25rem;
      font-weight: 600;
      color: #fff !important;
      letter-spacing: .3px;
    }
    .navbar-brand-sub {
      font-size: .72rem;
      font-weight: 400;
      opacity: .8;
      display: block;
      line-height: 1;
    }
    .nav-link-custom {
      color: rgba(255,255,255,.85) !important;
      font-weight: 500;
      font-size: .9rem;
      padding: .45rem .9rem !important;
      border-radius: 8px;
      transition: background .2s, color .2s;
    }
    .nav-link-custom:hover,
    .nav-link-custom.active {
      background: rgba(255,255,255,.15);
      color: #fff !important;
    }

    /* ---- HERO ---- */
    .hero {
      background: linear-gradient(135deg, var(--clr-primary) 0%, #2a5298 100%);
      color: #fff;
      padding: 3.5rem 0 5.5rem;
      position: relative;
      overflow: hidden;
    }
    .hero::after {
      content: '';
      position: absolute;
      bottom: -2px; left: 0; right: 0;
      height: 60px;
      background: var(--clr-light-bg);
      clip-path: ellipse(55% 100% at 50% 100%);
    }
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: .4rem;
      background: rgba(232,160,32,.25);
      border: 1px solid rgba(232,160,32,.5);
      color: var(--clr-accent);
      font-size: .78rem;
      font-weight: 700;
      letter-spacing: .6px;
      text-transform: uppercase;
      padding: .3rem .8rem;
      border-radius: 100px;
      margin-bottom: 1rem;
    }
    .hero h1 {
      font-family: 'Lora', serif;
      font-size: clamp(1.8rem, 4vw, 2.8rem);
      font-weight: 700;
      line-height: 1.25;
    }
    .hero p { opacity: .85; max-width: 520px; }

    /* ---- FORM CARD ---- */
    .form-card {
      background: var(--clr-card);
      border-radius: var(--radius);
      box-shadow: 0 4px 30px rgba(26,58,92,.1);
      padding: 2.2rem 2.5rem;
      margin-top: -3.5rem;
      position: relative;
      z-index: 10;
    }
    .form-card-title {
      font-family: 'Lora', serif;
      font-size: 1.35rem;
      font-weight: 600;
      color: var(--clr-primary);
      margin-bottom: 1.6rem;
      display: flex;
      align-items: center;
      gap: .6rem;
    }
    .form-label {
      font-weight: 600;
      font-size: .85rem;
      color: var(--clr-primary);
      margin-bottom: .35rem;
    }
    .form-control, .form-select {
      border: 1.5px solid var(--clr-border);
      border-radius: 10px;
      padding: .65rem 1rem;
      font-size: .92rem;
      transition: border-color .2s, box-shadow .2s;
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--clr-primary);
      box-shadow: 0 0 0 3px rgba(26,58,92,.12);
    }
    textarea.form-control { resize: vertical; min-height: 110px; }

    .info-box {
      background: #eef4fb;
      border: 1px solid #c3d8ef;
      border-radius: 10px;
      padding: .8rem 1rem;
      font-size: .84rem;
      color: var(--clr-primary);
      display: flex;
      align-items: center;
      gap: .6rem;
    }

    .btn-submit {
      background: var(--clr-primary);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: .75rem 2rem;
      font-weight: 700;
      font-size: .95rem;
      letter-spacing: .3px;
      transition: background .2s, transform .15s, box-shadow .2s;
      width: 100%;
    }
    .btn-submit:hover {
      background: #153050;
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(26,58,92,.25);
      color: #fff;
    }

    /* ---- FOOTER ---- */
    footer {
      background: var(--clr-primary);
      color: rgba(255,255,255,.7);
      font-size: .82rem;
      text-align: center;
      padding: 1.2rem;
      margin-top: 3rem;
    }
    footer span { color: var(--clr-accent); }

    /* ---- ALERT ---- */
    .alert { border-radius: 10px; font-size: .9rem; }

    @media (max-width: 576px) {
      .form-card { padding: 1.5rem 1.2rem; }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg" style="background:var(--clr-primary);">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
      <i class="bi bi-building fs-4 text-warning"></i>
      <div>
        <span class="navbar-brand-text">SMKN 1 Contoh</span>
        <span class="navbar-brand-sub">Buku Tamu Digital</span>
      </div>
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <i class="bi bi-list text-white fs-4"></i>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto gap-1">
        <li class="nav-item">
          <a class="nav-link-custom active" href="index.php">
            <i class="bi bi-pencil-square me-1"></i>Form Tamu
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link-custom" href="daftar_tamu.php">
            <i class="bi bi-people me-1"></i>Daftar Tamu
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="container">
    <div class="hero-badge"><i class="bi bi-stars"></i> Selamat Datang</div>
    <h1>Buku Tamu Digital<br>Sekolah Kami</h1>
    <p class="mt-2 mb-0">Silakan isi formulir di bawah ini sebagai tanda kunjungan Anda. Data Anda tersimpan dengan aman.</p>
  </div>
</section>

<!-- FORM SECTION -->
<section class="pb-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7 col-md-9">

        <?php if ($pesan): ?>
          <div class="alert alert-<?= $tipe ?> alert-dismissible fade show mt-4" role="alert">
            <i class="bi bi-<?= $tipe === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill' ?> me-2"></i>
            <?= htmlspecialchars($pesan) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <div class="form-card">
          <div class="form-card-title">
            <i class="bi bi-clipboard2-pulse text-warning"></i>
            Formulir Kunjungan Tamu
          </div>

          <form method="POST" action="index.php" novalidate>

            <!-- Nama Lengkap -->
            <div class="mb-3">
              <label class="form-label" for="nama">
                <i class="bi bi-person me-1"></i>Nama Lengkap <span class="text-danger">*</span>
              </label>
              <input type="text" class="form-control" id="nama" name="nama"
                     placeholder="Masukkan nama lengkap Anda"
                     value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>"
                     required />
            </div>

            <!-- Instansi -->
            <div class="mb-3">
              <label class="form-label" for="instansi">
                <i class="bi bi-building me-1"></i>Instansi / Asal Lembaga <span class="text-danger">*</span>
              </label>
              <input type="text" class="form-control" id="instansi" name="instansi"
                     placeholder="Nama perusahaan, sekolah, atau lembaga"
                     value="<?= isset($_POST['instansi']) ? htmlspecialchars($_POST['instansi']) : '' ?>"
                     required />
            </div>

            <!-- Tujuan Kedatangan -->
            <div class="mb-3">
              <label class="form-label" for="tujuan">
                <i class="bi bi-chat-left-text me-1"></i>Tujuan Kedatangan <span class="text-danger">*</span>
              </label>
              <textarea class="form-control" id="tujuan" name="tujuan"
                        placeholder="Jelaskan keperluan kunjungan Anda..."
                        required><?= isset($_POST['tujuan']) ? htmlspecialchars($_POST['tujuan']) : '' ?></textarea>
            </div>

            <!-- Tanggal & Waktu Otomatis -->
            <div class="mb-4">
              <div class="info-box">
                <i class="bi bi-clock-history fs-5 text-primary"></i>
                <div>
                  <strong>Tanggal &amp; Waktu Kedatangan</strong> akan diisi otomatis saat Anda menekan tombol kirim.<br>
                  <span class="text-muted">Sekarang: <strong><?= date('d F Y, H:i') ?> WIB</strong></span>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-submit">
              <i class="bi bi-send-fill me-2"></i>Kirim Data Kunjungan
            </button>

          </form>
        </div><!-- /form-card -->

      </div>
    </div>
  </div>
</section>

<footer>
  &copy; <?= date('Y') ?> <span>SMKN 1 Contoh</span> — Buku Tamu Digital. Dibuat dengan PHP &amp; Bootstrap 5.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
