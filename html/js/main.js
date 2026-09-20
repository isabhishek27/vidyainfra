// Vidya Infra — main.js
(function(){
  const header = document.querySelector('.site-header');
  const nav = document.querySelector('.nav');
  const burger = document.querySelector('.hamburger');
  const backdrop = document.querySelector('.nav-backdrop');

  function onScroll(){
    if(!header) return;
    if(window.scrollY > 40){ header.classList.add('solid'); header.classList.remove('transparent'); }
    else { header.classList.remove('solid'); header.classList.add('transparent'); }
  }
  window.addEventListener('scroll', onScroll, {passive:true});
  onScroll();

  if(burger){
    burger.addEventListener('click', ()=>{
      nav.classList.toggle('open');
      burger.classList.toggle('open');
      if(backdrop) backdrop.classList.toggle('open');
    });
  }
  if(backdrop){
    backdrop.addEventListener('click', ()=>{
      nav.classList.remove('open');
      burger.classList.remove('open');
      backdrop.classList.remove('open');
    });
  }

  // Active nav link
  const path = (location.pathname.split('/').pop() || 'index.html').toLowerCase();
  document.querySelectorAll('.nav a').forEach(a=>{
    const href = (a.getAttribute('href')||'').toLowerCase();
    if(href === path || (path==='' && href==='index.html')) a.classList.add('active');
  });

  // Reveal on scroll
  const io = new IntersectionObserver((entries)=>{
    entries.forEach(e=>{ if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target);} });
  },{threshold:.14});
  document.querySelectorAll('.reveal').forEach(el=>io.observe(el));

  // Counters
  const counters = document.querySelectorAll('[data-count]');
  const cio = new IntersectionObserver((entries)=>{
    entries.forEach(e=>{
      if(!e.isIntersecting) return;
      const el = e.target;
      const target = +el.dataset.count;
      const dur = 1400; const start = performance.now();
      function tick(t){
        const p = Math.min(1,(t-start)/dur);
        el.textContent = Math.round(target * (0.2 + 0.8*p*(2-p))); // easeOut
        if(p<1) requestAnimationFrame(tick); else el.textContent = target + (el.dataset.suffix||'');
      }
      requestAnimationFrame(tick);
      cio.unobserve(el);
    });
  },{threshold:.4});
  counters.forEach(c=>cio.observe(c));

  // Hero slider
  const slides = document.querySelectorAll('.hero-slide');
  if(slides.length>1){
    let i=0;
    setInterval(()=>{
      slides[i].classList.remove('active');
      i = (i+1)%slides.length;
      slides[i].classList.add('active');
    },5500);
  }

  // Contact form (demo)
  const form = document.querySelector('#contact-form');
  if(form){
    form.addEventListener('submit', (e)=>{
      e.preventDefault();
      form.querySelector('.success').classList.add('show');
      form.reset();
      setTimeout(()=>form.querySelector('.success').classList.remove('show'), 4000);
    });
  }

  // Enquiry modal (services page)
  const modal = document.querySelector('#enquiry-modal');
  const modalService = document.querySelector('#enquiry-service');
  document.querySelectorAll('[data-enquire]').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      if(modalService) modalService.value = btn.dataset.enquire;
      if(modal) modal.classList.add('open');
    });
  });
  if(modal){
    modal.addEventListener('click', (e)=>{
      if(e.target === modal || e.target.classList.contains('modal-close')) modal.classList.remove('open');
    });
    const eForm = modal.querySelector('form');
    eForm && eForm.addEventListener('submit', (e)=>{
      e.preventDefault();
      eForm.querySelector('.success').classList.add('show');
      setTimeout(()=>{ modal.classList.remove('open'); eForm.reset(); eForm.querySelector('.success').classList.remove('show');},1600);
    });
  }

  // Lightbox
  const lb = document.querySelector('#lightbox');
  const lbImg = lb && lb.querySelector('img');
  document.querySelectorAll('[data-lightbox]').forEach(el=>{
    el.addEventListener('click', ()=>{
      if(!lb) return;
      lbImg.src = el.dataset.lightbox;
      lb.classList.add('open');
    });
  });
  if(lb){
    lb.addEventListener('click', (e)=>{
      if(e.target === lb || e.target.classList.contains('lightbox-close')) lb.classList.remove('open');
    });
  }

  // Project filter
  document.querySelectorAll('[data-filter]').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      document.querySelectorAll('[data-filter]').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      const f = btn.dataset.filter;
      document.querySelectorAll('[data-cat]').forEach(card=>{
        card.style.display = (f==='all' || card.dataset.cat===f) ? '' : 'none';
      });
    });
  });
})();
