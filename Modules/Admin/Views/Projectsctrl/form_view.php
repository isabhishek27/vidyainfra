<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?>
<style>
.vi-upload-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px}
@media (max-width:991px){.vi-upload-grid{grid-template-columns:1fr}}
.vi-upload-card{border:1px solid #e5eaf0;border-radius:12px;background:#fff;overflow:hidden}
.vi-upload-card .vi-upload-head{padding:14px 16px;border-bottom:1px solid #eef2f6;display:flex;align-items:center;justify-content:space-between;gap:12px}
.vi-upload-card .vi-upload-head h6{margin:0;font-size:14px;font-weight:600;color:#0b132b}
.vi-upload-card .vi-upload-head span{font-size:12px;color:#6c757d}
.vi-dropzone{position:relative;min-height:180px;padding:18px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;cursor:pointer;background:linear-gradient(180deg,#f8fafc 0%,#fff 100%);transition:.2s ease}
.vi-dropzone:hover,.vi-dropzone.is-dragover{background:#f0f7fc;border-color:#1276BD}
.vi-dropzone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.vi-dropzone .vi-dz-icon{width:52px;height:52px;border-radius:14px;background:#e8f3fb;color:#1276BD;display:flex;align-items:center;justify-content:center;font-size:24px;margin-bottom:12px}
.vi-dropzone .vi-dz-title{font-size:14px;font-weight:600;color:#0b132b;margin:0 0 4px}
.vi-dropzone .vi-dz-sub{font-size:12px;color:#6c757d;margin:0}
.vi-featured-preview{width:100%;max-width:280px;aspect-ratio:4/3;border-radius:10px;overflow:hidden;border:1px solid #e5eaf0;background:#f4f6f8;margin-bottom:12px;display:none}
.vi-featured-preview.show{display:block}
.vi-featured-preview img{width:100%;height:100%;object-fit:cover;display:block}
.vi-gallery-previews{display:none;grid-template-columns:repeat(auto-fill,minmax(88px,1fr));gap:10px;width:100%;margin-top:14px}
.vi-gallery-previews.show{display:grid}
.vi-gallery-previews .thumb{position:relative;aspect-ratio:1;border-radius:8px;overflow:hidden;border:1px solid #e5eaf0;background:#f4f6f8}
.vi-gallery-previews .thumb img{width:100%;height:100%;object-fit:cover}
.vi-gallery-previews .thumb .badge-first{position:absolute;left:6px;top:6px;background:#1276BD;color:#fff;font-size:10px;padding:2px 6px;border-radius:999px}
.vi-existing-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px}
.vi-existing-item{border:1px solid #e5eaf0;border-radius:12px;overflow:hidden;background:#fff;transition:.2s}
.vi-existing-item.is-primary{border-color:#1276BD;box-shadow:0 0 0 2px rgba(18,118,189,.15)}
.vi-existing-item .shot{aspect-ratio:4/3;background:#f4f6f8;overflow:hidden}
.vi-existing-item .shot img{width:100%;height:100%;object-fit:cover;display:block}
.vi-existing-item .meta{padding:10px 12px;display:flex;align-items:center;justify-content:space-between;gap:8px;font-size:12px}
.vi-existing-item .meta label{margin:0;display:inline-flex;align-items:center;gap:5px;cursor:pointer;font-weight:500;color:#0b132b}
.vi-existing-item .meta label.remove{color:#c0392b}
.vi-section-label{font-size:14px;font-weight:600;color:#0b132b;margin:0 0 12px}
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
<?php
$formAction = !empty($row['id'])
    ? site_url('admin/projects/edit/' . $row['id'])
    : site_url('admin/projects/create');
$r = $row ?? [];
$featuredUrl = !empty($r['featured_image']) ? uploaded_folder_url($r['featured_image']) : '';
?>
<form action="<?= esc($formAction) ?>" method="post" enctype="multipart/form-data" id="project-form">
<?= csrf_field() ?>
<div class="form-group"><label>Title *</label><input name="title" class="form-control" required value="<?= esc(old('title', $r['title'] ?? '')) ?>"></div>
<div class="form-group"><label>Category *</label>
<select name="category_id" class="form-control" required>
<option value="">Select</option>
<?php foreach (($categories ?? []) as $c): ?>
<option value="<?= (int)$c['id'] ?>" <?= (string)old('category_id', $r['category_id'] ?? '') === (string)$c['id'] ? 'selected' : '' ?>><?= esc($c['name']) ?></option>
<?php endforeach; ?>
</select></div>
<div class="form-row">
<div class="form-group col-md-4"><label>Location</label><input name="location" class="form-control" value="<?= esc(old('location', $r['location'] ?? '')) ?>"></div>
<div class="form-group col-md-4"><label>Client</label><input name="client" class="form-control" value="<?= esc(old('client', $r['client'] ?? '')) ?>"></div>
<div class="form-group col-md-4"><label>Project Type</label><input name="project_type" class="form-control" value="<?= esc(old('project_type', $r['project_type'] ?? '')) ?>"></div>
</div>
<div class="form-group"><label>Short Description</label><textarea name="short_description" class="form-control" rows="3"><?= esc(old('short_description', $r['short_description'] ?? '')) ?></textarea></div>
<div class="form-group"><label>Full Description</label><textarea name="full_description" class="form-control" rows="5"><?= esc(old('full_description', $r['full_description'] ?? '')) ?></textarea></div>

<div class="vi-upload-grid">
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

  <div class="vi-upload-card">
    <div class="vi-upload-head">
      <h6>Gallery Images</h6>
      <span>Multiple files supported</span>
    </div>
    <label class="vi-dropzone" id="gallery-dropzone" for="gallery_image_input">
      <div class="vi-dz-icon"><i class="dw dw-upload1"></i></div>
      <p class="vi-dz-title">Drop gallery images or click to browse</p>
      <p class="vi-dz-sub">First selected image becomes Primary by default</p>
      <div class="vi-gallery-previews" id="gallery-previews"></div>
      <input type="file" name="gallery[]" id="gallery_image_input" accept="image/jpeg,image/png,image/webp,image/gif" multiple>
    </label>
  </div>
</div>

<?php if (!empty($images)): ?>
<?php
$hasPrimary = false;
foreach ($images as $img) {
    if (!empty($img['is_primary'])) { $hasPrimary = true; break; }
}
?>
<div class="form-group mb-4">
  <p class="vi-section-label">Existing Gallery</p>
  <div class="vi-existing-grid">
  <?php foreach ($images as $i => $img):
    $isPrimary = !empty($img['is_primary']) || (!$hasPrimary && $i === 0);
  ?>
    <div class="vi-existing-item<?= $isPrimary ? ' is-primary' : '' ?>" data-existing-item>
      <div class="shot"><img src="<?= esc(uploaded_folder_url($img['image_path'])) ?>" alt=""></div>
      <div class="meta">
        <label><input type="radio" name="primary_image" value="<?= (int)$img['id'] ?>" <?= $isPrimary ? 'checked' : '' ?> data-primary-radio> Primary</label>
        <label class="remove"><input type="checkbox" name="remove_images[]" value="<?= (int)$img['id'] ?>"> Remove</label>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>

<div class="form-row">
<div class="form-group col-md-3"><label>Completion Date</label><input type="date" name="completion_date" class="form-control" value="<?= esc(old('completion_date', $r['completion_date'] ?? '')) ?>"></div>
<div class="form-group col-md-3"><label>Sort Order</label><input type="number" name="sort_order" class="form-control" value="<?= esc(old('sort_order', $r['sort_order'] ?? 0)) ?>"></div>
<div class="form-group col-md-3"><label>Status</label><select name="status" class="form-control"><option value="1" <?= (string)old('status',$r['status']??'1')==='1'?'selected':'' ?>>Published</option><option value="0" <?= (string)old('status',$r['status']??'')==='0'?'selected':'' ?>>Unpublished</option></select></div>
<div class="form-group col-md-3"><label>Featured</label><select name="is_featured" class="form-control"><option value="0" <?= (string)old('is_featured',$r['is_featured']??'0')==='0'?'selected':'' ?>>No</option><option value="1" <?= (string)old('is_featured',$r['is_featured']??'')==='1'?'selected':'' ?>>Yes</option></select></div>
</div>
<div class="form-group"><label>SEO Title</label><input name="seo_title" class="form-control" value="<?= esc(old('seo_title', $r['seo_title'] ?? '')) ?>"></div>
<div class="form-group"><label>SEO Description</label><textarea name="seo_description" class="form-control" rows="2"><?= esc(old('seo_description', $r['seo_description'] ?? '')) ?></textarea></div>
<button class="btn btn-primary" type="submit">Save</button>
<a href="<?= site_url('admin/projects') ?>" class="btn btn-secondary">Cancel</a>
</form>
</div></div></div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
<script>
(function () {
  function bindDropzone(zone) {
    if (!zone) return;
    ['dragenter','dragover'].forEach(function (evt) {
      zone.addEventListener(evt, function (e) { e.preventDefault(); zone.classList.add('is-dragover'); });
    });
    ['dragleave','drop'].forEach(function (evt) {
      zone.addEventListener(evt, function (e) { e.preventDefault(); zone.classList.remove('is-dragover'); });
    });
  }

  var featuredInput = document.getElementById('featured_image_input');
  var featuredPreview = document.getElementById('featured-preview');
  var featuredTitle = document.getElementById('featured-title');
  var featuredSub = document.getElementById('featured-sub');
  var featuredZone = document.getElementById('featured-dropzone');
  bindDropzone(featuredZone);

  if (featuredInput) {
    featuredInput.addEventListener('change', function () {
      var file = this.files && this.files[0];
      if (!file) return;
      var url = URL.createObjectURL(file);
      featuredPreview.innerHTML = '<img src="' + url + '" alt="Featured preview">';
      featuredPreview.classList.add('show');
      featuredTitle.textContent = file.name;
      featuredSub.textContent = (file.size / 1024).toFixed(0) + ' KB · Ready to upload';
    });
  }

  var galleryInput = document.getElementById('gallery_image_input');
  var galleryPreviews = document.getElementById('gallery-previews');
  var galleryZone = document.getElementById('gallery-dropzone');
  bindDropzone(galleryZone);

  if (galleryInput) {
    galleryInput.addEventListener('change', function () {
      var files = Array.prototype.slice.call(this.files || []);
      galleryPreviews.innerHTML = '';
      if (!files.length) {
        galleryPreviews.classList.remove('show');
        return;
      }
      galleryPreviews.classList.add('show');
      files.slice(0, 12).forEach(function (file, idx) {
        var thumb = document.createElement('div');
        thumb.className = 'thumb';
        var img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.alt = file.name;
        thumb.appendChild(img);
        if (idx === 0) {
          var badge = document.createElement('span');
          badge.className = 'badge-first';
          badge.textContent = 'Primary';
          thumb.appendChild(badge);
        }
        galleryPreviews.appendChild(thumb);
      });
    });
  }

  document.querySelectorAll('[data-primary-radio]').forEach(function (radio) {
    radio.addEventListener('change', function () {
      document.querySelectorAll('[data-existing-item]').forEach(function (item) {
        item.classList.toggle('is-primary', item.querySelector('[data-primary-radio]') === radio && radio.checked);
      });
    });
  });
})();
</script>
</body></html>
