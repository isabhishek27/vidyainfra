<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container">
<div class="pd-ltr-20">
<div class="page-header mb-30">
  <div class="title"><h4>Dashboard</h4></div>
</div>
<div class="row">
<?php
$cards = [
  ['Total Projects', $stats['projects'] ?? 0, 'admin/projects'],
  ['Total Services', $stats['services'] ?? 0, 'admin/services'],
  ['Categories', $stats['project_categories'] ?? 0, 'admin/projectcategories'],
  ['Contact Enquiries', $stats['contact_enquiries'] ?? 0, 'admin/contact-enquiries'],
  ['Service Enquiries', $stats['service_enquiries'] ?? 0, 'admin/service-enquiries'],
  ['Gallery Images', $stats['gallery'] ?? 0, 'admin/gallery'],
  ['Media Files', $stats['media'] ?? 0, 'admin/media'],
];
foreach ($cards as $c): ?>
  <div class="col-xl-3 col-lg-4 col-md-6 mb-30">
    <a href="<?= site_url($c[2]) ?>" class="card-box height-100-p widget-style1">
      <div class="d-flex flex-wrap align-items-center">
        <div class="widget-data">
          <div class="h4 mb-0"><?= (int)$c[1] ?></div>
          <div class="weight-600 font-14"><?= esc($c[0]) ?></div>
        </div>
      </div>
    </a>
  </div>
<?php endforeach; ?>
</div>

<div class="row">
  <div class="col-md-6 mb-30">
    <div class="card-box p-3">
      <h5>Recent Contact Enquiries</h5>
      <table class="table table-sm"><thead><tr><th>Name</th><th>Status</th><th>Date</th></tr></thead><tbody>
      <?php foreach (($recent_contacts ?? []) as $r): ?>
        <tr>
          <td><a href="<?= site_url('admin/contact-enquiries/view/'.$r['id']) ?>"><?= esc($r['name']) ?></a></td>
          <td><?= esc($r['status']) ?></td>
          <td><?= esc($r['created_at']) ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (empty($recent_contacts)): ?><tr><td colspan="3">No enquiries yet.</td></tr><?php endif; ?>
      </tbody></table>
    </div>
  </div>
  <div class="col-md-6 mb-30">
    <div class="card-box p-3">
      <h5>Recent Projects</h5>
      <table class="table table-sm"><thead><tr><th>Title</th><th>Status</th></tr></thead><tbody>
      <?php foreach (($recent_projects ?? []) as $r): ?>
        <tr>
          <td><a href="<?= site_url('admin/projects/edit/'.$r['id']) ?>"><?= esc($r['title']) ?></a></td>
          <td><?= ((int)$r['status']===1)?'Published':'Draft' ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody></table>
    </div>
  </div>
</div>
</div>
</div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
</body>
</html>
