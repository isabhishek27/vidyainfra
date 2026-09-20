<?php
$page = $page ?? [];
$intro = $intro ?? [];
$heroImage = $page['hero_image'] ?? 'hero/slide2.jpg';
$phone = setting('phone', '+91 8595189698');
$email = setting('email', 'vidyainfra0203@gmail.com');
$address = setting('address', "3rd Floor, B-164, Pandav Nagar,\nNew Delhi – 110092");
$socials = (new \App\Models\SocialLinkModel())->getActive();
$telHref = preg_replace('/\s+/', '', $phone);
?>
<section class="page-hero" style="background-image:linear-gradient(120deg,rgba(15,25,45,.88),rgba(15,25,45,.7)),url('<?= esc(uploaded_folder_url($heroImage)) ?>');background-size:cover;background-position:center">
  <div class="container">
    <span class="eyebrow" style="color:var(--orange)">Contact</span>
    <h1><?= esc($page['subtitle'] ?? "Let's build together") ?></h1>
    <div class="crumbs"><a href="<?= esc(site_url('/')) ?>">Home</a> / Contact</div>
  </div>
</section>

<section class="section">
  <div class="container contact-wrap">
    <div class="contact-info reveal">
      <span class="eyebrow"><?= esc($intro['eyebrow'] ?? 'Get in touch') ?></span>
      <h2><?= esc($intro['title'] ?? "We'd love to hear about your project.") ?></h2>
      <p><?= esc($intro['content'] ?? '') ?></p>
      <div class="info-item"><span class="ico">📍</span><div><h4>Address</h4><p><?= nl2br(esc($address)) ?></p></div></div>
      <div class="info-item"><span class="ico">📞</span><div><h4>Call Us</h4><p><a href="tel:<?= esc($telHref) ?>"><?= esc($phone) ?></a></p></div></div>
      <div class="info-item"><span class="ico">✉️</span><div><h4>Email</h4><p><a href="mailto:<?= esc($email) ?>"><?= esc($email) ?></a></p></div></div>
      <div class="info-item"><span class="ico">🔗</span><div><h4>Follow Us</h4><p>
        <?php foreach ($socials as $s): ?>
          <a href="<?= esc($s['url']) ?>" target="_blank" rel="noopener"><?= esc($s['label'] ?? ucfirst($s['platform'])) ?></a><br/>
        <?php endforeach; ?>
      </p></div></div>
    </div>

    <?= form_open(site_url('contact/submit'), ['class' => 'form reveal reveal-delay-1', 'id' => 'contact-form']) ?>
      <?= csrf_field() ?>
      <?php if (!empty($success)): ?>
        <div class="success show" style="display:block;margin-bottom:16px"><?= esc($success) ?></div>
      <?php endif; ?>
      <?php if (!empty($error)): ?>
        <div style="color:#c00;margin-bottom:16px"><?= esc($error) ?></div>
      <?php endif; ?>
      <div class="row">
        <div class="field"><label>Full Name</label><input name="name" required value="<?= esc(old('name')) ?>"/></div>
        <div class="field"><label>Phone</label><input name="phone" required value="<?= esc(old('phone')) ?>"/></div>
      </div>
      <div class="field"><label>Email</label><input type="email" name="email" required value="<?= esc(old('email')) ?>"/></div>
      <div class="field"><label>Project Type</label>
        <select name="project_type" required>
          <?php foreach (['Residential','Commercial','Industrial','Infrastructure','Interior Fit-out'] as $opt): ?>
            <option value="<?= esc($opt) ?>" <?= old('project_type') === $opt ? 'selected' : '' ?>><?= esc($opt) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field"><label>Message</label><textarea name="message" placeholder="Tell us about your project..."><?= esc(old('message')) ?></textarea></div>
      <button class="btn btn-primary" style="width:100%;justify-content:center" type="submit">Send Message</button>
    <?= form_close() ?>
  </div>
</section>
