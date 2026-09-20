// Sirius Motorsports Inc. - Main JS
(function(){
  // Sticky header
  const header = document.querySelector('.site-header');
  const onScroll = () => {
    if(!header) return;
    if(window.scrollY > 30) header.classList.add('scrolled');
    else header.classList.remove('scrolled');
  };
  window.addEventListener('scroll', onScroll, {passive:true});
  onScroll();

  // Mobile nav
  const toggle = document.querySelector('.nav-toggle');
  const links = document.querySelector('.nav-links');
  if(toggle && links){
    toggle.addEventListener('click', () => links.classList.toggle('open'));
    links.querySelectorAll('a').forEach(a => a.addEventListener('click', () => links.classList.remove('open')));
  }

  // Active nav link (CI paths)
  const path = (location.pathname.replace(/\/+$/, '') || '/').toLowerCase();
  document.querySelectorAll('.nav-links a').forEach(a => {
    try {
      const hrefPath = new URL(a.href, location.origin).pathname.replace(/\/+$/, '').toLowerCase();
      if (hrefPath && path === hrefPath) a.classList.add('active');
      if (hrefPath.endsWith('/smifinecars') && (path.endsWith('/smifinecars') || path.endsWith('/smifinecars/public'))) a.classList.add('active');
    } catch(e) {}
  });

  // Year
  document.querySelectorAll('[data-year]').forEach(el => el.textContent = new Date().getFullYear());

  // Enquire scroll-to + prefill
  document.querySelectorAll('[data-enquire]').forEach(btn => {
    btn.addEventListener('click', e => {
      e.preventDefault();
      const veh = btn.getAttribute('data-enquire');
      const target = document.querySelector('#enquiry');
      const field = document.querySelector('#vehicleInterest');
      if(field && veh) field.value = veh;
      if(target) target.scrollIntoView({behavior:'smooth', block:'start'});
    });
  });

  // Enquiry form submit (placeholder)
  const forms = document.querySelectorAll('form[data-form]');
  forms.forEach(form => {
    form.addEventListener('submit', e => {
      e.preventDefault();
      const success = form.querySelector('.form-success');
      if(success){ success.classList.add('show'); success.scrollIntoView({behavior:'smooth',block:'center'}); }
      form.reset();
      setTimeout(() => success && success.classList.remove('show'), 6000);
    });
  });

  // Inventory filter
  const search = document.querySelector('#invSearch');
  const status = document.querySelector('#invStatus');
  const cards = document.querySelectorAll('.vehicle-card[data-vehicle]');
  function filter(){
    const q = (search?.value || '').toLowerCase().trim();
    const s = status?.value || 'all';
    cards.forEach(c => {
      const name = c.getAttribute('data-vehicle').toLowerCase();
      const st = c.getAttribute('data-status');
      const okQ = !q || name.includes(q);
      const okS = s === 'all' || st === s;
      c.style.display = (okQ && okS) ? '' : 'none';
    });
  }
  search && search.addEventListener('input', filter);
  status && status.addEventListener('change', filter);

  // Product image gallery: hover on desktop, tap on mobile
  const isMobileGallery = () =>
    window.matchMedia('(max-width: 760px)').matches ||
    window.matchMedia('(hover: none)').matches;
  const galleryControllers = [];

  document.querySelectorAll('[data-gallery-hover]').forEach(wrap => {
    const slides = Array.from(wrap.querySelectorAll('.vehicle-slide'));
    const dots = Array.from(wrap.querySelectorAll('.gallery-dot'));
    if (slides.length < 2) return;
    let idx = 0;
    let timer = null;

    const show = (n) => {
      idx = (n + slides.length) % slides.length;
      slides.forEach((img, i) => img.classList.toggle('is-active', i === idx));
      dots.forEach((dot, i) => dot.classList.toggle('is-active', i === idx));
    };

    const start = () => {
      wrap.classList.add('is-gallery-active');
      if (timer) return;
      timer = setInterval(() => show(idx + 1), 900);
    };
    const stop = () => {
      wrap.classList.remove('is-gallery-active');
      if (timer) clearInterval(timer);
      timer = null;
      show(0);
    };

    galleryControllers.push({ wrap, stop });

    wrap.addEventListener('mouseenter', () => { if (!isMobileGallery()) start(); });
    wrap.addEventListener('mouseleave', () => { if (!isMobileGallery()) stop(); });
    wrap.addEventListener('focusin', () => { if (!isMobileGallery()) start(); });
    wrap.addEventListener('focusout', () => { if (!isMobileGallery()) stop(); });

    // Mobile: tap image to show dots and cycle photos
    wrap.addEventListener('click', (e) => {
      if (!isMobileGallery()) return;
      e.preventDefault();
      e.stopPropagation();
      galleryControllers.forEach(g => {
        if (g.wrap !== wrap) g.stop();
      });
      if (!wrap.classList.contains('is-gallery-active')) {
        start();
      } else {
        show(idx + 1);
      }
    });
  });

  document.addEventListener('click', (e) => {
    if (!isMobileGallery()) return;
    if (e.target.closest('[data-gallery-hover]')) return;
    galleryControllers.forEach(g => g.stop());
  });

  // Description View More popup
  const openDescModal = (title, html) => {
    const descModal = document.getElementById('vehicleDescModal');
    const descTitle = document.getElementById('vehicleDescModalTitle');
    const descBody = document.getElementById('vehicleDescModalBody');
    if(!descModal || !descBody) return;
    if(descTitle) descTitle.textContent = title || 'Vehicle Description';
    descBody.innerHTML = html || '';
    descModal.classList.add('is-open');
    descModal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  };
  const closeDescModal = () => {
    const descModal = document.getElementById('vehicleDescModal');
    if(!descModal) return;
    descModal.classList.remove('is-open');
    descModal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  };
  document.addEventListener('click', e => {
    const btn = e.target.closest('.view-more-desc');
    if(btn){
      e.preventDefault();
      e.stopPropagation();
      const id = btn.getAttribute('data-desc-target');
      const title = btn.getAttribute('data-desc-title') || 'Vehicle Description';
      const source = id ? document.getElementById(id) : null;
      openDescModal(title, source ? source.innerHTML : '');
      return;
    }
    if(e.target.closest('[data-desc-close]')){
      closeDescModal();
    }
  });
  document.addEventListener('keydown', e => {
    if(e.key === 'Escape') closeDescModal();
  });
})();
