<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container"><div class="pd-ltr-20">
<div class="page-header"><div class="title"><h4><?= esc($page_heading) ?></h4></div></div>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<div class="card-box p-3">
<?= form_open('admin/service-enquiries','method="get" class="mb-3"') ?>
<input name="keyword" value="<?= esc($keyword ?? '') ?>" class="form-control form-control-sm d-inline-block" style="width:200px" placeholder="Search">
<select name="status" class="form-control form-control-sm d-inline-block" style="width:160px">
<option value="">All statuses</option>
<?php foreach (['new','read','contacted','closed'] as $st): ?>
<option value="<?= $st ?>" <?= ($status??'')===$st?'selected':'' ?>><?= ucfirst($st) ?></option>
<?php endforeach; ?>
</select>
<button class="btn btn-sm btn-primary">Filter</button>
<?= form_close() ?>
<table class="table table-striped"><thead><tr><th>ID</th><th>Service</th><th>Name</th><th>Phone</th><th>Email</th><th>Status</th><th>Date</th><th></th></tr></thead><tbody>
<?php foreach (($result ?? []) as $row): ?>
<tr>
<td><?= (int)$row['id'] ?></td>
<td><?= esc($row['service_name']) ?> <?php if($row['service_id']): ?><small>(#<?= (int)$row['service_id'] ?>)</small><?php endif; ?></td>
<td><?= esc($row['name']) ?></td>
<td><?= esc($row['phone']) ?></td>
<td><?= esc($row['email']) ?></td>
<td><?= esc($row['status']) ?></td>
<td><?= esc($row['created_at']) ?></td>
<td>
<a class="btn btn-sm btn-primary" href="<?= site_url('admin/service-enquiries/view/'.$row['id']) ?>">View</a>
<a class="btn btn-sm btn-danger" href="<?= site_url('admin/service-enquiries/delete/'.$row['id']) ?>" onclick="return confirm('Delete?')">Delete</a>
</td>
</tr>
<?php endforeach; ?>
</tbody></table>
<?= isset($pager) ? $pager->links() : '' ?>
</div></div></div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
</body></html>
