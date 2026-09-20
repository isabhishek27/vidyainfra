<?php
$services = $services ?? [];
$intro = $intro ?? [];
$page = $page ?? [];
$heroImage = $page['hero_image'] ?? 'services/s2.jpg';
?>
<section class="page-hero" style="background-image:linear-gradient(120deg,rgba(15,25,45,.88),rgba(15,25,45,.7)),url('<?= esc(uploaded_folder_url($heroImage)) ?>');background-size:cover;background-position:center">
  <div class="container">
    <span class="eyebrow" style="color:var(--orange)">Our Services</span>
    <h1><?= esc($page['subtitle'] ?? 'End-to-end services, one accountable team') ?></h1>
    <div class="crumbs"><a href="<?= esc(site_url('/')) ?>">Home</a> / Services</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow"><?= esc($intro['eyebrow'] ?? 'What we deliver') ?></span>
      <h2><?= esc($intro['title'] ?? 'From concept to completion') ?></h2>
      <p><?= esc($intro['content'] ?? '') ?></p>
    </div>
    <div class="grid-3">
      <?php $delay = 0; foreach ($services as $svc): ?>
        <div class="card service-card reveal<?= $delay ? ' reveal-delay-' . $delay : '' ?>">
          <div class="thumb">
            <?php if (!empty($svc['featured_image'])): ?>
              <img src="<?= esc(uploaded_folder_url($svc['featured_image'])) ?>" alt="<?= esc($svc['title']) ?>"/>
            <?php endif; ?>
          </div>
          <div class="body">
            <h3><?= esc($svc['title']) ?></h3>
            <div class="card-cta">
              <button class="btn btn-primary"
                type="button"
                data-enquire="<?= esc($svc['title']) ?>"
                data-service-id="<?= (int) $svc['id'] ?>">Enquire Now</button>
            </div>
          </div>
        </div>
      <?php
        $delay = ($delay + 1) % 3;
      endforeach; ?>
    </div>
  </div>
</section>

<div class="modal-backdrop" id="enquiry-modal">
  <div class="modal">
    <button class="modal-close" aria-label="Close" type="button">×</button>
    <h3>Enquire about this service</h3>
    <p class="sub">Share a few details and our team will reach out within 24 hours.</p>
    <?= form_open(site_url('services/enquire'), ['class' => 'form', 'style' => 'border:0;padding:0;box-shadow:none', 'id' => 'service-enquiry-form']) ?>
      <?= csrf_field() ?>
      <input type="hidden" name="service_id" id="enquiry-service-id" value=""/>
      <div class="field"><label>Service</label><input type="text" name="service" id="enquiry-service" readonly required/></div>
      <div class="row">
        <div class="field"><label>Your Name</label><input name="name" required/></div>
        <div class="field"><label>Phone</label><input name="phone" required/></div>
      </div>
      <div class="field"><label>Email</label><input type="email" name="email" required/></div>
      <div class="field"><label>Message</label><textarea name="message" placeholder="Tell us about your project..."></textarea></div>
      <?php if (!empty($error)): ?>
        <div class="error" style="color:#c00;margin-bottom:12px"><?= esc($error) ?></div>
      <?php endif; ?>
      <button class="btn btn-primary" style="width:100%;justify-content:center" type="submit">Send Enquiry</button>
    <?= form_close() ?>
  </div>
</div>

<?php if (!empty($success)): ?>
<div class="modal-backdrop open" id="thankyou-modal" role="dialog" aria-modal="true" aria-labelledby="thankyou-title">
  <div class="modal" style="text-align:center">
    <button class="modal-close" aria-label="Close" type="button">×</button>
    <h3 id="thankyou-title" style="margin-bottom:10px">Thank you!</h3>
    <p class="sub" style="margin-bottom:22px"><?= esc($success) ?></p>
    <button class="btn btn-primary" type="button" data-close-thankyou>Close</button>
  </div>
</div>
<?php endif; ?>
