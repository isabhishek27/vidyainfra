<!DOCTYPE html>
<html>

<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>

<body class="header-white sidebar-light">
	
    <?php echo view('Modules\Admin\Views\inc\header'); ?>

    <?php echo view('Modules\Admin\Views\inc\left'); ?>

	<div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4><?php echo $page_heading;?></h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url('admin/dashboard');?>">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url('admin/cms/categories');?>">CMS Categories</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?php echo $page_heading;?>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                       
                    </div>
                </div>

                 <!-- Default Basic Forms Start -->
					<div class="pd-20 card-box mb-30">
						
						<?php echo form_open('admin/cms/add_category');?>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Category Name</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Category name" name="cat_name" value="<?php echo set_value('cat_name');?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['cat_name']) ? $validation['cat_name'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Meta Title</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Meta Title" name="meta_title" value="<?php echo set_value('meta_title');?>"/>
                                    <small class="text-danger"><?php echo isset($validation['meta_title']) ? $validation['meta_title'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Meta Description</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control" name="meta_desc" style="height: 100px;"><?php echo set_value('meta_desc');?></textarea>
                                    <small class="text-danger"><?php echo isset($validation['meta_desc']) ? $validation['meta_desc'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Meta Keyword</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control" name="meta_keyword" style="height: 100px;"><?php echo set_value('meta_keyword');?></textarea>
                                    <small class="text-danger"><?php echo isset($validation['meta_keyword']) ? $validation['meta_keyword'] : null;  ?></small>
								</div>
							</div>

                           <div class="modal-footer">
                            <input type="submit" value="Save" class="btn btn-primary" />
                            <a href="<?php echo site_url('admin/cms/categories');?>" class="btn btn-warning">Cancel</a>
                            </button>
                        </div>  
						<?php echo form_close();?>
					 
					</div>
					<!-- Default Basic Forms End -->

                    

            </div>
        
			<?php echo view('Modules\Admin\Views\inc\footer'); ?>
        </div>
    </div>


	<?php echo view('Modules\Admin\Views\inc\bottom'); ?>

</body>

</html>