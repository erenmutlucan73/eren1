<?php
session_start();

$dataDir = __DIR__;
$adminFile = $dataDir . "/mutlucan_admin_ayar.json";
$quoteFile = $dataDir . "/mutlucan_teklifler.json";
$productFile = $dataDir . "/mutlucan_urunler.json";
$newsFile = $dataDir . "/mutlucan_haberler.json";
$galleryFile = $dataDir . "/mutlucan_galeri.json";
$settingsFile = $dataDir . "/mutlucan_site_ayarlari.json";

function readJsonFile($file, $default)
{
    if (!file_exists($file)) {
        file_put_contents($file, json_encode($default, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $default;
    }

    $data = json_decode(file_get_contents($file), true);
    return is_array($data) ? $data : $default;
}

function writeJsonFile($file, $data)
{
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function redirectAdmin($section, $message = "", $error = "")
{
    if ($message !== "") {
        $_SESSION["mutlucan_admin_message"] = $message;
    }
    if ($error !== "") {
        $_SESSION["mutlucan_admin_error"] = $error;
    }
    header("Location: admin.php#" . $section);
    exit;
}

function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

function selectedOption($value, $current)
{
    return (string) $value === (string) $current ? " selected" : "";
}

function whatsappNumber($phone)
{
    $digits = preg_replace("/\D+/", "", (string) $phone);
    if (strlen($digits) === 10) {
        return "90" . $digits;
    }
    if (strlen($digits) === 11 && substr($digits, 0, 1) === "0") {
        return "9" . $digits;
    }
    return $digits;
}

$defaultProducts = [
    ["id" => 1, "ad" => "Kırmızı Elma", "kategori" => "Sofralık", "stok" => 45, "tonaj" => 80, "durum" => "Aktif", "gorsel" => "https://images.unsplash.com/photo-1570913149827-d2ac84ab3f9a?auto=format&fit=crop&w=900&q=88", "aciklama" => "Parlak kabuklu, dengeli tat profiline sahip premium kırmızı elma."],
    ["id" => 2, "ad" => "Yeşil Elma", "kategori" => "Sofralık", "stok" => 30, "tonaj" => 45, "durum" => "Aktif", "gorsel" => "https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?auto=format&fit=crop&w=900&q=88", "aciklama" => "Çıtır dokulu, ferah aromalı yeşil elma seçkisi."],
    ["id" => 3, "ad" => "Golden Elma", "kategori" => "Premium", "stok" => 25, "tonaj" => 50, "durum" => "Aktif", "gorsel" => "https://images.unsplash.com/photo-1567306226416-28f0efdc88ce?auto=format&fit=crop&w=900&q=88", "aciklama" => "Kurumsal tedarik için homojen görünüm ve dengeli tat."],
];

$defaultNews = [
    ["id" => 1, "baslik" => "2026 Sezon Planı Hazırlandı", "kategori" => "Hasat", "durum" => "Yayında", "tarih" => date("d.m.Y"), "ozet" => "Kırmızı, Golden ve yeşil elma grupları için teslimat takvimi oluşturuldu."],
    ["id" => 2, "baslik" => "Paketleme Standardı Yenilendi", "kategori" => "Lojistik", "durum" => "Yayında", "tarih" => date("d.m.Y"), "ozet" => "Kurumsal alımlar için kasa ve palet hazırlığı daha verimli hale getirildi."],
];

$defaultGallery = [
    ["id" => 1, "baslik" => "Dalında kırmızı elmalar", "url" => "https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?auto=format&fit=crop&w=900&q=88", "durum" => "Aktif"],
    ["id" => 2, "baslik" => "Kasalanmış ürünler", "url" => "https://images.unsplash.com/photo-1576179635662-9d1983e97e1e?auto=format&fit=crop&w=900&q=88", "durum" => "Aktif"],
];

$defaultSettings = [
    "firma" => "Mutlucan Tarım İşletmeleri",
    "telefon" => "+90 212 000 00 00",
    "email" => "info@mutlucantarimisletmeleri.com",
    "adres" => "Yuvalı Köyü, Isparta, Türkiye",
    "whatsapp" => "902120000000",
    "duyuru" => "2026 sezonu kurumsal tedarik talepleri alınmaya başlamıştır.",
];

$adminSettings = file_exists($adminFile) ? readJsonFile($adminFile, []) : [];
$quotes = readJsonFile($quoteFile, []);
$products = readJsonFile($productFile, $defaultProducts);
$news = readJsonFile($newsFile, $defaultNews);
$gallery = readJsonFile($galleryFile, $defaultGallery);
$settings = readJsonFile($settingsFile, $defaultSettings);

if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["islem"] ?? "") === "teklif_kaydet") {
    $quotes[] = [
        "id" => count($quotes) > 0 ? max(array_column($quotes, "id")) + 1 : 1,
        "firma" => trim($_POST["firma"] ?? ""),
        "adSoyad" => trim($_POST["adSoyad"] ?? ""),
        "telefon" => trim($_POST["telefon"] ?? ""),
        "email" => trim($_POST["email"] ?? ""),
        "urun" => trim($_POST["urun"] ?? ""),
        "tonaj" => max(0, (float) ($_POST["tonaj"] ?? 0)),
        "sehir" => trim($_POST["sehir"] ?? ""),
        "paketleme" => trim($_POST["paketleme"] ?? ""),
        "mesaj" => trim($_POST["mesaj"] ?? ""),
        "durum" => "Yeni Talep",
        "not" => "",
        "yanit" => "",
        "yanitTarihi" => "",
        "tarih" => date("d.m.Y H:i"),
    ];
    writeJsonFile($quoteFile, $quotes);

    $ajax = strtolower($_SERVER["HTTP_X_REQUESTED_WITH"] ?? "") === "xmlhttprequest";
    if ($ajax) {
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(["ok" => true, "message" => "Teklif talebiniz alındı."], JSON_UNESCAPED_UNICODE);
        exit;
    }

    header("Location: index.php?teklif=ok#iletisim");
    exit;
}

if (isset($_GET["cikis"])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

$message = $_SESSION["mutlucan_admin_message"] ?? "";
$error = $_SESSION["mutlucan_admin_error"] ?? "";
unset($_SESSION["mutlucan_admin_message"], $_SESSION["mutlucan_admin_error"]);

if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["islem"] ?? "") === "ilk_kurulum") {
    $newUser = trim($_POST["kullaniciAdi"] ?? "");
    $newPass = $_POST["sifre"] ?? "";
    $newPassRepeat = $_POST["sifreTekrar"] ?? "";
    if ($newUser === "" || strlen($newPass) < 6 || $newPass !== $newPassRepeat) {
        $error = "Kullanıcı adı boş olamaz. Şifreler aynı ve en az 6 karakter olmalı.";
    } else {
        $adminSettings = [
            "kullaniciAdi" => $newUser,
            "sifreHash" => password_hash($newPass, PASSWORD_DEFAULT),
            "kurulumTarihi" => date("d.m.Y H:i"),
        ];
        writeJsonFile($adminFile, $adminSettings);
        $_SESSION["mutlucan_admin_login"] = true;
        header("Location: admin.php");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["islem"] ?? "") === "giris") {
    if (($_POST["kullaniciAdi"] ?? "") === $adminSettings["kullaniciAdi"] && password_verify($_POST["sifre"] ?? "", $adminSettings["sifreHash"])) {
        $_SESSION["mutlucan_admin_login"] = true;
        header("Location: admin.php");
        exit;
    }
    $error = "Kullanıcı adı veya şifre hatalı.";
}

$loggedIn = !empty($_SESSION["mutlucan_admin_login"]);
$needsSetup = empty($adminSettings["kullaniciAdi"]) || empty($adminSettings["sifreHash"]);

if ($loggedIn && isset($_GET["indir"])) {
    $type = $_GET["indir"];
    $rows = [];
    $fileName = "mutlucan-rapor.csv";

    if ($type === "teklifler") {
        $fileName = "mutlucan-teklifler.csv";
        $rows[] = ["ID", "Firma", "Yetkili", "Telefon", "E-posta", "Ürün", "Tonaj", "Şehir", "Paketleme", "Durum", "Tarih", "Not", "Yanıt", "Yanıt Tarihi"];
        foreach ($quotes as $q) {
            $rows[] = [$q["id"], $q["firma"], $q["adSoyad"], $q["telefon"], $q["email"], $q["urun"], $q["tonaj"], $q["sehir"], $q["paketleme"], $q["durum"], $q["tarih"], $q["not"], $q["yanit"] ?? "", $q["yanitTarihi"] ?? ""];
        }
    } elseif ($type === "urunler") {
        $fileName = "mutlucan-urunler.csv";
        $rows[] = ["ID", "Ürün", "Kategori", "Stok", "Tonaj", "Durum", "Görsel", "Açıklama"];
        foreach ($products as $p) {
            $rows[] = [$p["id"], $p["ad"], $p["kategori"], $p["stok"], $p["tonaj"], $p["durum"], $p["gorsel"], $p["aciklama"]];
        }
    }

    header("Content-Type: text/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=" . $fileName);
    echo "\xEF\xBB\xBF";
    $out = fopen("php://output", "w");
    foreach ($rows as $row) {
        fputcsv($out, $row, ";");
    }
    fclose($out);
    exit;
}

if ($loggedIn && $_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["islem"] ?? "";

    if ($action === "teklif_guncelle") {
        foreach ($quotes as &$quote) {
            if ((int) $quote["id"] === (int) ($_POST["id"] ?? 0)) {
                $oldReply = $quote["yanit"] ?? "";
                $newReply = trim($_POST["yanit"] ?? "");
                $quote["durum"] = $_POST["durum"] ?? $quote["durum"];
                $quote["not"] = trim($_POST["not"] ?? "");
                $quote["yanit"] = $newReply;
                if ($newReply !== "" && $newReply !== $oldReply) {
                    $quote["yanitTarihi"] = date("d.m.Y H:i");
                    if (in_array($quote["durum"], ["Yeni Talep", "Aranacak"], true)) {
                        $quote["durum"] = "Yanıtlandı";
                    }
                }
            }
        }
        unset($quote);
        writeJsonFile($quoteFile, $quotes);
        redirectAdmin("teklifler", "Talep bilgisi güncellendi.");
    }

    if ($action === "teklif_sil") {
        $id = (int) ($_POST["id"] ?? 0);
        $quotes = array_values(array_filter($quotes, function ($q) use ($id) {
            return (int) $q["id"] !== $id;
        }));
        writeJsonFile($quoteFile, $quotes);
        redirectAdmin("teklifler", "Teklif kaydı silindi.");
    }

    if ($action === "urun_kaydet") {
        $id = (int) ($_POST["id"] ?? 0);
        $record = [
            "id" => $id > 0 ? $id : (count($products) > 0 ? max(array_column($products, "id")) + 1 : 1),
            "ad" => trim($_POST["ad"] ?? "Yeni Ürün"),
            "kategori" => trim($_POST["kategori"] ?? "Sofralık"),
            "stok" => max(0, (int) ($_POST["stok"] ?? 0)),
            "tonaj" => max(0, (float) ($_POST["tonaj"] ?? 0)),
            "durum" => trim($_POST["durum"] ?? "Aktif"),
            "gorsel" => trim($_POST["gorsel"] ?? ""),
            "aciklama" => trim($_POST["aciklama"] ?? ""),
        ];

        $updated = false;
        foreach ($products as &$product) {
            if ((int) $product["id"] === $record["id"]) {
                $product = $record;
                $updated = true;
            }
        }
        unset($product);
        if (!$updated) {
            $products[] = $record;
        }
        writeJsonFile($productFile, $products);
        redirectAdmin("urunler", "Ürün kaydı güncellendi.");
    }

    if ($action === "urun_sil") {
        $id = (int) ($_POST["id"] ?? 0);
        $products = array_values(array_filter($products, function ($p) use ($id) {
            return (int) $p["id"] !== $id;
        }));
        writeJsonFile($productFile, $products);
        redirectAdmin("urunler", "Ürün silindi.");
    }

    if ($action === "haber_kaydet") {
        $news[] = [
            "id" => count($news) > 0 ? max(array_column($news, "id")) + 1 : 1,
            "baslik" => trim($_POST["baslik"] ?? ""),
            "kategori" => trim($_POST["kategori"] ?? "Haber"),
            "durum" => trim($_POST["durum"] ?? "Taslak"),
            "tarih" => date("d.m.Y"),
            "ozet" => trim($_POST["ozet"] ?? ""),
        ];
        writeJsonFile($newsFile, $news);
        redirectAdmin("haberler", "Haber notu eklendi.");
    }

    if ($action === "galeri_kaydet") {
        $gallery[] = [
            "id" => count($gallery) > 0 ? max(array_column($gallery, "id")) + 1 : 1,
            "baslik" => trim($_POST["baslik"] ?? ""),
            "url" => trim($_POST["url"] ?? ""),
            "durum" => trim($_POST["durum"] ?? "Aktif"),
        ];
        writeJsonFile($galleryFile, $gallery);
        redirectAdmin("galeri", "Galeri görseli eklendi.");
    }

    if ($action === "ayar_kaydet") {
        $settings = [
            "firma" => trim($_POST["firma"] ?? $settings["firma"]),
            "telefon" => trim($_POST["telefon"] ?? $settings["telefon"]),
            "email" => trim($_POST["email"] ?? $settings["email"]),
            "adres" => trim($_POST["adres"] ?? $settings["adres"]),
            "whatsapp" => trim($_POST["whatsapp"] ?? $settings["whatsapp"]),
            "duyuru" => trim($_POST["duyuru"] ?? $settings["duyuru"]),
        ];
        writeJsonFile($settingsFile, $settings);
        redirectAdmin("ayarlar", "Site ayarları güncellendi.");
    }

    if ($action === "sifre_degistir") {
        if (!password_verify($_POST["mevcutSifre"] ?? "", $adminSettings["sifreHash"])) {
            redirectAdmin("ayarlar", "", "Mevcut şifre hatalı.");
        }
        if (strlen($_POST["yeniSifre"] ?? "") < 6 || ($_POST["yeniSifre"] ?? "") !== ($_POST["yeniSifreTekrar"] ?? "")) {
            redirectAdmin("ayarlar", "", "Yeni şifreler aynı olmalı ve en az 6 karakter olmalı.");
        }
        $adminSettings["sifreHash"] = password_hash($_POST["yeniSifre"], PASSWORD_DEFAULT);
        writeJsonFile($adminFile, $adminSettings);
        redirectAdmin("ayarlar", "Admin şifresi güncellendi.");
    }
}

$totalTonnage = array_sum(array_map(function ($p) {
    return (float) ($p["tonaj"] ?? 0);
}, $products));
$openQuotes = count(array_filter($quotes, function ($q) {
    return !in_array($q["durum"] ?? "", ["Tamamlandı", "İptal"], true);
}));
$newQuotes = count(array_filter($quotes, function ($q) {
    return ($q["durum"] ?? "") === "Yeni Talep";
}));
$answeredQuotes = count(array_filter($quotes, function ($q) {
    return trim($q["yanit"] ?? "") !== "";
}));
$activeProducts = count(array_filter($products, function ($p) {
    return ($p["durum"] ?? "") !== "Pasif";
}));
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mutlucan Admin Paneli</title>
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/admin.css?v=3" rel="stylesheet">
</head>
<body class="admin-body">
<?php if (!$loggedIn): ?>
  <main class="login-shell">
    <?php if ($needsSetup): ?>
    <form class="login-card" method="post">
      <input type="hidden" name="islem" value="ilk_kurulum">
      <img class="brand-logo" src="images/mutlucan-logo.svg" alt="Mutlucan Tarım İşletmeleri">
      <h1 class="h4 fw-bold">İlk Kurulum</h1>
      <p class="text-muted">Admin paneli için kendi kullanıcı adı ve şifrenizi oluşturun.</p>
      <?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
      <div class="mb-3"><label class="form-label">Kullanıcı Adı</label><input class="form-control" name="kullaniciAdi" required></div>
      <div class="mb-3"><label class="form-label">Şifre</label><input class="form-control" type="password" name="sifre" minlength="6" required></div>
      <div class="mb-3"><label class="form-label">Şifre Tekrar</label><input class="form-control" type="password" name="sifreTekrar" minlength="6" required></div>
      <button class="btn btn-red w-100">Paneli Kur</button>
    </form>
    <?php else: ?>
    <form class="login-card" method="post">
      <input type="hidden" name="islem" value="giris">
      <img class="brand-logo" src="images/mutlucan-logo.svg" alt="Mutlucan Tarım İşletmeleri">
      <h1 class="h4 fw-bold">Admin Paneli</h1>
      <p class="text-muted">Ürün, teklif, galeri ve site ayarlarını yönetin.</p>
      <?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
      <div class="mb-3"><label class="form-label">Kullanıcı Adı</label><input class="form-control" name="kullaniciAdi" required></div>
      <div class="mb-3"><label class="form-label">Şifre</label><input class="form-control" type="password" name="sifre" required></div>
      <button class="btn btn-red w-100">Giriş Yap</button>
    </form>
    <?php endif; ?>
  </main>
<?php else: ?>
  <div class="container-fluid">
    <div class="row">
      <aside class="col-lg-3 col-xl-2 sidebar p-3">
        <img class="brand-logo bg-white rounded p-1" src="images/mutlucan-logo.svg" alt="Mutlucan">
        <nav class="d-grid gap-1 mt-3">
          <a href="#dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a>
          <a href="#teklifler"><i class="bi bi-inbox"></i> Sipariş Talepleri</a>
          <a href="#urunler"><i class="bi bi-basket2"></i> Ürünler</a>
          <a href="#haberler"><i class="bi bi-newspaper"></i> Haberler</a>
          <a href="#galeri"><i class="bi bi-images"></i> Galeri</a>
          <a href="#ayarlar"><i class="bi bi-gear"></i> Ayarlar</a>
          <a href="index.php" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Siteyi Aç</a>
          <a href="?cikis=1"><i class="bi bi-power"></i> Çıkış</a>
        </nav>
      </aside>
      <main class="col-lg-9 col-xl-10 content">
        <div class="topbar d-flex justify-content-between align-items-center mb-4">
          <div><h1 class="h4 fw-bold mb-0">Mutlucan Tarım İşletmeleri Paneli</h1><span class="text-muted">Nova eSpor panel mantığı tarım tedarik sistemine uyarlandı.</span></div>
          <a class="btn btn-red" href="#teklifler">Yeni Talepler: <?= $newQuotes ?></a>
        </div>
        <?php if ($message): ?><div class="alert alert-success"><?= h($message) ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>

        <section id="dashboard" class="row g-4 mb-4">
          <div class="col-md-6 col-xl-3"><div class="panel-card stat-card"><i class="bi bi-inbox"></i><strong><?= count($quotes) ?></strong><span>Toplam Talep</span></div></div>
          <div class="col-md-6 col-xl-3"><div class="panel-card stat-card"><i class="bi bi-hourglass-split"></i><strong><?= $openQuotes ?></strong><span>Açık Talep</span></div></div>
          <div class="col-md-6 col-xl-3"><div class="panel-card stat-card"><i class="bi bi-reply"></i><strong><?= $answeredQuotes ?></strong><span>Yanıtlanan</span></div></div>
          <div class="col-md-6 col-xl-3"><div class="panel-card stat-card"><i class="bi bi-basket2"></i><strong><?= $activeProducts ?></strong><span>Aktif Ürün</span></div></div>
        </section>

        <section id="teklifler" class="panel-card">
          <div class="section-title"><h2>Sipariş / Teklif Talepleri</h2><a class="btn btn-outline-danger btn-sm" href="?indir=teklifler">CSV İndir</a></div>
          <div class="table-responsive">
            <table class="table align-middle">
              <thead><tr><th>Firma</th><th>Yetkili</th><th>Ürün</th><th>Mesaj</th><th>Durum</th><th>Yanıt</th><th>İşlem</th></tr></thead>
              <tbody>
              <?php foreach (array_reverse($quotes) as $q): ?>
                <tr>
                  <td><strong><?= h($q["firma"]) ?></strong><br><small><?= h($q["tarih"]) ?></small></td>
                  <td><?= h($q["adSoyad"]) ?><br><small><?= h($q["telefon"]) ?> · <?= h($q["email"]) ?></small></td>
                  <td><?= h($q["urun"]) ?><br><small><?= h($q["paketleme"]) ?></small></td>
                  <td><strong><?= h($q["tonaj"]) ?> ton</strong> · <?= h($q["sehir"]) ?><br><small><?= h($q["mesaj"] ?? "") ?></small></td>
                  <td><span class="badge-status"><?= h($q["durum"]) ?></span></td>
                  <td>
                    <?php if (!empty($q["yanit"])): ?>
                      <strong>Yanıtlandı</strong><br><small><?= h($q["yanitTarihi"] ?? "") ?></small>
                    <?php else: ?>
                      <span class="text-muted">Henüz yanıt yok</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <form class="d-grid gap-2" method="post" style="min-width:260px">
                      <input type="hidden" name="islem" value="teklif_guncelle"><input type="hidden" name="id" value="<?= h($q["id"]) ?>">
                      <select class="form-select form-select-sm" name="durum">
                        <?php foreach (["Yeni Talep", "Aranacak", "Teklif Verildi", "Yanıtlandı", "Tamamlandı", "İptal"] as $status): ?>
                          <option<?= selectedOption($status, $q["durum"] ?? "") ?>><?= h($status) ?></option>
                        <?php endforeach; ?>
                      </select>
                      <textarea class="form-control form-control-sm" name="yanit" rows="3" placeholder="Müşteriye verilecek yanıt"><?= h($q["yanit"] ?? "") ?></textarea>
                      <input class="form-control form-control-sm" name="not" placeholder="İç not" value="<?= h($q["not"] ?? "") ?>">
                      <div class="d-flex gap-2 flex-wrap">
                        <?php if (!empty($q["email"])): ?>
                          <a class="btn btn-sm btn-outline-secondary" href="mailto:<?= h($q["email"]) ?>?subject=<?= rawurlencode("Mutlucan Tarım İşletmeleri teklif yanıtı") ?>&body=<?= rawurlencode($q["yanit"] ?? "") ?>"><i class="bi bi-envelope"></i></a>
                        <?php endif; ?>
                        <?php $wa = whatsappNumber($q["telefon"] ?? ""); if ($wa !== ""): ?>
                          <a class="btn btn-sm btn-outline-success" href="https://wa.me/<?= h($wa) ?>?text=<?= rawurlencode($q["yanit"] ?? "") ?>" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i></a>
                        <?php endif; ?>
                        <button class="btn btn-sm btn-red">Kaydet</button>
                      </div>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </section>

        <section id="urunler" class="panel-card">
          <div class="section-title"><h2>Ürün Yönetimi</h2><a class="btn btn-outline-danger btn-sm" href="?indir=urunler">CSV İndir</a></div>
          <div class="table-responsive mb-4">
            <table class="table align-middle">
              <thead><tr><th>Görsel</th><th>Ürün</th><th>Kategori</th><th>Stok</th><th>Tonaj</th><th>Durum</th><th></th></tr></thead>
              <tbody>
              <?php foreach ($products as $p): ?>
                <tr><td><img src="<?= h($p["gorsel"]) ?>" alt=""></td><td><strong><?= h($p["ad"]) ?></strong><br><small><?= h($p["aciklama"]) ?></small></td><td><?= h($p["kategori"]) ?></td><td><?= h($p["stok"]) ?></td><td><?= h($p["tonaj"]) ?></td><td><?= h($p["durum"]) ?></td><td><form method="post"><input type="hidden" name="islem" value="urun_sil"><input type="hidden" name="id" value="<?= h($p["id"]) ?>"><button class="btn btn-sm btn-outline-danger">Sil</button></form></td></tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <form class="row g-3" method="post">
            <input type="hidden" name="islem" value="urun_kaydet">
            <div class="col-md-3"><input class="form-control" name="ad" placeholder="Ürün adı" required></div>
            <div class="col-md-2"><input class="form-control" name="kategori" placeholder="Kategori"></div>
            <div class="col-md-2"><input class="form-control" type="number" name="stok" placeholder="Stok"></div>
            <div class="col-md-2"><input class="form-control" type="number" name="tonaj" placeholder="Tonaj"></div>
            <div class="col-md-3"><input class="form-control" name="durum" placeholder="Durum" value="Aktif"></div>
            <div class="col-md-6"><input class="form-control" name="gorsel" placeholder="Görsel URL"></div>
            <div class="col-md-6"><input class="form-control" name="aciklama" placeholder="Kısa açıklama"></div>
            <div class="col-12"><button class="btn btn-red">Ürün Ekle</button></div>
          </form>
        </section>

        <section id="haberler" class="panel-card">
          <div class="section-title"><h2>Sezon Notları / Haberler</h2></div>
          <div class="row g-3 mb-3">
            <?php foreach ($news as $n): ?><div class="col-md-6 col-xl-4"><div class="border rounded p-3 h-100"><span class="badge bg-success"><?= h($n["durum"]) ?></span><h3 class="h6 fw-bold mt-2"><?= h($n["baslik"]) ?></h3><p class="small mb-0"><?= h($n["ozet"]) ?></p></div></div><?php endforeach; ?>
          </div>
          <form class="row g-3" method="post"><input type="hidden" name="islem" value="haber_kaydet"><div class="col-md-4"><input class="form-control" name="baslik" placeholder="Başlık" required></div><div class="col-md-2"><input class="form-control" name="kategori" placeholder="Kategori"></div><div class="col-md-2"><select class="form-select" name="durum"><option>Yayında</option><option>Taslak</option></select></div><div class="col-md-4"><input class="form-control" name="ozet" placeholder="Özet"></div><div class="col-12"><button class="btn btn-red">Haber Ekle</button></div></form>
        </section>

        <section id="galeri" class="panel-card">
          <div class="section-title"><h2>Galeri Yönetimi</h2></div>
          <div class="row g-3 mb-3">
            <?php foreach ($gallery as $g): ?><div class="col-md-6 col-xl-3"><div class="border rounded p-2 h-100"><img class="w-100 rounded mb-2" style="height:120px;object-fit:cover" src="<?= h($g["url"]) ?>" alt=""><strong><?= h($g["baslik"]) ?></strong><br><small><?= h($g["durum"]) ?></small></div></div><?php endforeach; ?>
          </div>
          <form class="row g-3" method="post"><input type="hidden" name="islem" value="galeri_kaydet"><div class="col-md-4"><input class="form-control" name="baslik" placeholder="Görsel başlığı" required></div><div class="col-md-6"><input class="form-control" name="url" placeholder="Görsel URL" required></div><div class="col-md-2"><select class="form-select" name="durum"><option>Aktif</option><option>Pasif</option></select></div><div class="col-12"><button class="btn btn-red">Galeriye Ekle</button></div></form>
        </section>

        <section id="ayarlar" class="panel-card">
          <div class="section-title"><h2>Site Ayarları</h2></div>
          <form class="row g-3 mb-4" method="post">
            <input type="hidden" name="islem" value="ayar_kaydet">
            <div class="col-md-6"><label class="form-label">Firma</label><input class="form-control" name="firma" value="<?= h($settings["firma"]) ?>"></div>
            <div class="col-md-6"><label class="form-label">Telefon</label><input class="form-control" name="telefon" value="<?= h($settings["telefon"]) ?>"></div>
            <div class="col-md-6"><label class="form-label">E-posta</label><input class="form-control" name="email" value="<?= h($settings["email"]) ?>"></div>
            <div class="col-md-6"><label class="form-label">WhatsApp</label><input class="form-control" name="whatsapp" value="<?= h($settings["whatsapp"]) ?>"></div>
            <div class="col-12"><label class="form-label">Adres</label><input class="form-control" name="adres" value="<?= h($settings["adres"]) ?>"></div>
            <div class="col-12"><label class="form-label">Duyuru</label><textarea class="form-control" name="duyuru"><?= h($settings["duyuru"]) ?></textarea></div>
            <div class="col-12"><button class="btn btn-red">Ayarları Kaydet</button></div>
          </form>
          <form class="row g-3" method="post">
            <input type="hidden" name="islem" value="sifre_degistir">
            <div class="col-md-4"><input type="password" class="form-control" name="mevcutSifre" placeholder="Mevcut şifre"></div>
            <div class="col-md-4"><input type="password" class="form-control" name="yeniSifre" placeholder="Yeni şifre"></div>
            <div class="col-md-4"><input type="password" class="form-control" name="yeniSifreTekrar" placeholder="Yeni şifre tekrar"></div>
            <div class="col-12"><button class="btn btn-outline-danger">Şifreyi Değiştir</button></div>
          </form>
        </section>
      </main>
    </div>
  </div>
<?php endif; ?>
</body>
</html>

