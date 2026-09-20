<!DOCTYPE html>
<html>
<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container">
<div class="pd-ltr-20 xs-pd-20-10">
<div class="page-header">
<div class="title"><h4><?php echo $page_heading;?></h4></div>
</div>
<div class="pd-20 card-box mb-30">
<?php echo form_open_multipart('admin/productgallery/add');?>
<div class="form-group row"><label class="col-md-2 col-form-label">Name</label><div class="col-md-10"><input class="form-control" type="text" name="name" value="<?php echo set_value('name');?>"/><small class="text-danger"><?php echo isset($validation['name']) ? $validation['name'] : null;?></small></div></div>
<div class="form-group row"><label class="col-md-2 col-form-label">Photo</label><div class="col-md-10"><input class="form-control" type="file" name="photo"/><small class="text-danger"><?php echo isset($validation['photo']) ? $validation['photo'] : null;?></small></div></div>
<div class="form-group row"><label class="col-md-2 col-form-label">Product</label><div class="col-md-10">
<select class="form-control" name="product_id">
<option value="">Select Product</option>
<?php if(is_array($product_list)){ foreach($product_list as $pv){
    echo '<option value="'.$pv->id.'" '.set_select('product_id',$pv->id).'>'.esc($pv->name).'</option>';
}} ?>
</select>
<small class="text-danger"><?php echo isset($validation['product_id']) ? $validation['product_id'] : null;?></small>
</div></div>
<div class="modal-footer"><input type="submit" value="Save" class="btn btn-primary"/><a href="<?php echo site_url('admin/productgallery');?>" class="btn btn-warning">Cancel</a></div>
<?php echo form_close();?>
</div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
</div></div>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
</body>
</html>
