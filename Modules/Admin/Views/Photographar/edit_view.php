<!DOCTYPE html>
<html>

<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>
<script src="<?php echo assets_image_url('admin/tinymce/js/tinymce/tinymce.min.js');?>" referrerpolicy="origin" crossorigin="anonymous"></script>

	<script src="<?php echo assets_image_url('admin/tinymce/load_tinymce.js');?>"></script>

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
                                        <a href="<?php echo site_url('admin/photographar');?>">Photographar</a>
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
						
						<?php echo form_open_multipart('admin/photographar/edit/'.$row->id);?>
                            <input type="hidden" name="id" value="<?php echo $row->id;?>">

							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Name</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Name" name="name" value="<?php echo set_value('name',$row->name);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['name']) ? $validation['name'] : null;  ?></small>
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Region</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Region" name="region" value="<?php echo set_value('region',$row->region);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['region']) ? $validation['region'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Country</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Country" name="country" value="<?php echo set_value('country',$row->country);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['country']) ? $validation['country'] : null;  ?></small>
								</div>
							</div>
                            
                            

                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Photo</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="file" name="photo"/>   
                                    <small class="text-danger"><?php echo isset($validation['photo']) ? $validation['photo'] : null;  ?></small>

                                     <?php
                                     $img_dir_path = FCPATH . 'uploads/photographar/'.$row->photo;
                                     if(is_file($img_dir_path)){
                                        $img_url_path = site_url('public/uploads/photographar/'.$row->photo);
                                        echo '<img src="'.$img_url_path.'" width="250" height="250" alt="">';
                                     }
                                    ?>
								</div>
							</div>
                            
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Facebook Link</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Facebook Link" name="fb_link" value="<?php echo set_value('fb_link',$row->fb_link);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['fb_link']) ? $validation['fb_link'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Instagram Link</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Instagram Link" name="insta_link" value="<?php echo set_value('insta_link',$row->insta_link);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['insta_link']) ? $validation['insta_link'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">X Link</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="X Link" name="x_link" value="<?php echo set_value('x_link', $row->x_link);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['x_link']) ? $validation['x_link'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Linkedin Link</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Linkedin Link" name="linkedin_link" value="<?php echo set_value('linkedin_link', $row->linkedin_link);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['linkedin_link']) ? $validation['linkedin_link'] : null;  ?></small>
								</div>
							</div>


                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">About</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control" rows="6" placeholder="About Photographar" name="about" id="cmscontainer"><?php echo set_value('about',$row->about);?></textarea>
                                    <small class="text-danger"><?php echo isset($validation['about']) ? $validation['about'] : null;  ?></small>
								</div>
							</div>
                            

                           <div class="modal-footer">
                            <input type="submit" value="Save" class="btn btn-primary" />
                            <a href="<?php echo site_url('admin/photographar');?>" class="btn btn-warning">Cancel</a>
                            </button>
                        </div>
                        <input type='hidden' name='page' value="<?php echo $curr_page;?>">  
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