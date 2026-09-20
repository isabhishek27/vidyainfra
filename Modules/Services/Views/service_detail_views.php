<?php
$service = $service ?? [];
$children = $children ?? [];
?>
<section class="page-hero" style="background-image:linear-gradient(120deg,rgba(15,25,45,.88),rgba(15,25,45,.7)),url('<?= esc(uploaded_folder_url($service['featured_image'] ?? 'services/s1.jpg')) ?>');background-size:cover;background-position:center">
  <div class="container">
    <span class="eyebrow" style="color:var(--orange)">Our Services</span>
    <h1><?= esc($service['title'] ?? '') ?></h1>
    <div class="crumbs"><a href="<?= esc(site_url('/')) ?>">Home</a> / <a href="<?= esc(site_url('services')) ?>">Services</a> / <?= esc($service['title'] ?? '') ?></div>
  </div>
</section>
<section class="section">
  <div class="container">
    <?php if (!empty($service['featured_image'])): ?>
      <div class="media reveal" style="margin-bottom:32px">
        <img src="<?= esc(uploaded_folder_url($service['featured_image'])) ?>" alt="<?= esc($service['title']) ?>"/>
      </div>
    <?php endif; ?>
    <div class="reveal">
      <?php if (!empty($service['short_description'])): ?>
        <p><?= nl2br(esc($service['short_description'])) ?></p>
      <?php endif; ?>
      <?php if (!empty($service['full_description'])): ?>
        <div><?= $service['full_description'] ?></div>
      <?php endif; ?>
      <?php if (!empty($children)): ?>
        <h3 style="margin-top:24px">Subcategories</h3>
        <ul>
          <?php foreach ($children as $child): ?>
            <li><?= esc($child['title']) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <div style="margin-top:32px">
        <a class="btn btn-primary" href="<?= esc(site_url('services')) ?>">Back to Services</a>
      </div>
    </div>
  </div>
</section>
