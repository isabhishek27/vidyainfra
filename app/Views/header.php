<?php
$uri = current_url(true);
$seg1 = (string) ($uri->getSegment(1) ?? '');
$curr_env = getenv('CI_ENVIRONMENT');

$settings = [];
try {
    $settingsModel = new \App\Models\SiteSettingsModel();
    $settings = $settingsModel->getAllAsArray();
} catch (\Throwable $e) {
    $settings = [];
}

$menuModel = new \App\Models\MenuModel();
$navItems = $menuModel->getItemsByLocation('header');
if (empty($navItems)) {
    $navItems = [
        ['title' => 'Home', 'url' => '/'],
        ['title' => 'About', 'url' => '/about'],
        ['title' => 'Projects', 'url' => '/projects'],
        ['title' => 'Services', 'url' => '/services'],
        ['title' => 'Contact', 'url' => '/contact'],
    ];
}

$logo = $settings['logo'] ?? 'logo/logo.png';
$logo2 = $settings['logo_alt'] ?? 'logo/logo2.png';
$siteName = $settings['website_name'] ?? 'Vidya Infra Construction';
$favicon = $settings['favicon'] ?? '';

$isActive = function (string $url) use ($seg1): string {
    $path = trim(parse_url($url, PHP_URL_PATH) ?? $url, '/');
    $path = preg_replace('#^(vidyainfra/)?#', '', $path);
    if ($path === '' || $path === 'home') {
        return ($seg1 === '' || $seg1 === 'home') ? 'active' : '';
    }
    return ($seg1 === $path || str_starts_with($seg1, $path)) ? 'active' : '';
};

$metaTitle = $meta_title ?? ($settings['seo_title'] ?? $siteName);
$metaDesc = $meta_desc ?? ($settings['seo_description'] ?? '');
$metaKeyword = $meta_keyword ?? ($settings['seo_keywords'] ?? '');
$ogImage = $og_image ?? ($settings['og_image'] ?? $logo);
$canonical = $canonical_url ?? current_url();
$robots = $robots ?? 'index,follow';
?>
<!doctype html>
<html lang="en">
<head>
<?php if ($curr_env === 'production') { ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-FG80TP7QXQ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-FG80TP7QXQ');
</script>
<?php } ?>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title><?= esc($metaTitle) ?></title>
<meta name="description" content="<?= esc($metaDesc) ?>"/>
<meta name="keywords" content="<?= esc($metaKeyword) ?>"/>
<meta name="robots" content="<?= esc($robots) ?>"/>
<link rel="canonical" href="<?= esc($canonical) ?>"/>
<meta property="og:title" content="<?= esc($metaTitle) ?>"/>
<meta property="og:description" content="<?= esc($metaDesc) ?>"/>
<meta property="og:image" content="<?= esc(uploaded_folder_url($ogImage)) ?>"/>
<meta property="og:type" content="website"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="<?= esc($metaTitle) ?>"/>
<meta name="twitter:description" content="<?= esc($metaDesc) ?>"/>
<meta name="twitter:image" content="<?= esc(uploaded_folder_url($ogImage)) ?>"/>
<?php if ($favicon) { ?>
<link rel="icon" href="<?= esc(uploaded_folder_url($favicon)) ?>"/>
<?php } else { ?>
<link rel="icon" href="<?= esc(base_url('public/favicon.ico')) ?>"/>
<?php } ?>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="<?= esc(assets_url('css/style.css')) ?>"/>
<link rel="stylesheet" href="<?= esc(assets_url('css/responsive.css')) ?>"/>
<link rel="stylesheet" href="<?= esc(assets_url('css/animation.css')) ?>"/>
<?= $extra_css ?? '' ?>
</head>
<body>
<header class="site-header transparent">
  <div class="container header-inner">
    <a href="<?= esc(site_url('/')) ?>" class="brand" title="<?= esc($siteName) ?>">
      <span class="brand-name">
        <img src="<?= esc(uploaded_folder_url($logo)) ?>" class="logo1" alt="<?= esc($siteName) ?>" title="<?= esc($siteName) ?>">
        <img src="<?= esc(uploaded_folder_url($logo2)) ?>" alt="<?= esc($siteName) ?>" class="logo2" title="<?= esc($siteName) ?>">
      </span>
    </a>
    <div class="header-cta">
      <nav class="nav" id="nav">
        <?php foreach ($navItems as $item): ?>
          <a class="<?= esc($isActive($item['url'])) ?>" href="<?= esc(site_url(ltrim($item['url'], '/'))) ?>"><?= esc($item['title']) ?></a>
        <?php endforeach; ?>
      </nav>
      <button class="hamburger" aria-label="Menu"><span></span><span></span><span></span></button>
    </div>
  </div>
</header>
<div class="nav-backdrop"></div>
