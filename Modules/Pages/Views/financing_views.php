<section class="page-hero">
  <div class="container">
    <span class="eyebrow">Auto Financing</span>
    <h1><?php echo esc($page_title ?? 'Think Outside The Bank');?></h1>
    <div class="crumbs"><a href="<?php echo site_url('/');?>">Home</a> / Financing</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php
    $content = $page_content ?? '';
    $content = str_replace('{{base_url}}', site_url('/'), $content);
    echo $content;
    ?>
  </div>
</section>
