<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container"><div class="pd-ltr-20">
<div class="page-header"><div class="title"><h4><?= esc($page_heading) ?></h4></div></div>
<div class="card-box p-4">
<?= form_open($row ? 'admin/projectcategories/edit/'.$row['id'] : 'admin/projectcategories/create') ?>
<?= csrf_field() ?>
<?php $r = $row ?? []; ?>
<div class="form-group"><label>Name</label><input name="name" class="form-control" required value="<?= esc($r['name'] ?? '') ?>"></div>
<div class="form-group"><label>Filter Class (e.g. civil, arch)</label><input name="filter_class" class="form-control" value="<?= esc($r['filter_class'] ?? '') ?>"></div>
<div class="form-group"><label>Description</label><textarea name="description" class="form-control"><?= esc($r['description'] ?? '') ?></textarea></div>
<div class="form-row">
<div class="form-group col-md-4"><label>Sort</label><input type="number" name="sort_order" class="form-control" value="<?= esc($r['sort_order'] ?? 0) ?>"></div>
<div class="form-group col-md-4"><label>Status</label><select name="status" class="form-control"><option value="1" <?= (($r['status']??1)==1)?'selected':'' ?>>Active</option><option value="0" <?= (($r['status']??1)==0)?'selected':'' ?>>Disabled</option></select></div>
</div>
<button class="btn btn-primary">Save</button>
<a href="<?= site_url('admin/projectcategories') ?>" class="btn btn-secondary">Cancel</a>
<?= form_close() ?>
</div></div></div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
</body></html>
