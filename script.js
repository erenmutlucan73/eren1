document.addEventListener('DOMContentLoaded', () => {
  const navbar = document.getElementById('mainNavbar');
  const backToTop = document.getElementById('backToTop');
  const siteLoader = document.getElementById('siteLoader');
  const counters = document.querySelectorAll('.counter');
  const revealItems = document.querySelectorAll('.reveal');
  const galleryModal = document.getElementById('galleryModal');
  const modalImage = document.getElementById('modalImage');
  const productModal = document.getElementById('productModal');

  const updateScrollUI = () => {
    const isScrolled = window.scrollY > 30;
    navbar.classList.toggle('navbar-scrolled', isScrolled);
    backToTop.classList.toggle('show', window.scrollY > 500);
  };

  updateScrollUI();
  window.addEventListener('scroll', updateScrollUI);

  if (siteLoader) {
    document.body.classList.add('loading');
    window.addEventListener('load', () => {
      setTimeout(() => {
        siteLoader.classList.add('hide');
        document.body.classList.remove('loading');
      }, 450);
    });
  }

  backToTop.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  document.querySelectorAll('.navbar-collapse .nav-link, .navbar-collapse .btn').forEach((link) => {
    link.addEventListener('click', () => {
      const menu = document.getElementById('navbarMenu');
      const instance = bootstrap.Collapse.getInstance(menu);
      if (instance) {
        instance.hide();
      }
    });
  });

  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });

  revealItems.forEach((item) => revealObserver.observe(item));

  const formatNumber = (value) => new Intl.NumberFormat('tr-TR').format(value);
  let countersStarted = false;

  const animateCounters = () => {
    if (countersStarted) return;
    countersStarted = true;

    counters.forEach((counter) => {
      const target = Number(counter.dataset.target);
      const duration = 1600;
      const startTime = performance.now();

      const tick = (currentTime) => {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        counter.textContent = formatNumber(Math.floor(target * eased));

        if (progress < 1) {
          requestAnimationFrame(tick);
        } else {
          counter.textContent = formatNumber(target);
        }
      };

      requestAnimationFrame(tick);
    });
  };

  const statsSection = document.querySelector('.stats-section');
  const statsObserver = new IntersectionObserver((entries) => {
    if (entries.some((entry) => entry.isIntersecting)) {
      animateCounters();
      statsObserver.disconnect();
    }
  }, { threshold: 0.35 });

  if (statsSection) {
    statsObserver.observe(statsSection);
  }

  if (galleryModal) {
    galleryModal.addEventListener('show.bs.modal', (event) => {
      const trigger = event.relatedTarget;
      const imageUrl = trigger.getAttribute('data-img');
      const imageAlt = trigger.querySelector('img')?.alt || 'Galeri görseli';
      modalImage.src = imageUrl;
      modalImage.alt = imageAlt;
    });

    galleryModal.addEventListener('hidden.bs.modal', () => {
      modalImage.src = '';
    });
  }

  if (productModal) {
    productModal.addEventListener('show.bs.modal', (event) => {
      const trigger = event.relatedTarget;
      const title = trigger.getAttribute('data-title');
      const imageUrl = trigger.getAttribute('data-img');
      const desc = trigger.getAttribute('data-desc');
      const specs = trigger.getAttribute('data-specs').split('|');
      const specsList = document.getElementById('productModalSpecs');

      document.getElementById('productModalTitle').textContent = title;
      document.getElementById('productModalDesc').textContent = desc;
      document.getElementById('productModalImage').src = imageUrl;
      document.getElementById('productModalImage').alt = `${title} görseli`;

      specsList.innerHTML = '';
      specs.forEach((spec) => {
        const item = document.createElement('li');
        item.innerHTML = `<i class="bi bi-check2-circle"></i><span>${spec}</span>`;
        specsList.appendChild(item);
      });
    });
  }

  document.querySelectorAll('.needs-validation').forEach((form) => {
    form.addEventListener('submit', async (event) => {
      event.preventDefault();
      event.stopPropagation();

      if (form.checkValidity()) {
        const submitUrl = form.getAttribute('action');
        const submitButton = form.querySelector('[type="submit"]');
        const originalText = submitButton ? submitButton.textContent : '';

        try {
          if (!submitUrl) {
            throw new Error('Form adresi bulunamadı.');
          }

          if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Gönderiliyor...';
          }

          const response = await fetch(submitUrl, {
            method: 'POST',
            body: new FormData(form),
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
          });

          const result = await response.json().catch(() => ({}));
          if (!response.ok || result.ok !== true) {
            throw new Error(result.message || 'Talep kaydedilemedi.');
          }

          form.reset();
          form.classList.remove('was-validated');
          alert('Teklif talebiniz alındı. Mutlucan Tarım İşletmeleri ekibi en kısa sürede sizinle iletişime geçecektir.');
        } catch (error) {
          alert('Talep gönderilemedi. Lütfen siteyi localhost üzerinden açtığınızdan emin olun ve tekrar deneyin.');
        } finally {
          if (submitButton) {
            submitButton.disabled = false;
            submitButton.textContent = originalText;
          }
        }
      } else {
        form.classList.add('was-validated');
      }
    });
  });
});
