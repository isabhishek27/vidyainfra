<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container"><div class="pd-ltr-20">
<div class="page-header"><div class="title"><h4><?= esc($page_heading) ?></h4></div></div>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<div class="card-box p-4 mb-3">
<?= form_open_multipart('admin/gallery') ?><?= csrf_field() ?>
<input type="text" name="title" class="form-control mb-2" placeholder="Optional title">
<input type="file" name="images[]" multiple accept="image/*" required>
<button class="btn btn-primary mt-2">Upload</button>
<?= form_close() ?>
</div>
<div class="card-box p-3"><div class="row">
<?php foreach (($result??[]) as $row): ?>
<div class="col-md-2 mb-3 text-center">
<img src="<?= esc(uploaded_folder_url($row['image_path'])) ?>" style="width:100%;height:100px;object-fit:cover">
<a class="btn btn-sm btn-danger mt-1" href="<?= site_url('admin/gallery/delete/'.$row['id']) ?>" onclick="return confirm('Delete?')">Delete</a>
</div>
<?php endforeach; ?>
</div></div></div></div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
</body></html>
