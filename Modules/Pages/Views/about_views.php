<?php
$page = $page ?? [];
$who = $who ?? [];
$mission_sec = $mission_sec ?? [];
$mission = $mission ?? [];
$strengths_sec = $strengths_sec ?? [];
$strengths = $strengths ?? [];
$cta = $cta ?? [];
$heroImage = $page['hero_image'] ?? 'pages/about-2.jpg';
?>
<section class="page-hero" style="background-image:linear-gradient(120deg,rgba(15,25,45,.88),rgba(15,25,45,.7)),url('<?= esc(uploaded_folder_url($heroImage)) ?>');background-size:cover;background-position:center">
  <div class="container">
    <span class="eyebrow" style="color:var(--orange)">About Us</span>
    <h1><?= esc($page['subtitle'] ?? 'Crafting spaces. Building trust.') ?></h1>
    <div class="crumbs"><a href="<?= esc(site_url('/')) ?>">Home</a> / About</div>
  </div>
</section>

<section class="section">
  <div class="container split">
    <div class="media reveal">
      <img src="<?= esc(uploaded_folder_url($who['image'] ?? 'pages/about-1.jpg')) ?>" alt="Vidya Infra site"/>
    </div>
    <div class="reveal reveal-delay-1">
      <span class="eyebrow"><?= esc($who['eyebrow'] ?? 'Who We Are') ?></span>
      <h2><?= esc($who['title'] ?? '') ?></h2>
      <p><?= nl2br(esc($who['content'] ?? '')) ?></p>
      <?php if (!empty($who['content_2'])): ?>
        <p><?= nl2br(esc($who['content_2'])) ?></p>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="section" style="background:var(--muted)">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow"><?= esc($mission_sec['eyebrow'] ?? 'What Guides Us') ?></span>
      <h2><?= esc($mission_sec['title'] ?? 'Mission & Vision') ?></h2>
    </div>
    <div class="grid-2">
      <div class="card reveal">
        <div class="body">
          <span class="tag"><?= esc($mission['mission_tag'] ?? 'Mission') ?></span>
          <h3><?= esc($mission['mission_title'] ?? '') ?></h3>
          <p><?= esc($mission['mission_content'] ?? '') ?></p>
        </div>
      </div>
      <div class="card reveal reveal-delay-1">
        <div class="body">
          <span class="tag"><?= esc($mission['vision_tag'] ?? 'Vision') ?></span>
          <h3><?= esc($mission['vision_title'] ?? '') ?></h3>
          <p><?= esc($mission['vision_content'] ?? '') ?></p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow"><?= esc($strengths_sec['eyebrow'] ?? 'Why Vidya Infra') ?></span>
      <h2><?= esc($strengths_sec['title'] ?? 'Core strengths') ?></h2>
    </div>
    <div class="grid-4">
      <?php $i = 0; foreach ($strengths as $item): ?>
        <div class="card reveal<?= $i ? ' reveal-delay-' . $i : '' ?>">
          <div class="body">
            <span class="tag"><?= esc($item['tag'] ?? '') ?></span>
            <h3><?= esc($item['title'] ?? '') ?></h3>
            <p><?= esc($item['content'] ?? '') ?></p>
          </div>
        </div>
      <?php $i = ($i + 1) % 4; endforeach; ?>
    </div>
  </div>
</section>

<section class="cta-band">
  <div class="container reveal">
    <h2><?= esc($cta['title'] ?? "Let's build something remarkable together.") ?></h2>
    <p><?= esc($cta['content'] ?? '') ?></p>
    <?php if (!empty($cta['button_text'])): ?>
      <a class="btn btn-primary" href="<?= esc(site_url(ltrim($cta['button_link'] ?? '/contact', '/'))) ?>"><?= esc($cta['button_text']) ?></a>
    <?php endif; ?>
  </div>
</section>
