<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container"><div class="pd-ltr-20">
<div class="page-header"><div class="row">
<div class="col-md-8"><div class="title"><h4><?= esc($page_heading) ?></h4></div></div>
<div class="col-md-4 text-right"><a href="<?= site_url('admin/projects/create') ?>" class="btn btn-primary">Add Project</a></div>
</div></div>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<div class="card-box p-3 mb-20">
<?= form_open('admin/projects','method="get" class="mb-3"') ?><input name="keyword" value="<?= esc($keyword ?? '') ?>" class="form-control form-control-sm d-inline-block" style="width:220px" placeholder="Search"><button class="btn btn-sm btn-primary">Search</button><?= form_close() ?>
<?= form_open('admin/projects','id="form_listing"') ?><input type="hidden" name="action_type" id="action_type">
<div class="mb-2">
<button type="button" class="btn btn-sm btn-outline-primary action" data-id="enable">Enable</button>
<button type="button" class="btn btn-sm btn-outline-primary action" data-id="disable">Disable</button>
<button type="button" class="btn btn-sm btn-outline-danger action" data-id="delete">Delete</button>
</div>
<table class="table table-striped"><thead><tr><th></th><th>Title</th><th>Category</th><th>Image</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach (($result ?? []) as $row): ?>
<tr>
<td><input type="checkbox" name="arr_ids[]" value="<?= (int)$row['id'] ?>"></td>
<td><strong><?= esc($row['title']) ?></strong><?php if (!empty($row['is_featured'])): ?> <span class="badge badge-info">Featured</span><?php endif; ?></td>
<td><?= esc($row['category_name'] ?? '') ?></td>
<td><?php if (!empty($row['featured_image'])): ?><img src="<?= esc(uploaded_folder_url($row['featured_image'])) ?>" style="height:40px"><?php endif; ?></td>
<td><?= ((int)$row['status']===1)?'Active':'Disabled' ?></td>
<td><a class="btn btn-sm btn-primary" href="<?= site_url('admin/projects/edit/'.$row['id']) ?>">Edit</a>
<a class="btn btn-sm btn-danger" href="<?= site_url('admin/projects/delete/'.$row['id']) ?>" onclick="return confirm('Delete?')">Delete</a></td>
</tr>
<?php endforeach; ?>
</tbody></table><?= form_close() ?>
<?= isset($pager) ? $pager->links() : '' ?>
</div></div></div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
<script>document.querySelectorAll('.action').forEach(b=>b.addEventListener('click',function(){if(this.dataset.id==='delete'&&!confirm('Delete selected?'))return;document.getElementById('action_type').value=this.dataset.id;document.getElementById('form_listing').submit();}));</script>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
</body></html>
