<?php require_once __DIR__ . "/mutlucan-layout.php"; mutlucan_header("İletişim | Mutlucan Tarım İşletmeleri"); mutlucan_page_hero("İletişim", "Kurumsal Tedarik Talebi Oluşturun", "Tonaj, teslimat şehri ve paketleme tercihinizi iletin; ekibimiz size dönüş yapsın."); ?>
<main>
  <section class="section-padding">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-5 reveal">
          <span class="section-kicker">İletişim Bilgileri</span>
          <h2>Mutlucan Tarım İşletmeleri</h2>
          <div class="contact-list">
            <div><i class="bi bi-telephone"></i><span><strong>Telefon</strong>+90 212 000 00 00</span></div>
            <div><i class="bi bi-envelope"></i><span><strong>E-posta</strong>info@mutlucantarimisletmeleri.com</span></div>
            <div><i class="bi bi-geo-alt"></i><span><strong>Adres</strong>Yuvalı Köyü, Isparta, Türkiye</span></div>
            <div><i class="bi bi-clock"></i><span><strong>Çalışma Saatleri</strong>Pazartesi - Cumartesi / 08:30 - 18:00</span></div>
          </div>
        </div>
        <div class="col-lg-7 reveal">
          <form class="contact-form premium-form needs-validation" action="admin.php" method="post" novalidate>
            <input type="hidden" name="islem" value="teklif_kaydet">
            <div class="row g-3">
              <div class="col-md-6"><label class="form-label">Firma Adı</label><input name="firma" class="form-control" required><div class="invalid-feedback">Lütfen firma adını giriniz.</div></div>
              <div class="col-md-6"><label class="form-label">Ad Soyad</label><input name="adSoyad" class="form-control" required><div class="invalid-feedback">Lütfen ad soyad giriniz.</div></div>
              <div class="col-md-6"><label class="form-label">Telefon</label><input name="telefon" class="form-control" required><div class="invalid-feedback">Lütfen telefon giriniz.</div></div>
              <div class="col-md-6"><label class="form-label">E-posta</label><input type="email" name="email" class="form-control" required><div class="invalid-feedback">Geçerli e-posta giriniz.</div></div>
              <div class="col-md-6"><label class="form-label">İlgilenilen Ürün</label><select name="urun" class="form-select" required><option value="">Seçiniz</option><option>Kırmızı Elma</option><option>Yeşil Elma</option><option>Golden Elma</option></select><div class="invalid-feedback">Ürün seçiniz.</div></div>
              <div class="col-md-6"><label class="form-label">Talep Edilen Tonaj</label><input type="number" min="1" name="tonaj" class="form-control" required><div class="invalid-feedback">Tonaj giriniz.</div></div>
              <div class="col-md-6"><label class="form-label">Teslimat Şehri</label><input name="sehir" class="form-control" required><div class="invalid-feedback">Şehir giriniz.</div></div>
              <div class="col-md-6"><label class="form-label">Paketleme Tercihi</label><select name="paketleme" class="form-select" required><option value="">Seçiniz</option><option>Plastik Kasa</option><option>Karton Koli</option><option>Paletli Teslimat</option><option>Özel Paketleme</option></select><div class="invalid-feedback">Paketleme seçiniz.</div></div>
              <div class="col-12"><label class="form-label">Mesaj</label><textarea name="mesaj" class="form-control" rows="5" required></textarea><div class="invalid-feedback">Mesaj yazınız.</div></div>
              <div class="col-12"><button class="btn btn-primary-red w-100">Teklif Talebi Gönder</button></div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <section class="map-section" aria-label="Harita"><iframe title="Mutlucan Tarım İşletmeleri harita" src="https://www.google.com/maps?q=Yuval%C4%B1%20K%C3%B6y%C3%BC%20Isparta%20Turkey&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></section>
</main>
<?php mutlucan_footer(); ?>

