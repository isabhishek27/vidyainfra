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
<div class="col-md-8 col-sm-6">
<div class="title"><h4><?php echo $page_heading;?></h4></div>
<nav aria-label="breadcrumb" role="navigation">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>">Home</a></li>
<li class="breadcrumb-item active" aria-current="page"><?php echo $page_heading;?></li>
</ol>
</nav>
</div>
<div class="col-md-4 col-sm-6 text-right">
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal"><i class="fa fa-filter"></i> Filter</button>
<a href="<?php echo site_url('admin/product/add');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>
</div>
</div>
</div>
<?php if (session()->getFlashdata('success') !== NULL){ ?><div class="alert alert-success" role="alert"><?php echo session()->getFlashdata('success');?></div><?php } ?>
<?php if (session()->getFlashdata('error') !== NULL){ ?><div class="alert alert-danger" role="alert"><?php echo session()->getFlashdata('error');?></div><?php } ?>
<div class="card-box mb-20 dataTables_wrapper dt-bootstrap4 pb-20 pt-20">
<div class="row mb-20 align-items-start">
<div class="col-sm-12 col-lg-8 mb-2 mb-lg-0">
<div class="dt-buttons product-actions d-flex flex-wrap" style="gap:8px;">
<button class="btn btn-sm btn-outline-primary action" data-id="enable" type="button"><span>Enable</span></button>
<button class="btn btn-sm btn-outline-primary action" data-id="disable" type="button"><span>Disable</span></button>
<button class="btn btn-sm btn-outline-primary action" data-id="delete" type="button"><span>Delete</span></button>
<button class="btn btn-sm btn-outline-primary action" data-id="set_featured" type="button"><span>Set Featured</span></button>
<button class="btn btn-sm btn-outline-primary action" data-id="unset_featured" type="button"><span>Unset Featured</span></button>
<button class="btn btn-sm btn-outline-primary action" data-id="update_order" type="button"><span>Update Order</span></button>
</div>
</div>
<div class="col-sm-12 col-lg-4">
<?php echo form_open('admin/product','method="get"');?>
<div class="dataTables_filter text-lg-right"><label>Search:<input type="search" name="keyword" value="<?php echo esc($keyword);?>" class="form-control form-control-sm" placeholder="Search by name" style="display:inline-block;width:auto;margin-left:6px;"></label></div>
<?php echo form_close();?>
</div>
</div>
<?php if(is_array($result) && count($result) > 0){ ?>
<?php echo form_open('admin/product','id="form_listing"');?>
<input type="hidden" id="action_type" name="action_type">
<table class="table nowrap table-stripedt">
<thead>
<tr>
<th style="width:5%"><div class="dt-checkbox"><input type="checkbox" id="example-select-all" onclick="$('input[name*=\'arr_ids\']').prop('checked', this.checked);"><span class="dt-checkbox-label"></span></div></th>
<th style="width:8%;">Order</th>
<th>Vehicle</th>
<th>Price / Specs</th>
<th>Image</th>
<th>Stock</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php foreach($result as $row){ ?>
<tr>
<td><div class="dt-checkbox"><input type="checkbox" name="arr_ids[]" value="<?php echo $row->id;?>"><span class="dt-checkbox-label"></span></div></td>
<td><input type="number" class="form-control form-control-sm" name="disp_order[<?php echo $row->id;?>]" value="<?php echo (int)$row->disp_order;?>" min="0" style="width:80px;"></td>
<td>
<strong><?php echo esc($row->name);?></strong>
<div class="font-14"><?php echo esc($row->subtitle);?></div>
<div class="font-14"><?php echo esc($row->year.' '.$row->make.' '.$row->model);?></div>
<?php if($row->is_featured){ ?><span class="badge badge-info">Featured</span><?php } ?>
<?php if($row->is_certified){ ?><span class="badge badge-primary">Certified</span><?php } ?>
</td>
<td>
<div>$<?php echo number_format((float)$row->price, 2);?> <?php echo esc($row->price_note);?></div>
<div class="font-14">Mileage: <?php echo esc($row->mileage);?></div>
<div class="font-14">Trans: <?php echo esc($row->transmission);?></div>
<div class="font-14">Ext/Int: <?php echo esc($row->exterior_color);?> / <?php echo esc($row->interior_color);?></div>
</td>
<td>
<?php
$img_dir_path = FCPATH . 'uploads/products/'.$row->photo;
if(!empty($row->photo) && is_file($img_dir_path)){
    echo '<img src="'.site_url('public/uploads/products/'.$row->photo).'" width="120" alt="">';
}else{
    echo 'No image';
}
?>
</td>
<td>
<?php if($row->stock_status=='sold'){ ?>
<span class="badge badge-danger">Sold</span>
<?php }else{ ?>
<span class="badge badge-success">Available</span>
<?php } ?>
</td>
<td>
<?php if($row->status==1){ ?><span class="badge badge-success">Enabled</span>
<?php }elseif($row->status==0){ ?><span class="badge badge-danger">Disabled</span><?php } ?>
</td>
<td>
<div class="dropdown">
<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown"><i class="dw dw-more"></i></a>
<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
<a class="dropdown-item" href="<?php echo site_url('admin/product/edit/'.$row->id);?><?php echo (($curr_paging)!=NULL)?'?page='.$curr_paging:'';?>"><i class="dw dw-pencil"></i> Edit</a>
<a class="dropdown-item" href="<?php echo site_url('admin/product/delete/'.$row->id);?>" onclick="return confirm('Are you sure?');"><i class="icon-copy ion-ios-trash-outline"></i> Delete</a>
</div>
</div>
</td>
</tr>
<?php } ?>
</tbody>
</table>
<?php echo form_close();?>
<hr><?php echo $links;?>
<?php }else{ echo '<div class="text-center" style="min-height:200px;">No record(s) found.</div>'; } ?>
</div>

<?php echo form_open('admin/product', 'method="GET"');?>
<div class="modal" id="modal">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
<div class="modal-content">
<div class="modal-header"><h5 class="modal-title">Filter</h5><button type="button" class="close" data-dismiss="modal"><span>×</span></button></div>
<div class="modal-body">
<div class="row">
<div class="col-md-4"><div class="form-group"><label>Keyword</label><input type="text" name="keyword" value="<?php echo esc($keyword);?>" class="form-control"></div></div>
<div class="col-md-4"><div class="form-group"><label>Status</label>
<select class="form-control" name="status">
<option value="">Select Status</option>
<option value="1" <?php echo ($status==1)?'selected':'';?>>Enabled</option>
<option value="0" <?php echo ($status==='0'||$status===0)?'selected':'';?>>Disabled</option>
</select></div></div>
<div class="col-md-4"><div class="form-group"><label>Stock</label>
<select class="form-control" name="stock_status">
<option value="">All</option>
<option value="available" <?php echo ($stock_status=='available')?'selected':'';?>>Available</option>
<option value="sold" <?php echo ($stock_status=='sold')?'selected':'';?>>Sold</option>
</select></div></div>
</div>
</div>
<div class="modal-footer"><button type="submit" class="btn btn-primary">Filter</button><a href="<?php echo site_url('admin/product');?>" class="btn btn-secondary">Reset</a></div>
</div></div></div>
<?php echo form_close();?>

<?php echo view('Modules\Admin\Views\inc\footer'); ?>
</div></div>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
<script>
$(document).on('click','.action',function(){
    var action=$(this).data('id');
    if(action==='update_order'){
        $('#action_type').val(action);
        $('#form_listing').submit();
        return false;
    }
    if($('input[name="arr_ids[]"]:checked').length==0){ alert('Please select at least one record.'); return false; }
    if(confirm('Are you sure?')){ $('#action_type').val(action); $('#form_listing').submit(); }
});
</script>
</body>
</html>
