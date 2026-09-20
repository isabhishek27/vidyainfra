<!DOCTYPE html>
<html>
<head>
<?php echo view('Modules\Admin\Views\inc\top_head'); ?>
<script src="<?php echo assets_image_url('admin/tinymce/js/tinymce/tinymce.min.js');?>" referrerpolicy="origin" crossorigin="anonymous"></script>
<script src="<?php echo assets_image_url('admin/tinymce/load_tinymce.js');?>"></script>
</head>
<body class="header-white sidebar-light">
<?php echo view('Modules\Admin\Views\inc\header'); ?>
<?php echo view('Modules\Admin\Views\inc\left'); ?>
<div class="main-container">
<div class="pd-ltr-20 xs-pd-20-10">
<div class="min-height-200px">
<div class="page-header">
<div class="row"><div class="col-md-6 col-sm-12">
<div class="title"><h4><?php echo $page_heading;?></h4></div>
<nav aria-label="breadcrumb"><ol class="breadcrumb">
<li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard');?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?php echo site_url('admin/product');?>">Products</a></li>
<li class="breadcrumb-item active"><?php echo $page_heading;?></li>
</ol></nav>
</div></div>
</div>
<div class="pd-20 card-box mb-30">
<?php echo form_open_multipart('admin/product/add');?>
<div class="form-group row"><label class="col-md-2 col-form-label">Vehicle Title *</label><div class="col-md-10"><input class="form-control" type="text" name="name" value="<?php echo set_value('name');?>"/><small class="text-danger"><?php echo isset($validation['name']) ? $validation['name'] : null;?></small></div></div>
<div class="form-group row"><label class="col-md-2 col-form-label">Subtitle</label><div class="col-md-10"><input class="form-control" type="text" name="subtitle" value="<?php echo set_value('subtitle');?>" placeholder="e.g. Available • Certified"/></div></div>
<div class="form-group row"><label class="col-md-2 col-form-label">Photos * <small class="d-block text-muted">(Max 8)</small></label><div class="col-md-10">
<input class="form-control" type="file" name="photos[]" id="photos" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" multiple/>
<small class="text-muted">Select up to 8 images. First image will be the main photo.</small>
<small class="text-danger d-block"><?php echo isset($validation['photos']) ? $validation['photos'] : null;?></small>
</div></div>
<div class="form-group row">
<div class="col-md-4"><label>Year</label><input class="form-control" type="text" name="year" value="<?php echo set_value('year');?>"/></div>
<div class="col-md-4"><label>Make</label><input class="form-control" type="text" name="make" value="<?php echo set_value('make');?>"/></div>
<div class="col-md-4"><label>Model</label><input class="form-control" type="text" name="model" value="<?php echo set_value('model');?>"/></div>
</div>
<div class="form-group row">
<div class="col-md-4"><label>Price *</label><input class="form-control" type="text" name="price" value="<?php echo set_value('price');?>"/><small class="text-danger"><?php echo isset($validation['price']) ? $validation['price'] : null;?></small></div>
<div class="col-md-4"><label>Price Note</label><input class="form-control" type="text" name="price_note" value="<?php echo set_value('price_note');?>" placeholder="+ HST / Certified"/></div>
<div class="col-md-4"><label>Stock Status *</label>
<select class="form-control" name="stock_status">
<option value="available" <?php echo set_select('stock_status','available',true);?>>Available</option>
<option value="sold" <?php echo set_select('stock_status','sold');?>>Sold</option>
</select>
<small class="text-danger"><?php echo isset($validation['stock_status']) ? $validation['stock_status'] : null;?></small>
</div>
</div>
<div class="form-group row">
<div class="col-md-3"><label>Mileage</label><input class="form-control" type="text" name="mileage" value="<?php echo set_value('mileage');?>" placeholder="140,465 KM"/></div>
<div class="col-md-3"><label>Transmission</label><input class="form-control" type="text" name="transmission" value="<?php echo set_value('transmission','Automatic');?>"/></div>
<div class="col-md-3"><label>Exterior</label><input class="form-control" type="text" name="exterior_color" value="<?php echo set_value('exterior_color');?>"/></div>
<div class="col-md-3"><label>Interior</label><input class="form-control" type="text" name="interior_color" value="<?php echo set_value('interior_color');?>"/></div>
</div>
<div class="form-group row">
<div class="col-md-3"><label><input type="checkbox" name="is_featured" value="1" <?php echo set_checkbox('is_featured','1');?>> Featured on Home</label></div>
<div class="col-md-3"><label><input type="checkbox" name="is_certified" value="1" <?php echo set_checkbox('is_certified','1');?>> Certified</label></div>
</div>
<div class="form-group row"><label class="col-md-2 col-form-label">Description</label><div class="col-md-10"><textarea class="form-control tinymce" name="product_desc" rows="6"><?php echo set_value('product_desc');?></textarea></div></div>
<div class="form-group row"><label class="col-md-2 col-form-label">Meta Title</label><div class="col-md-10"><input class="form-control" type="text" name="meta_title" value="<?php echo set_value('meta_title');?>"/></div></div>
<div class="form-group row"><label class="col-md-2 col-form-label">Meta Description</label><div class="col-md-10"><textarea class="form-control" name="meta_desc" rows="2"><?php echo set_value('meta_desc');?></textarea></div></div>
<div class="form-group row"><label class="col-md-2 col-form-label">Meta Keyword</label><div class="col-md-10"><input class="form-control" type="text" name="meta_keyword" value="<?php echo set_value('meta_keyword');?>"/></div></div>
<div class="modal-footer">
<input type="submit" value="Save" class="btn btn-primary"/>
<a href="<?php echo site_url('admin/product');?>" class="btn btn-warning">Cancel</a>
</div>
<?php echo form_close();?>
</div>
</div>
<?php echo view('Modules\Admin\Views\inc\footer'); ?>
</div></div>
<?php echo view('Modules\Admin\Views\inc\bottom'); ?>
<script>
document.getElementById('photos').addEventListener('change', function(){
    if(this.files && this.files.length > 8){
        alert('You can upload a maximum of 8 photos.');
        this.value = '';
    }
});
</script>
</body>
</html>
