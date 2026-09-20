<?php
$certificates = $certificates ?? [];
?>
<section class="page-hero">
  <div class="container">
    <span class="eyebrow" style="color:var(--orange)">Credentials</span>
    <h1>Certificates & Accreditations</h1>
    <div class="crumbs"><a href="<?= esc(site_url('/')) ?>">Home</a> / Certificates</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">Compliance & Quality</span>
      <h2>Built on verified credentials</h2>
      <p>Click any certificate to view it in full size.</p>
    </div>
    <div class="grid-4">
      <?php $i = 0; foreach ($certificates as $cert): ?>
        <div class="cert reveal<?= $i ? ' reveal-delay-' . $i : '' ?>" data-lightbox="<?= esc(uploaded_folder_url($cert)) ?>">
          <img src="<?= esc(uploaded_folder_url($cert)) ?>" alt="Certificate"/>
        </div>
      <?php $i = ($i + 1) % 4; endforeach; ?>
    </div>
  </div>
</section>

<div class="lightbox" id="lightbox">
  <button class="lightbox-close">×</button>
  <img alt="Certificate"/>
</div>
