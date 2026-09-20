<?php
/**
 * Render a vehicle card (shared by home featured + inventory).
 * @var object $v product row
 */
if (!isset($v) || !is_object($v)) {
    return;
}
$images = [];
if (!empty($v->images) && is_array($v->images)) {
    $images = $v->images;
} elseif (!empty($v->photo) && is_file(FCPATH . 'uploads/products/' . $v->photo)) {
    $images[] = site_url('public/uploads/products/' . $v->photo);
} else {
    $images[] = 'https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=900&q=80';
}
$images = array_values(array_unique($images));
$hasGallery = count($images) > 1;

$isSold = ($v->stock_status === 'sold');
$badge = $isSold
    ? '<span class="badge badge-sold">Sold</span>'
    : '<span class="badge badge-available">Available</span>';
$btnClass = $isSold ? 'btn btn-outline' : 'btn btn-gold';
$price = '$' . number_format((float)$v->price, 0);
$sub = $v->subtitle;
if (empty($sub)) {
    $sub = $isSold ? 'Sold' : 'Available';
    if (!empty($v->is_certified)) {
        $sub .= ' • Certified';
    }
}

$desc_full = '';
$desc_preview = '';
$desc_has_more = false;
if (!empty($v->product_desc)) {
    // Keep line breaks for popup; collapse only for card preview
    $desc_full = trim(html_entity_decode(strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>'], ["\n", "\n", "\n", "\n\n"], $v->product_desc)), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    $desc_full = preg_replace("/[ \t]+/", ' ', $desc_full);
    $desc_full = preg_replace("/\n{3,}/", "\n\n", $desc_full);
    $desc_full = trim($desc_full);

    $desc_one_line = trim(preg_replace('/\s+/', ' ', $desc_full));
    if (mb_strlen($desc_one_line) > 200) {
        $desc_preview = rtrim(mb_substr($desc_one_line, 0, 200)) . '…';
        $desc_has_more = true;
    } else {
        $desc_preview = $desc_one_line;
        $desc_has_more = (mb_strlen($desc_full) > mb_strlen($desc_one_line));
    }
}
$card_id = 'veh-desc-' . (int)($v->id ?? 0) . '-' . substr(md5($v->name ?? uniqid()), 0, 6);
?>
<article class="vehicle-card" data-vehicle="<?php echo esc($v->name);?>" data-status="<?php echo esc($v->stock_status);?>">
  <div class="vehicle-img<?php echo $hasGallery ? ' has-gallery' : '';?>"<?php echo $hasGallery ? ' data-gallery-hover' : '';?>>
    <?php foreach ($images as $i => $src) { ?>
    <img src="<?php echo esc($src);?>" alt="<?php echo esc($v->name);?><?php echo $i > 0 ? ' photo '.($i+1) : '';?>" loading="<?php echo $i === 0 ? 'lazy' : 'eager';?>" class="vehicle-slide<?php echo $i === 0 ? ' is-active' : '';?>" data-slide-index="<?php echo (int)$i;?>"/>
    <?php } ?>
    <?php echo $badge;?>
    <?php if ($hasGallery) { ?>
    <div class="gallery-dots" aria-hidden="true">
      <?php foreach ($images as $i => $src) { ?>
      <span class="gallery-dot<?php echo $i === 0 ? ' is-active' : '';?>"></span>
      <?php } ?>
    </div>
    <?php } ?>
  </div>
  <div class="vehicle-body">
    <div class="vehicle-sub"><?php echo esc($sub);?></div>
    <h3 class="vehicle-title"><?php echo esc($v->name);?></h3>
    <div class="vehicle-price"><?php echo $price;?> <?php if(!empty($v->price_note)){ ?><small><?php echo esc($v->price_note);?></small><?php } ?></div>
    <div class="spec-grid">
      <div><span class="k">Mileage</span><span class="v"><?php echo esc($v->mileage ?: '—');?></span></div>
      <div><span class="k">Transmission</span><span class="v"><?php echo esc($v->transmission ?: '—');?></span></div>
      <div><span class="k">Exterior</span><span class="v"><?php echo esc($v->exterior_color ?: '—');?></span></div>
      <div><span class="k">Interior</span><span class="v"><?php echo esc($v->interior_color ?: '—');?></span></div>
    </div>
    <?php if ($desc_preview !== '') { ?>
    <div class="vehicle-desc-wrap">
      <p class="vehicle-desc"><?php echo esc($desc_preview);?></p>
      <?php if ($desc_has_more) { ?>
      <button type="button" class="view-more-desc" data-desc-target="<?php echo esc($card_id);?>" data-desc-title="<?php echo esc($v->name);?>">View More</button>
      <div id="<?php echo esc($card_id);?>" class="vehicle-desc-full" hidden><?php echo nl2br(esc($desc_full));?></div>
      <?php } ?>
    </div>
    <?php } ?>
    <a href="<?php echo site_url('inventory');?>#enquiry" class="<?php echo $btnClass;?>" data-enquire="<?php echo esc($v->name);?>">Enquire Now</a>
  </div>
</article>
