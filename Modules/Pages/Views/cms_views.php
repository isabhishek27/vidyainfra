<section class="page-hero">
  <div class="container">
    <span class="eyebrow">Legal</span>
    <h1><?php echo esc($page_title);?></h1>
    <div class="crumbs"><a href="<?php echo site_url('/');?>">Home</a> / <?php echo esc($page_title);?></div>
  </div>
</section>
<section class="section">
  <div class="container" style="max-width:900px">
    <div class="cms-content" style="line-height:1.7;color:#d8d8d8">
      <?php echo $page_content;?>
    </div>
  </div>
</section>
