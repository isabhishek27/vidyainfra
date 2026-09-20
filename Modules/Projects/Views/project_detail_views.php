<?php
$project = $project ?? [];
$images = $images ?? [];
?>
<section class="page-hero" style="background-image:linear-gradient(120deg,rgba(15,25,45,.88),rgba(15,25,45,.7)),url('<?= esc(uploaded_folder_url($project['featured_image'] ?? 'hero/slide3.jpg')) ?>');background-size:cover;background-position:center">
  <div class="container">
    <span class="eyebrow" style="color:var(--orange)">Project</span>
    <h1><?= esc($project['title'] ?? '') ?></h1>
    <div class="crumbs"><a href="<?= esc(site_url('/')) ?>">Home</a> / <a href="<?= esc(site_url('projects')) ?>">Projects</a> / <?= esc($project['title'] ?? '') ?></div>
  </div>
</section>
<section class="section">
  <div class="container">
    <?php if (!empty($project['short_description'])): ?>
      <p class="reveal"><?= nl2br(esc($project['short_description'])) ?></p>
    <?php endif; ?>
    <div class="grid-3" style="margin-top:24px">
      <?php foreach ($images as $img): ?>
        <div class="card reveal">
          <div class="thumb"><img src="<?= esc(uploaded_folder_url($img['image_path'])) ?>" alt="<?= esc($img['alt_text'] ?? $project['title']) ?>"/></div>
        </div>
      <?php endforeach; ?>
    </div>
    <div style="margin-top:32px">
      <a class="btn btn-primary" href="<?= esc(site_url('projects')) ?>">Back to Projects</a>
    </div>
  </div>
</section>
