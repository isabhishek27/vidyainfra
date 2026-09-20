<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container"><div class="pd-ltr-20">
<div class="page-header"><div class="title"><h4><?= esc($page_heading) ?></h4></div></div>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<?php $r = $row; ?>
<div class="card-box p-4 mb-30">
<p><strong>Service:</strong> <?= esc($r['service_name']) ?> <?php if ($r['service_id']): ?>(ID <?= (int)$r['service_id'] ?>)<?php endif; ?></p>
<p><strong>Name:</strong> <?= esc($r['name']) ?></p>
<p><strong>Phone:</strong> <?= esc($r['phone']) ?></p>
<p><strong>Email:</strong> <?= esc($r['email']) ?></p>
<p><strong>Message:</strong><br><?= nl2br(esc($r['message'])) ?></p>
<?= form_open('admin/service-enquiries/view/'.$r['id']) ?>
<?= csrf_field() ?>
<div class="form-group"><label>Status</label>
<select name="status" class="form-control" style="max-width:240px">
<?php foreach (['new','read','contacted','closed'] as $st): ?>
<option value="<?= $st ?>" <?= $r['status']===$st?'selected':'' ?>><?= ucfirst($st) ?></option>
<?php endforeach; ?>
</select></div>
<div class="form-group"><label>Admin Notes</label><textarea name="admin_notes" class="form-control" rows="4"><?= esc($r['admin_notes'] ?? '') ?></textarea></div>
<button class="btn btn-primary">Update</button>
<a href="<?= site_url('admin/service-enquiries') ?>" class="btn btn-secondary">Back</a>
<?= form_close() ?>
</div></div></div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
</body></html>
