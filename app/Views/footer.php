<?php
$settings = $settings ?? [];
if (empty($settings)) {
    try {
        $settings = (new \App\Models\SiteSettingsModel())->getAllAsArray();
    } catch (\Throwable $e) {
        $settings = [];
    }
}

$socials = $socials ?? [];
if (empty($socials)) {
    try {
        $socials = (new \App\Models\SocialLinkModel())->getActive();
    } catch (\Throwable $e) {
        $socials = [];
    }
}

$footerServices = $footerServices ?? [];
if (empty($footerServices)) {
    try {
        $footerServices = (new \App\Models\ServiceModel())->getFooterServices();
    } catch (\Throwable $e) {
        $footerServices = [];
    }
}

$footerNav = $footerNav ?? [];
if (empty($footerNav)) {
    try {
        $footerNav = (new \App\Models\MenuModel())->getItemsByLocation('footer_company');
    } catch (\Throwable $e) {
        $footerNav = [];
    }
}

$logo = $settings['logo'] ?? 'logo/logo.png';
$footerDesc = $settings['footer_description'] ?? 'Architectural design & construction firm delivering premium projects across India since 2008.';
$copyright = $settings['copyright_text'] ?? 'Vidya Infra Construction. All rights reserved.';
$phone = $settings['phone'] ?? '+91 8595189698';
$email = $settings['email'] ?? 'vidyainfra0203@gmail.com';
$address = $settings['address'] ?? "3rd Floor, B-164, Pandav Nagar,\nNew Delhi – 110092";
$phoneIcon = $settings['phone_icon'] ?? 'settings/phoneIcon.svg';
$emailIcon = $settings['email_icon'] ?? 'settings/emailIcon.svg';
$telHref = preg_replace('/\s+/', '', $phone);
?>
<footer class="site-footer">
  <div class="container footer-grid">
    <div>
      <div class="brand"><span class="brand-name"><img src="<?= esc(uploaded_folder_url($logo)) ?>" alt="<?= esc($settings['website_name'] ?? 'Vidya Infra') ?>"></span></div>
      <p><?= esc($footerDesc) ?></p>
      <div class="socials">
        <?php foreach ($socials as $s): ?>
          <a href="<?= esc($s['url']) ?>" target="_blank" rel="noopener" aria-label="<?= esc($s['platform']) ?>"><?= esc($s['icon'] ?? substr($s['platform'], 0, 2)) ?></a>
        <?php endforeach; ?>
      </div>
    </div>
    <div>
      <h4>Company</h4>
      <?php foreach ($footerNav as $item): ?>
        <a href="<?= esc(site_url(ltrim($item['url'], '/'))) ?>"><?= esc($item['title']) ?></a>
      <?php endforeach; ?>
    </div>
    <div>
      <h4>Services</h4>
      <?php foreach ($footerServices as $svc): ?>
        <a href="<?= esc(site_url('services')) ?>"><?= esc($svc['title']) ?></a>
        <?php if (!empty($svc['children'])): ?>
          <div style="margin-left: 20px;">
            <?php foreach ($svc['children'] as $child): ?>
              <a href="<?= esc(site_url('services')) ?>">- <?= esc($child['title']) ?></a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
    <div>
      <h4>Contact</h4>
      <p><strong>Address</strong><br/><?= nl2br(esc($address)) ?></p>
      <p>
        <a href="tel:<?= esc($telHref) ?>"><img src="<?= esc(uploaded_folder_url($phoneIcon)) ?>" style="display:inline-block;" alt=""> <?= esc($phone) ?></a>
        <a href="mailto:<?= esc($email) ?>"><img src="<?= esc(uploaded_folder_url($emailIcon)) ?>" style="display:inline-block;" alt=""> <?= esc($email) ?></a>
      </p>
      <p class="footer-follow"><strong>Follow Us</strong><br/>
        <?php foreach ($socials as $s): ?>
          <a href="<?= esc($s['url']) ?>" target="_blank" rel="noopener"><?= esc($s['label'] ?? ucfirst($s['platform'])) ?></a><br/>
        <?php endforeach; ?>
      </p>
    </div>
  </div>
  <div class="footer-bot">© <span id="yr"></span> <?= esc($copyright) ?>
    <br>
    Developed by
    <strong><a href="https://webidebi.com/web-designing" target="_blank"><span>Website Designing</span></a></strong>
    and
    <strong><a href="https://webidebi.com/seo-company" target="_blank"><span>SEO Company</span></a></strong>
    -
    <strong><a href="https://webidebi.com/" target="_blank"><span>Webidebi.Com</span></a></strong>
  </div>
</footer>

<script>document.getElementById('yr').textContent = new Date().getFullYear();</script>
<script src="<?= esc(assets_url('js/main.js')) ?>"></script>
<?= $extra_js ?? '' ?>
</body>
</html>
