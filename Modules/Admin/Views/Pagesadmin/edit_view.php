<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container"><div class="pd-ltr-20">
<div class="page-header"><div class="title"><h4><?= esc($page_heading) ?></h4></div></div>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<div class="card-box p-4 mb-30">
<?= form_open('admin/pagesadmin/edit/'.$row['id']) ?>
<?= csrf_field() ?>
<div class="form-group"><label>Title</label><input name="title" class="form-control" value="<?= esc($row['title']) ?>"></div>
<div class="form-group"><label>Subtitle / Hero Title</label><input name="subtitle" class="form-control" value="<?= esc($row['subtitle'] ?? '') ?>"></div>
<div class="form-group"><label>Breadcrumb</label><input name="breadcrumb" class="form-control" value="<?= esc($row['breadcrumb'] ?? '') ?>"></div>
<div class="form-group"><label>SEO Title</label><input name="seo_title" class="form-control" value="<?= esc($row['seo_title'] ?? '') ?>"></div>
<div class="form-group"><label>SEO Description</label><textarea name="seo_description" class="form-control"><?= esc($row['seo_description'] ?? '') ?></textarea></div>
<div class="form-group"><label>SEO Keywords</label><input name="seo_keywords" class="form-control" value="<?= esc($row['seo_keywords'] ?? '') ?>"></div>
<div class="form-group"><label>Status</label><select name="status" class="form-control"><option value="1" <?= ((int)$row['status']===1)?'selected':'' ?>>Active</option><option value="0" <?= ((int)$row['status']===0)?'selected':'' ?>>Disabled</option></select></div>

<h5 class="mt-4">Page Sections</h5>
<?php foreach (($sections ?? []) as $sec): ?>
<div class="border rounded p-3 mb-3">
<input type="hidden" name="section_id[]" value="<?= (int)$sec['id'] ?>">
<div class="small text-muted mb-2">Key: <?= esc($sec['section_key']) ?></div>
<div class="form-group"><label>Eyebrow</label><input name="section_eyebrow[]" class="form-control" value="<?= esc($sec['eyebrow'] ?? '') ?>"></div>
<div class="form-group"><label>Title</label><input name="section_title[]" class="form-control" value="<?= esc($sec['title'] ?? '') ?>"></div>
<div class="form-group"><label>Content</label><textarea name="section_content[]" class="form-control" rows="4"><?= esc($sec['content'] ?? '') ?></textarea></div>
<div class="form-group"><label>Content 2</label><textarea name="section_content_2[]" class="form-control" rows="3"><?= esc($sec['content_2'] ?? '') ?></textarea></div>
<div class="form-row">
<div class="form-group col-md-4"><label>Button Text</label><input name="section_button_text[]" class="form-control" value="<?= esc($sec['button_text'] ?? '') ?>"></div>
<div class="form-group col-md-4"><label>Button Link</label><input name="section_button_link[]" class="form-control" value="<?= esc($sec['button_link'] ?? '') ?>"></div>
<div class="form-group col-md-4"><label>Status</label><select name="section_status[]" class="form-control"><option value="1" <?= ((int)$sec['status']===1)?'selected':'' ?>>Enabled</option><option value="0" <?= ((int)$sec['status']===0)?'selected':'' ?>>Disabled</option></select></div>
</div>
</div>
<?php endforeach; ?>

<button class="btn btn-primary">Save Page</button>
<a href="<?= site_url('admin/pagesadmin') ?>" class="btn btn-secondary">Back</a>
<?= form_close() ?>
</div></div></div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
</body></html>
