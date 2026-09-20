<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= esc(base_url()) ?></loc>
        <lastmod><?= esc(date('Y-m-d')) ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php foreach ($result as $url): ?>
    <url>
        <loc><?= esc(site_url($url->page_slug)) ?></loc>
        <lastmod><?= esc(date('Y-m-d')) ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>

    <?php foreach ($result2 as $url): ?>
    <url>
        <loc><?= esc(site_url($url->slug)) ?></loc>
        <lastmod><?= esc(date('Y-m-d')) ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>

    <?php foreach ($result3 as $url): ?>
    <url>
        <loc><?= esc(site_url('photo-workshop/'.$url->url_slug)) ?></loc>
        <lastmod><?= esc(date('Y-m-d')) ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>

    <?php foreach ($result4 as $url): ?>
    <url>
        <loc><?= esc(site_url('blog/article/'.$url->b_slug)) ?></loc>
        <lastmod><?= esc(date('Y-m-d')) ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>
</urlset>