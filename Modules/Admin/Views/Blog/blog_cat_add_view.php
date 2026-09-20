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
                                        <a href="<?php echo site_url('admin/blog/category');?>">Blog Categories</a>
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
						
						<?php echo form_open_multipart('admin/blog/category_add');?>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Category Name</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Category name" name="b_title" value="<?php echo set_value('b_title');?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['b_title']) ? $validation['b_title'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Category Image</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="file" name="b_image"/>   
                                    <small class="text-danger"><?php echo isset($validation['b_image']) ? $validation['b_image'] : null;  ?></small>
								</div>
							</div>
                            

                           <div class="modal-footer">
                            <input type="submit" value="Save" class="btn btn-primary" />
                            <a href="<?php echo site_url('admin/blog/category');?>" class="btn btn-warning">Cancel</a>
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