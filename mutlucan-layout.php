<?php
function mutlucan_header($title, $description = "")
{
    $description = $description !== "" ? $description : "Mutlucan Tarım İşletmeleri premium elma üretimi ve kurumsal tedarik çözümleri.";
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title, ENT_QUOTES, "UTF-8") ?></title>
  <meta name="description" content="<?= htmlspecialchars($description, ENT_QUOTES, "UTF-8") ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css?v=4">
  <style>
    body{margin:0;color:#2b2b2b;font-family:Arial,Helvetica,sans-serif;line-height:1.7}.navbar{min-height:92px;box-shadow:0 10px 30px rgba(0,0,0,.08)}.brand-logo{width:258px;height:68px;object-fit:contain}.subpage-hero{min-height:440px;padding-top:110px;color:#fff;background:url("https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?auto=format&fit=crop&w=1800&q=88") center/cover no-repeat;position:relative}.subpage-hero:before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(55,8,8,.88),rgba(183,28,28,.55),rgba(21,21,21,.22))}.subpage-hero-inner{position:relative;max-width:760px;padding:90px 0 70px}.subpage-hero h1{font-size:clamp(2.4rem,5vw,4.5rem);font-weight:900}.section-padding{padding:96px 0}.bg-soft{background:#f8f9fa}.section-kicker{color:#b71c1c;font-weight:900;text-transform:uppercase}.product-card,.news-card,.contact-form,.team-card,.certificate-card,.testimonial-card{background:#fff;border:1px solid rgba(183,28,28,.08);border-radius:8px;box-shadow:0 10px 24px rgba(20,20,20,.06);overflow:hidden}.product-card img,.news-card img,.gallery-item img{display:block;width:100%;height:245px;object-fit:cover}.gallery-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem}.btn-primary-red,.btn-light-red:hover{background:#b71c1c;border-color:#b71c1c;color:#fff}.footer{background:#16251b;color:#fff;padding:70px 0 24px}.footer a{display:block;color:#fff;text-decoration:none;margin:.35rem 0}@media(max-width:991.98px){.gallery-grid{grid-template-columns:repeat(2,1fr)}}@media(max-width:767.98px){.gallery-grid{grid-template-columns:1fr}.product-card img,.news-card img,.gallery-item img{height:220px}.brand-logo{width:220px}}
  </style>
</head>
<body>
  <div class="site-loader" id="siteLoader" aria-label="Site açılış ekranı">
    <div class="loader-card">
      <img src="images/mutlucan-logo.svg" alt="Mutlucan Tarım İşletmeleri logosu">
      <div class="loader-progress" aria-hidden="true"></div>
    </div>
  </div>
  <nav class="navbar navbar-expand-xl fixed-top bg-white" id="mainNavbar">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="index.php" aria-label="Mutlucan Tarım İşletmeleri ana sayfa">
        <img class="brand-logo" src="images/mutlucan-logo.svg" alt="Mutlucan Tarım İşletmeleri logosu">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Menüyü aç">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav ms-auto mb-2 mb-xl-0 align-items-xl-center">
          <li class="nav-item"><a class="nav-link" href="index.php">Ana Sayfa</a></li>
          <li class="nav-item"><a class="nav-link" href="hakkimizda.php">Hakkımızda</a></li>
          <li class="nav-item"><a class="nav-link" href="urunler.php">Ürünler</a></li>
          <li class="nav-item"><a class="nav-link" href="kalite.php">Kalite</a></li>
          <li class="nav-item"><a class="nav-link" href="hasat.php">Hasat</a></li>
          <li class="nav-item"><a class="nav-link" href="lojistik.php">Lojistik</a></li>
          <li class="nav-item"><a class="nav-link" href="galeri.php">Galeri</a></li>
          <li class="nav-item"><a class="nav-link" href="iletisim.php">İletişim</a></li>
        </ul>
        <a class="btn btn-primary-red ms-xl-3" href="iletisim.php">Teklif Al</a>
      </div>
    </div>
  </nav>
<?php
}

function mutlucan_page_hero($kicker, $title, $text)
{
?>
  <header class="subpage-hero">
    <div class="hero-overlay"></div>
    <div class="container position-relative">
      <div class="subpage-hero-inner reveal">
        <span class="section-kicker text-white"><?= htmlspecialchars($kicker, ENT_QUOTES, "UTF-8") ?></span>
        <h1><?= htmlspecialchars($title, ENT_QUOTES, "UTF-8") ?></h1>
        <p><?= htmlspecialchars($text, ENT_QUOTES, "UTF-8") ?></p>
      </div>
    </div>
  </header>
<?php
}

function mutlucan_footer()
{
?>
  <footer class="footer">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-4">
          <a class="footer-brand" href="index.php"><img src="images/mutlucan-logo.svg" alt="Mutlucan Tarım İşletmeleri logosu"></a>
          <p>Kaliteli elma üretimi, doğru hasat planlaması ve güvenilir teslimatla tarım ürünleri tedarikinde güçlü çözüm ortağınız.</p>
          <div class="social-links">
            <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
        <div class="col-6 col-lg-2">
          <h3>Bağlantılar</h3>
          <a href="hakkimizda.php">Hakkımızda</a>
          <a href="urunler.php">Ürünler</a>
          <a href="kalite.php">Kalite</a>
          <a href="hasat.php">Hasat</a>
        </div>
        <div class="col-6 col-lg-3">
          <h3>Ürünler</h3>
          <a href="urunler.php">Kırmızı Elma</a>
          <a href="urunler.php">Yeşil Elma</a>
          <a href="urunler.php">Golden Elma</a>
        </div>
        <div class="col-lg-3">
          <h3>İletişim</h3>
          <p>+90 212 000 00 00<br>info@mutlucantarimisletmeleri.com<br>Yuvalı Köyü, Isparta</p>
        </div>
      </div>
      <div class="footer-bottom">© 2026 Mutlucan Tarım İşletmeleri. Tüm hakları saklıdır.</div>
    </div>
  </footer>
  <a class="whatsapp-button" href="https://wa.me/902120000000?text=Merhaba%2C%20Mutlucan%20Tar%C4%B1m%20%C4%B0%C5%9Fletmeleri%20%C3%BCr%C3%BCnleri%20i%C3%A7in%20teklif%20almak%20istiyorum." target="_blank" rel="noopener" aria-label="WhatsApp ile iletişim"><i class="bi bi-whatsapp"></i></a>
  <button class="back-to-top" id="backToTop" aria-label="Yukarı çık"><i class="bi bi-arrow-up"></i></button>
  <script src="js/bootstrap.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
<?php
}
?>

