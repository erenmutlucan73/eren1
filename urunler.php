<?php require_once __DIR__ . "/mutlucan-layout.php"; mutlucan_header("Ürünler | Mutlucan Tarım İşletmeleri"); mutlucan_page_hero("Ürünler", "Premium Elma Ürünleri", "Kurumsal tedarik ihtiyaçlarına uygun sınıflandırılmış taze elma grupları."); ?>
<main>
  <section class="section-padding bg-soft">
    <div class="container">
      <div class="row g-4">
        <?php
        $products = [
          ["Kırmızı Elma", "Yeni Hasat", "https://images.unsplash.com/photo-1570913149827-d2ac84ab3f9a?auto=format&fit=crop&w=900&q=88", "Parlak kabuk, dengeli tat ve güçlü raf görünümü."],
          ["Yeşil Elma", "Doğal Ürün", "https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?auto=format&fit=crop&w=900&q=88", "Çıtır dokulu, ferah aromalı ve canlı asidite."],
          ["Golden Elma", "Premium Seri", "https://images.unsplash.com/photo-1567306226416-28f0efdc88ce?auto=format&fit=crop&w=900&q=88", "Tatlı aroması ve dengeli dokusuyla seçkin seri."],
        ];
        foreach ($products as $product): ?>
        <div class="col-md-6 col-lg-4 reveal">
          <article class="product-card premium-product">
            <span class="badge badge-green"><?= htmlspecialchars($product[1], ENT_QUOTES, "UTF-8") ?></span>
            <img src="<?= htmlspecialchars($product[2], ENT_QUOTES, "UTF-8") ?>" alt="<?= htmlspecialchars($product[0], ENT_QUOTES, "UTF-8") ?>">
            <div class="card-body"><h3><?= htmlspecialchars($product[0], ENT_QUOTES, "UTF-8") ?></h3><p><?= htmlspecialchars($product[3], ENT_QUOTES, "UTF-8") ?></p><a class="btn btn-card" href="iletisim.php">Teklif İste</a></div>
          </article>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</main>
<?php mutlucan_footer(); ?>

