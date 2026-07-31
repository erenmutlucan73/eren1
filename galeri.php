<?php require_once __DIR__ . "/mutlucan-layout.php"; mutlucan_header("Galeri | Mutlucan Tarım İşletmeleri"); mutlucan_page_hero("Galeri", "Bahçelerimizden Kareler", "Dalında elma, hasat ve ürün seçimi süreçlerinden seçilmiş görseller."); ?>
<main>
  <section class="section-padding">
    <div class="container">
      <div class="gallery-grid premium-gallery">
        <?php
        $images = [
          ["https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?auto=format&fit=crop&w=900&q=88", "Dalında kırmızı elmalar"],
          ["https://images.unsplash.com/photo-1570913149827-d2ac84ab3f9a?auto=format&fit=crop&w=900&q=88", "Seçilmiş kırmızı elmalar"],
          ["https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?auto=format&fit=crop&w=900&q=88", "Yeşil elma seçkisi"],
          ["https://images.unsplash.com/photo-1576179635662-9d1983e97e1e?auto=format&fit=crop&w=900&q=88", "Kasalanmış elmalar"],
          ["https://images.unsplash.com/photo-1567306226416-28f0efdc88ce?auto=format&fit=crop&w=900&q=88", "Hasada hazır elmalar"],
          ["https://images.unsplash.com/photo-1589217157232-464b505b197f?auto=format&fit=crop&w=900&q=88", "Kalite seçimi"],
        ];
        foreach ($images as $image): ?>
        <button class="gallery-item reveal" data-bs-toggle="modal" data-bs-target="#galleryModal" data-img="<?= htmlspecialchars($image[0], ENT_QUOTES, "UTF-8") ?>"><img src="<?= htmlspecialchars($image[0], ENT_QUOTES, "UTF-8") ?>" alt="<?= htmlspecialchars($image[1], ENT_QUOTES, "UTF-8") ?>"></button>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-dialog-centered modal-xl"><div class="modal-content"><button type="button" class="btn-close ms-auto m-3" data-bs-dismiss="modal" aria-label="Kapat"></button><img id="modalImage" src="" alt="Galeri görseli"></div></div></div>
</main>
<?php mutlucan_footer(); ?>

