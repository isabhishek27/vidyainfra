<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container"><div class="pd-ltr-20">
<div class="page-header"><div class="row"><div class="col-md-8"><div class="title"><h4><?= esc($page_heading) ?></h4></div></div>
<div class="col-md-4 text-right"><a class="btn btn-primary" href="<?= site_url('admin/projectcategories/create') ?>">Add</a></div></div></div>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<div class="card-box p-3"><table class="table table-striped"><thead><tr><th>Order</th><th>Name</th><th>Filter Class</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach (($result ?? []) as $row): ?>
<tr>
<td><?= (int)$row['sort_order'] ?></td>
<td><?= esc($row['name']) ?></td>
<td><?= esc($row['filter_class']) ?></td>
<td><?= ((int)$row['status']===1)?'Active':'Disabled' ?></td>
<td><a class="btn btn-sm btn-primary" href="<?= site_url('admin/projectcategories/edit/'.$row['id']) ?>">Edit</a>
<a class="btn btn-sm btn-danger" href="<?= site_url('admin/projectcategories/delete/'.$row['id']) ?>" onclick="return confirm('Delete?')">Delete</a></td>
</tr>
<?php endforeach; ?>
</tbody></table></div></div></div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
</body></html>
