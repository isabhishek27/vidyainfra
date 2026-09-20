<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?>
<style>
.vi-upload-card{border:1px solid #e5eaf0;border-radius:12px;background:#fff;overflow:hidden;max-width:480px;margin-bottom:24px}
.vi-upload-card .vi-upload-head{padding:14px 16px;border-bottom:1px solid #eef2f6;display:flex;align-items:center;justify-content:space-between;gap:12px}
.vi-upload-card .vi-upload-head h6{margin:0;font-size:14px;font-weight:600;color:#0b132b}
.vi-upload-card .vi-upload-head span{font-size:12px;color:#6c757d}
.vi-dropzone{position:relative;min-height:180px;padding:18px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;cursor:pointer;background:linear-gradient(180deg,#f8fafc 0%,#fff 100%);transition:.2s ease}
.vi-dropzone:hover,.vi-dropzone.is-dragover{background:#f0f7fc}
.vi-dropzone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.vi-dropzone .vi-dz-icon{width:52px;height:52px;border-radius:14px;background:#e8f3fb;color:#1276BD;display:flex;align-items:center;justify-content:center;font-size:24px;margin-bottom:12px}
.vi-dropzone .vi-dz-title{font-size:14px;font-weight:600;color:#0b132b;margin:0 0 4px}
.vi-dropzone .vi-dz-sub{font-size:12px;color:#6c757d;margin:0}
.vi-featured-preview{width:100%;max-width:280px;aspect-ratio:4/3;border-radius:10px;overflow:hidden;border:1px solid #e5eaf0;background:#f4f6f8;margin-bottom:12px;display:none}
.vi-featured-preview.show{display:block}
.vi-featured-preview img{width:100%;height:100%;object-fit:cover;display:block}
</style>
</head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container"><div class="pd-ltr-20">
<div class="page-header"><div class="title"><h4><?= esc($page_heading) ?></h4></div></div>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<div class="card-box p-4 mb-30">
<?= form_open_multipart($row ? 'admin/services/edit/'.$row['id'] : 'admin/services/create') ?>
<?= csrf_field() ?>
<?php
$r = $row ?? [];
$featuredUrl = !empty($r['featured_image']) ? uploaded_folder_url($r['featured_image']) : '';
?>
<div class="form-group"><label>Title *</label><input name="title" class="form-control" required value="<?= esc(old('title', $r['title'] ?? '')) ?>"></div>
<div class="form-group"><label>Short Description</label><textarea name="short_description" class="form-control" rows="3"><?= esc(old('short_description', $r['short_description'] ?? '')) ?></textarea></div>
<div class="form-group"><label>Full Description</label><textarea name="full_description" class="form-control" rows="6"><?= esc(old('full_description', $r['full_description'] ?? '')) ?></textarea></div>

<div class="vi-upload-card">
  <div class="vi-upload-head">
    <h6>Featured Image</h6>
    <span>JPG, PNG, WEBP · Max 10MB</span>
  </div>
  <label class="vi-dropzone" id="featured-dropzone" for="featured_image_input">
    <div class="vi-featured-preview<?= $featuredUrl ? ' show' : '' ?>" id="featured-preview">
      <?php if ($featuredUrl): ?><img src="<?= esc($featuredUrl) ?>" alt="Featured"><?php endif; ?>
    </div>
    <div class="vi-dz-icon"><i class="dw dw-image1"></i></div>
    <p class="vi-dz-title" id="featured-title"><?= $featuredUrl ? 'Replace featured image' : 'Drop image here or click to browse' ?></p>
    <p class="vi-dz-sub" id="featured-sub">Recommended 1200×800 or larger</p>
    <input type="file" name="featured_image" id="featured_image_input" accept="image/jpeg,image/png,image/webp,image/gif">
  </label>
</div>

<div class="form-group"><label>SEO Title</label><input name="seo_title" class="form-control" value="<?= esc(old('seo_title', $r['seo_title'] ?? '')) ?>"></div>
<div class="form-group"><label>SEO Description</label><textarea name="seo_description" class="form-control" rows="2"><?= esc(old('seo_description', $r['seo_description'] ?? '')) ?></textarea></div>
<div class="form-row">
<div class="form-group col-md-3"><label>Sort Order</label><input type="number" name="sort_order" class="form-control" value="<?= esc(old('sort_order', $r['sort_order'] ?? 0)) ?>"></div>
<div class="form-group col-md-3"><label>Status</label><select name="status" class="form-control"><option value="1" <?= (string)old('status', $r['status'] ?? '1')==='1'?'selected':'' ?>>Active</option><option value="0" <?= (string)old('status', $r['status'] ?? '')==='0'?'selected':'' ?>>Disabled</option></select></div>
<div class="form-group col-md-3"><label>Show in Footer</label><select name="show_in_footer" class="form-control"><option value="1" <?= (string)old('show_in_footer', $r['show_in_footer'] ?? '1')==='1'?'selected':'' ?>>Yes</option><option value="0" <?= (string)old('show_in_footer', $r['show_in_footer'] ?? '')==='0'?'selected':'' ?>>No</option></select></div>
</div>
<button class="btn btn-primary" type="submit">Save</button>
<a href="<?= site_url('admin/services') ?>" class="btn btn-secondary">Cancel</a>
<?= form_close() ?>
</div></div></div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
<script>
(function () {
  var zone = document.getElementById('featured-dropzone');
  var input = document.getElementById('featured_image_input');
  var preview = document.getElementById('featured-preview');
  var title = document.getElementById('featured-title');
  var sub = document.getElementById('featured-sub');
  if (!zone || !input) return;

  ['dragenter','dragover'].forEach(function (evt) {
    zone.addEventListener(evt, function (e) { e.preventDefault(); zone.classList.add('is-dragover'); });
  });
  ['dragleave','drop'].forEach(function (evt) {
    zone.addEventListener(evt, function (e) { e.preventDefault(); zone.classList.remove('is-dragover'); });
  });

  input.addEventListener('change', function () {
    var file = this.files && this.files[0];
    if (!file) return;
    preview.innerHTML = '<img src="' + URL.createObjectURL(file) + '" alt="Featured preview">';
    preview.classList.add('show');
    title.textContent = file.name;
    sub.textContent = (file.size / 1024).toFixed(0) + ' KB · Ready to upload';
  });
})();
</script>
</body></html>
