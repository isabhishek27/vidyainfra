<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container"><div class="pd-ltr-20">
<div class="page-header"><div class="title"><h4><?= esc($page_heading) ?></h4></div></div>
<div class="card-box p-4">
<?= form_open_multipart(($row? $base.'/edit/'.$row['id'] : $base.'/create')) ?>
<?= csrf_field() ?>
<?php $r=$row??[]; ?>
<div class="form-group"><label>Name</label><input name="name" class="form-control" required value="<?= esc($r['name']??'') ?>"></div>
<div class="form-group"><label>Designation</label><input name="designation" class="form-control" value="<?= esc($r['designation']??'') ?>"></div>
<div class="form-group"><label>Company</label><input name="company" class="form-control" value="<?= esc($r['company']??'') ?>"></div>
<div class="form-group"><label>Content</label><textarea name="content" class="form-control" rows="4" required><?= esc($r['content']??'') ?></textarea></div>
<div class="form-group"><label>Rating</label><input type="number" min="1" max="5" name="rating" class="form-control" value="<?= esc($r['rating']??5) ?>"></div>
<div class="form-group"><label>Image</label><input type="file" name="image" accept="image/*" class="form-control-file"></div>
<div class="form-row">
<div class="form-group col-md-4"><label>Sort</label><input type="number" name="sort_order" class="form-control" value="<?= esc($r['sort_order']??0) ?>"></div>
<div class="form-group col-md-4"><label>Status</label><select name="status" class="form-control"><option value="1">Active</option><option value="0">Disabled</option></select></div>
</div>
<button class="btn btn-primary">Save</button>
<a href="<?= site_url($base) ?>" class="btn btn-secondary">Cancel</a>
<?= form_close() ?>
</div></div></div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
</body></html>
