<?php
$hero = $hero ?? [];
$about = $about ?? [];
$cta = $cta ?? [];
$slides = [];
if (!empty($hero['extra_json'])) {
    $decoded = json_decode($hero['extra_json'], true);
    $slides = $decoded['slides'] ?? [];
}
if (empty($slides)) {
    $slides = ['hero/slide1.jpg','hero/slide2.jpg','hero/slide3.jpg','hero/slide4.jpg','hero/slide5.jpg','hero/slide6.jpg'];
}
?>
<section class="hero">
  <div class="hero-slides">
    <?php foreach ($slides as $i => $slide): ?>
      <div class="hero-slide<?= $i === 0 ? ' active' : '' ?>" style="background-image:url('<?= esc(uploaded_folder_url($slide)) ?>')"></div>
    <?php endforeach; ?>
  </div>
  <div class="container hero-inner fade-in">
    <span class="eyebrow" style="color:#F28C38"><?= esc($hero['eyebrow'] ?? 'Established Excellence · Since 2008') ?></span>
    <h1><?= $hero['title'] ?? 'Building <span>Landmarks</span>,<br/>Delivering Trust.' ?></h1>
    <p><?= esc($hero['content'] ?? '') ?></p>
    <div class="hero-actions"></div>
  </div>
  <div class="hero-scroll">Scroll</div>
</section>

<section class="section">
  <div class="container split">
    <div class="media reveal">
      <img src="<?= esc(uploaded_folder_url($about['image'] ?? 'pages/about-1.jpg')) ?>" alt="Vidya Infra Construction site"/>
    </div>
    <div class="reveal reveal-delay-1">
      <span class="eyebrow"><?= esc($about['eyebrow'] ?? 'About Vidya Infra') ?></span>
      <h2><?= esc($about['title'] ?? '') ?></h2>
      <p><?= nl2br(esc($about['content'] ?? '')) ?></p>
      <br>
      <?php if (!empty($about['button_text'])): ?>
        <a class="btn btn-outline" href="<?= esc(site_url(ltrim($about['button_link'] ?? '/about', '/'))) ?>"><?= esc($about['button_text']) ?></a>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="cta-band">
  <div class="container reveal">
    <h2><?= esc($cta['title'] ?? 'Have a project in mind?') ?></h2>
    <p><?= esc($cta['content'] ?? '') ?></p>
    <?php if (!empty($cta['button_text'])): ?>
      <a class="btn btn-primary" href="<?= esc(site_url(ltrim($cta['button_link'] ?? '/contact', '/'))) ?>"><?= esc($cta['button_text']) ?></a>
    <?php endif; ?>
  </div>
</section>
