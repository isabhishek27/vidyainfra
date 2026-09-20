<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container">
<div class="pd-ltr-20">
<div class="page-header">
  <div class="row">
    <div class="col-md-12">
      <div class="title"><h4><?= esc($page_heading) ?></h4></div>
    </div>
  </div>
</div>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<div class="card-box mb-30 p-4">
<?= form_open_multipart('admin/sitesettings') ?>
<?= csrf_field() ?>
<?php
$s = $settings ?? [];
$fields = [
  'website_name' => 'Website Name',
  'company_name' => 'Company Name',
  'phone' => 'Phone',
  'email' => 'Email',
  'whatsapp' => 'WhatsApp Number',
  'address' => 'Address',
  'google_map_url' => 'Google Map URL / Embed',
  'facebook_url' => 'Facebook URL',
  'instagram_url' => 'Instagram URL',
  'linkedin_url' => 'LinkedIn URL',
  'youtube_url' => 'YouTube URL',
  'footer_description' => 'Footer Description',
  'copyright_text' => 'Copyright Text',
  'seo_title' => 'SEO Title',
  'seo_description' => 'SEO Description',
  'seo_keywords' => 'SEO Keywords',
];
foreach ($fields as $key => $label):
  $isTextarea = in_array($key, ['address','footer_description','seo_description','google_map_url'], true);
?>
  <div class="form-group row">
    <label class="col-sm-3 col-form-label"><?= esc($label) ?></label>
    <div class="col-sm-9">
      <?php if ($isTextarea): ?>
        <textarea name="<?= esc($key) ?>" class="form-control" rows="3"><?= esc($s[$key] ?? '') ?></textarea>
      <?php else: ?>
        <input type="text" name="<?= esc($key) ?>" class="form-control" value="<?= esc($s[$key] ?? '') ?>">
      <?php endif; ?>
    </div>
  </div>
<?php endforeach; ?>
<?php foreach (['logo' => 'Logo', 'logo_alt' => 'Logo Alt', 'favicon' => 'Favicon', 'og_image' => 'Open Graph Image'] as $key => $label): ?>
  <div class="form-group row">
    <label class="col-sm-3 col-form-label"><?= esc($label) ?></label>
    <div class="col-sm-9">
      <?php if (!empty($s[$key])): ?>
        <div class="mb-2"><img src="<?= esc(uploaded_folder_url($s[$key])) ?>" style="max-height:60px" alt=""></div>
        <small class="text-muted"><?= esc($s[$key]) ?></small>
      <?php endif; ?>
      <input type="file" name="<?= esc($key) ?>" class="form-control-file" accept="image/*">
    </div>
  </div>
<?php endforeach; ?>
<div class="form-group row">
  <div class="col-sm-9 offset-sm-3">
    <button type="submit" class="btn btn-primary">Save Settings</button>
  </div>
</div>
<?= form_close() ?>
</div>
</div>
</div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
</body>
</html>
