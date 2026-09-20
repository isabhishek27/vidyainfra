<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container"><div class="pd-ltr-20">
<div class="page-header"><div class="title"><h4><?= esc($page_heading) ?></h4></div></div>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<div class="card-box p-4 mb-3">
<?= form_open_multipart('admin/media') ?>
<?= csrf_field() ?>
<div class="form-row align-items-end">
<div class="form-group col-md-4"><label>Upload</label><input type="file" name="file" class="form-control-file" required accept="image/*"></div>
<div class="form-group col-md-3"><label>Folder / Module</label>
<select name="module" class="form-control">
<?php foreach (['gallery','pages','services','projects','project_gallery','hero','settings','logo','testimonials','team'] as $m): ?>
<option value="<?= $m ?>"><?= $m ?></option>
<?php endforeach; ?>
</select></div>
<div class="form-group col-md-2"><button class="btn btn-primary">Upload</button></div>
</div>
<?= form_close() ?>
</div>
<div class="card-box p-3">
<div class="row">
<?php foreach (($result ?? []) as $row): ?>
<div class="col-md-2 mb-3 text-center">
<img src="<?= esc(uploaded_folder_url($row['file_path'])) ?>" style="width:100%;height:100px;object-fit:cover">
<div class="small text-truncate"><?= esc($row['file_name']) ?></div>
<a class="btn btn-xs btn-danger btn-sm" href="<?= site_url('admin/media/delete/'.$row['id']) ?>" onclick="return confirm('Delete?')">Delete</a>
</div>
<?php endforeach; ?>
</div>
</div></div></div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
</body></html>
