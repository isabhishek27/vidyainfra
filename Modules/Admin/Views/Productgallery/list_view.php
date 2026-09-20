<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container">
<div class="pd-ltr-20">
<div class="page-header">
<div class="row">
<div class="col-md-8"><div class="title"><h4><?php echo $page_heading;?></h4></div>
<nav aria-label="breadcrumb"><ol class="breadcrumb">
<li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>">Home</a></li>
<li class="breadcrumb-item active"><?php echo $page_heading;?></li>
</ol></nav></div>
<div class="col-md-4 text-right">
<a href="<?php echo site_url('admin/productgallery/add');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>
</div>
</div>
</div>
<?php if (session()->getFlashdata('success') !== NULL){ ?><div class="alert alert-success"><?php echo session()->getFlashdata('success');?></div><?php } ?>
<div class="card-box mb-20 pb-20 pt-20">
<div class="row mb-20">
<div class="col-md-6">
<div class="dt-buttons btn-group">
<button class="btn btn-outline-primary action" data-id="enable" type="button">Enable</button>
<button class="btn btn-outline-primary action" data-id="disable" type="button">Disable</button>
<button class="btn btn-outline-primary action" data-id="delete" type="button">Delete</button>
</div>
</div>
<div class="col-md-6"><?php echo form_open('admin/productgallery','method="get"');?>
<div class="dataTables_filter"><label>Search:<input type="search" name="keyword" value="<?php echo esc($keyword);?>" class="form-control form-control-sm"></label></div>
<?php echo form_close();?></div>
</div>
<?php if(is_array($result) && count($result) > 0){ ?>
<?php echo form_open('admin/productgallery','id="form_listing"');?>
<input type="hidden" id="action_type" name="action_type">
<table class="table table-stripedt">
<thead><tr>
<th><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').prop('checked', this.checked);"></th>
<th>Name</th><th>Product</th><th>Image</th><th>Status</th><th>Action</th>
</tr></thead>
<tbody>
<?php foreach($result as $row){ ?>
<tr>
<td><input type="checkbox" name="arr_ids[]" value="<?php echo $row->id;?>"></td>
<td><?php echo esc($row->name);?></td>
<td><?php echo esc($row->product_name);?></td>
<td><?php
$path = FCPATH.'uploads/productsgallery/'.$row->photo;
if(!empty($row->photo) && is_file($path)){
    echo '<img src="'.site_url('public/uploads/productsgallery/'.$row->photo).'" width="100">';
}else{ echo 'No image'; }
?></td>
<td><?php echo ($row->status==1)?'<span class="badge badge-success">Enabled</span>':'<span class="badge badge-danger">Disabled</span>';?></td>
<td>
<a href="<?php echo site_url('admin/productgallery/edit/'.$row->id);?>">Edit</a> |
<a href="<?php echo site_url('admin/productgallery/delete/'.$row->id);?>" onclick="return confirm('Are you sure?');">Delete</a>
</td>
</tr>
<?php } ?>
</tbody>
</table>
<?php echo form_close();?>
<hr><?php echo $links;?>
<?php }else{ echo '<div class="text-center">No record(s) found.</div>'; } ?>
</div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
</div></div>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
<script>
$(document).on('click','.action',function(){
    var action=$(this).data('id');
    if($('input[name="arr_ids[]"]:checked').length==0){ alert('Please select at least one record.'); return false; }
    if(confirm('Are you sure?')){ $('#action_type').val(action); $('#form_listing').submit(); }
});
</script>
</body>
</html>
