<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container"><div class="pd-ltr-20">
<div class="page-header"><div class="title"><h4><?= esc($page_heading) ?></h4></div></div>
<div class="card-box p-3"><table class="table table-striped"><thead><tr><th>Title</th><th>Slug</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach (($result ?? []) as $row): ?>
<tr>
<td><?= esc($row['title']) ?></td>
<td><?= esc($row['slug']) ?></td>
<td><?= ((int)$row['status']===1)?'Active':'Disabled' ?></td>
<td><a class="btn btn-sm btn-primary" href="<?= site_url('admin/pagesadmin/edit/'.$row['id']) ?>">Edit</a></td>
</tr>
<?php endforeach; ?>
</tbody></table></div></div></div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
</body></html>
