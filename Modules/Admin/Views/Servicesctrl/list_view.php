<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container"><div class="pd-ltr-20">
<div class="page-header"><div class="row">
<div class="col-md-8"><div class="title"><h4><?= esc($page_heading) ?></h4></div></div>
<div class="col-md-4 text-right"><a href="<?= site_url('admin/services/create') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add Service</a></div>
</div></div>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<div class="card-box mb-20 p-3">
<?= form_open('admin/services', 'method="get" class="mb-3"') ?>
<input type="search" name="keyword" value="<?= esc($keyword ?? '') ?>" class="form-control form-control-sm d-inline-block" style="width:220px" placeholder="Search">
<button class="btn btn-sm btn-primary">Search</button>
<?= form_close() ?>
<?= form_open('admin/services', 'id="form_listing"') ?>
<input type="hidden" name="action_type" id="action_type">
<div class="mb-2">
<button type="button" class="btn btn-sm btn-outline-primary action" data-id="enable">Enable</button>
<button type="button" class="btn btn-sm btn-outline-primary action" data-id="disable">Disable</button>
<button type="button" class="btn btn-sm btn-outline-danger action" data-id="delete">Delete</button>
</div>
<table class="table table-striped">
<thead><tr><th><input type="checkbox" onclick="$('input[name*=arr_ids]').prop('checked',this.checked)"></th><th>Order</th><th>Title</th><th>Image</th><th>Status</th><th>Action</th></tr></thead>
<tbody>
<?php foreach (($result ?? []) as $row): ?>
<tr>
<td><input type="checkbox" name="arr_ids[]" value="<?= (int)$row['id'] ?>"></td>
<td><?= (int)$row['sort_order'] ?></td>
<td><strong><?= esc($row['title']) ?></strong><div class="small text-muted"><?= esc($row['slug']) ?></div></td>
<td><?php if ($row['featured_image']): ?><img src="<?= esc(uploaded_folder_url($row['featured_image'])) ?>" style="height:40px"><?php endif; ?></td>
<td><?= ((int)$row['status'] === 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Disabled</span>' ?></td>
<td>
<a href="<?= site_url('admin/services/edit/'.$row['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
<a href="<?= site_url('admin/services/delete/'.$row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this service?')">Delete</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?= form_close() ?>
<?= isset($pager) ? $pager->links() : '' ?>
</div></div></div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
<script>
document.querySelectorAll('.action').forEach(function(btn){
  btn.addEventListener('click', function(){
    if(this.dataset.id==='delete' && !confirm('Delete selected?')) return;
    document.getElementById('action_type').value = this.dataset.id;
    document.getElementById('form_listing').submit();
  });
});
</script>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
</body></html>
