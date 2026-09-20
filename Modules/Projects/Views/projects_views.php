<?php
$page = $page ?? [];
$categories = $categories ?? [];
$gallery = $gallery ?? [];
$heroImage = $page['hero_image'] ?? 'hero/slide3.jpg';

$catFilter = static function (array $cat): string {
    $raw = $cat['slug'] ?? ($cat['filter_class'] ?? '');
    $raw = strtolower((string) preg_replace('/[^a-z0-9]+/i', '-', (string) $raw));
    return 'cat-' . trim($raw, '-');
};
?>
<section class="page-hero" style="background-image:linear-gradient(120deg,rgba(15,25,45,.88),rgba(15,25,45,.7)),url('<?= esc(uploaded_folder_url($heroImage)) ?>');background-size:cover;background-position:center">
  <div class="container">
    <span class="eyebrow" style="color:var(--orange)">Our Portfolio</span>
    <h1><?= esc($page['subtitle'] ?? 'Projects that define skylines') ?></h1>
    <div class="crumbs"><a href="<?= esc(site_url('/')) ?>">Home</a> / Projects</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="filters reveal" id="projectFilters">
      <button data-filter="" class="active" type="button">All</button>
      <?php foreach ($categories as $cat): ?>
        <button data-filter=".<?= esc($catFilter($cat)) ?>" type="button"><?= esc($cat['name']) ?></button>
      <?php endforeach; ?>
    </div>
    <div class="row justify-content-center">
      <div class="col col-md-12">
        <div class="gallery-container" id="animated-thumbnails-gallery">
          <?php foreach ($gallery as $item):
            $filter = $catFilter([
                'slug' => $item['category_slug'] ?? '',
                'filter_class' => $item['filter_class'] ?? '',
            ]);
            $src = uploaded_folder_url($item['image_path']);
            $caption = '<h4>' . esc($item['category_name'] ?? '') . '</h4><p>' . esc($item['caption'] ?: $item['project_title']) . '</p>';
            if (!empty($item['client'])) {
                $caption = '<h4>' . esc($item['category_name'] ?? '') . '</h4><p>' . esc($item['project_title']) . '</p>';
            }
          ?>
            <a data-lg-size="<?= esc($item['lg_size'] ?? '1280-720') ?>"
               class="gallery-item <?= esc($filter) ?>"
               data-src="<?= esc($src) ?>"
               data-sub-html="<?= esc($caption) ?>">
              <img alt="<?= esc($item['alt_text'] ?? $item['project_title']) ?>" class="img-responsive" src="<?= esc($src) ?>" />
            </a>
          <?php endforeach; ?>
        </div>
        <p id="project-empty" class="text-center" style="display:none;color:var(--text-2);margin-top:24px">No projects in this category yet.</p>
      </div>
    </div>
  </div>
</section>

<section class="cta-band">
  <div class="container reveal">
    <h2>Your project could be next.</h2>
    <p>Share your requirement and we'll respond with a tailored proposal.</p>
    <a class="btn btn-primary" href="<?= esc(site_url('contact')) ?>">Enquire Now →</a>
  </div>
</section>
