<?php
// ============================================
// daftar_tamu.php — Halaman Daftar Tamu
// ============================================

require_once 'koneksi.php';

// ---- Pencarian ----
$keyword = '';
$where   = '';
if (!empty($_GET['cari'])) {
    $keyword = trim(mysqli_real_escape_string($koneksi, $_GET['cari']));
    $where   = "WHERE nama LIKE '%$keyword%' OR instansi LIKE '%$keyword%'";
}

$sql   = "SELECT * FROM buku_tamu $where ORDER BY tanggal DESC, waktu DESC";
$hasil = mysqli_query($koneksi, $sql);
$total = mysqli_num_rows($hasil);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Tamu — SMKN 1 Contoh</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet" />

  <style>
    :root {
      --clr-primary:  #1a3a5c;
      --clr-accent:   #e8a020;
      --clr-light-bg: #f0f4f8;
      --clr-card:     #ffffff;
      --clr-border:   #d0dce8;
      --clr-text:     #1e2d3d;
      --clr-muted:    #6b7e93;
      --radius:       14px;
    }
    *, *::before, *::after { box-sizing: border-box; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--clr-light-bg);
      color: var(--clr-text);
      min-height: 100vh;
    }

    /* NAVBAR */
    .navbar-brand-text {
      font-family: 'Lora', serif;
      font-size: 1.25rem;
      font-weight: 600;
      color: #fff !important;
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
      transition: background .2s;
    }
    .nav-link-custom:hover,
    .nav-link-custom.active {
      background: rgba(255,255,255,.15);
      color: #fff !important;
    }

    /* HERO */
    .hero {
      background: linear-gradient(135deg, var(--clr-primary) 0%, #2a5298 100%);
      color: #fff;
      padding: 3rem 0 5rem;
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
      margin-bottom: .8rem;
    }
    .hero h1 {
      font-family: 'Lora', serif;
      font-size: clamp(1.6rem, 3.5vw, 2.4rem);
      font-weight: 700;
    }

    /* MAIN CARD */
    .main-card {
      background: var(--clr-card);
      border-radius: var(--radius);
      box-shadow: 0 4px 30px rgba(26,58,92,.1);
      padding: 1.8rem 2rem;
      margin-top: -3rem;
      position: relative;
      z-index: 10;
    }

    /* SEARCH */
    .search-wrap .form-control {
      border: 1.5px solid var(--clr-border);
      border-radius: 10px 0 0 10px;
      padding: .65rem 1rem;
      font-size: .9rem;
    }
    .search-wrap .form-control:focus {
      border-color: var(--clr-primary);
      box-shadow: 0 0 0 3px rgba(26,58,92,.1);
    }
    .search-wrap .btn-search {
      background: var(--clr-primary);
      color: #fff;
      border: none;
      border-radius: 0 10px 10px 0;
      padding: .65rem 1.2rem;
      font-weight: 600;
      transition: background .2s;
    }
    .search-wrap .btn-search:hover { background: #153050; }
    .btn-reset {
      border-radius: 10px;
      font-size: .85rem;
      font-weight: 600;
    }

    /* BADGE TOTAL */
    .badge-total {
      background: #eef4fb;
      color: var(--clr-primary);
      border: 1px solid #c3d8ef;
      border-radius: 8px;
      padding: .3rem .75rem;
      font-size: .82rem;
      font-weight: 700;
    }

    /* TABLE */
    .table-wrapper { overflow-x: auto; }
    .table {
      font-size: .88rem;
      margin-bottom: 0;
      border-collapse: separate;
      border-spacing: 0;
    }
    .table thead th {
      background: var(--clr-primary);
      color: #fff;
      font-weight: 700;
      font-size: .8rem;
      letter-spacing: .4px;
      text-transform: uppercase;
      padding: .85rem 1rem;
      border: none;
      white-space: nowrap;
    }
    .table thead th:first-child { border-radius: 10px 0 0 0; }
    .table thead th:last-child  { border-radius: 0 10px 0 0; }
    .table tbody tr {
      transition: background .15s;
    }
    .table-striped > tbody > tr:nth-of-type(odd) > * {
      background-color: #f7fafd;
    }
    .table-hover > tbody > tr:hover > * {
      background-color: #deeaf7 !important;
    }
    .table tbody td {
      padding: .8rem 1rem;
      vertical-align: middle;
      border-bottom: 1px solid #e8eef5;
      color: var(--clr-text);
    }
    .badge-no {
      background: var(--clr-primary);
      color: #fff;
      border-radius: 6px;
      padding: .2rem .55rem;
      font-size: .78rem;
      font-weight: 700;
    }
    .text-tujuan {
      max-width: 260px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      color: var(--clr-muted);
    }
    .highlight {
      background: #fff3cd;
      border-radius: 3px;
      padding: 0 2px;
    }

    /* EMPTY STATE */
    .empty-state {
      text-align: center;
      padding: 3rem 1rem;
      color: var(--clr-muted);
    }
    .empty-state i { font-size: 3rem; opacity: .4; }

    /* FOOTER */
    footer {
      background: var(--clr-primary);
      color: rgba(255,255,255,.7);
      font-size: .82rem;
      text-align: center;
      padding: 1.2rem;
      margin-top: 3rem;
    }
    footer span { color: var(--clr-accent); }

    @media (max-width: 576px) {
      .main-card { padding: 1.2rem 1rem; }
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
          <a class="nav-link-custom" href="index.php">
            <i class="bi bi-pencil-square me-1"></i>Form Tamu
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link-custom active" href="daftar_tamu.php">
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
    <div class="hero-badge"><i class="bi bi-list-check"></i> Rekapitulasi</div>
    <h1>Daftar Tamu Sekolah</h1>
    <p class="mt-2 mb-0" style="opacity:.85">Seluruh data kunjungan tercatat secara digital dan terurut berdasarkan waktu terbaru.</p>
  </div>
</section>

<!-- MAIN -->
<section class="pb-5">
  <div class="container">
    <div class="main-card">

      <!-- Toolbar -->
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <!-- Search -->
        <form method="GET" action="daftar_tamu.php" class="d-flex gap-2 flex-wrap align-items-center">
          <div class="input-group search-wrap" style="max-width:380px;">
            <input type="text" class="form-control" name="cari"
                   placeholder="Cari nama atau instansi..."
                   value="<?= htmlspecialchars($keyword) ?>" />
            <button type="submit" class="btn-search">
              <i class="bi bi-search"></i>
            </button>
          </div>
          <?php if ($keyword): ?>
            <a href="daftar_tamu.php" class="btn btn-outline-secondary btn-reset">
              <i class="bi bi-x-circle me-1"></i>Reset
            </a>
          <?php endif; ?>
        </form>

        <!-- Kanan -->
        <div class="d-flex align-items-center gap-2">
          <span class="badge-total">
            <i class="bi bi-people-fill me-1"></i>
            <?= $total ?> Tamu<?= $keyword ? " ditemukan" : " terdaftar" ?>
          </span>
          <a href="index.php" class="btn btn-sm" style="background:var(--clr-primary);color:#fff;border-radius:8px;font-weight:600;">
            <i class="bi bi-plus-lg me-1"></i>Tambah Tamu
          </a>
        </div>
      </div>

      <!-- Pesan pencarian -->
      <?php if ($keyword): ?>
        <div class="alert alert-info py-2 px-3 mb-3" style="font-size:.85rem;border-radius:8px;">
          <i class="bi bi-info-circle me-1"></i>
          Menampilkan hasil pencarian untuk: <strong>"<?= htmlspecialchars($keyword) ?>"</strong>
        </div>
      <?php endif; ?>

      <!-- TABLE -->
      <div class="table-wrapper">
        <table class="table table-striped table-hover align-middle">
          <thead>
            <tr>
              <th style="width:50px">#</th>
              <th><i class="bi bi-person me-1"></i>Nama Lengkap</th>
              <th><i class="bi bi-building me-1"></i>Instansi</th>
              <th><i class="bi bi-chat-left-text me-1"></i>Tujuan Kedatangan</th>
              <th><i class="bi bi-calendar3 me-1"></i>Tanggal</th>
              <th><i class="bi bi-clock me-1"></i>Waktu</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($total > 0): ?>
              <?php $no = 1; while ($row = mysqli_fetch_assoc($hasil)): ?>
                <tr>
                  <td><span class="badge-no"><?= $no++ ?></span></td>
                  <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td>
                  <td><?= htmlspecialchars($row['instansi']) ?></td>
                  <td>
                    <span class="text-tujuan" title="<?= htmlspecialchars($row['tujuan']) ?>">
                      <?= htmlspecialchars($row['tujuan']) ?>
                    </span>
                  </td>
                  <td>
                    <?php
                      $tgl = new DateTime($row['tanggal']);
                      $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                      $bulan = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                      echo $hari[(int)$tgl->format('w')] . ', '
                         . $tgl->format('d') . ' '
                         . $bulan[(int)$tgl->format('n')] . ' '
                         . $tgl->format('Y');
                    ?>
                  </td>
                  <td><?= substr($row['waktu'], 0, 5) ?> WIB</td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6">
                  <div class="empty-state">
                    <i class="bi bi-inbox d-block mb-2"></i>
                    <p class="mb-0">
                      <?= $keyword
                          ? 'Tidak ada tamu yang cocok dengan pencarian <strong>"' . htmlspecialchars($keyword) . '"</strong>.'
                          : 'Belum ada data tamu. <a href="index.php">Tambahkan tamu pertama</a>.' ?>
                    </p>
                  </div>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div><!-- /table-wrapper -->

    </div><!-- /main-card -->
  </div>
</section>

<footer>
  &copy; <?= date('Y') ?> <span>SMKN 1 Contoh</span> — Buku Tamu Digital. Dibuat dengan PHP &amp; Bootstrap 5.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
