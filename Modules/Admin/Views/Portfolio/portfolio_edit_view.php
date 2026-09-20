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
                                        <a href="<?php echo site_url('admin/portfolio');?>">Portfolio</a>
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
						
						<?php echo form_open_multipart('admin/portfolio/edit/'.$row->id);?>
                            <input type="hidden" name="id" value="<?php echo $row->id;?>">
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Title</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Portfolio title" name="title" value="<?php echo set_value('title',$row->title);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['title']) ? $validation['title'] : null;  ?></small>
								</div>
							</div>
                             <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Tags</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control" name="tags" style="height: 100px;"><?php echo set_value('tags',$row->tags);?></textarea>
                                     <div>[ Comma seprated multipe tags(,) ]</div>
                                    <small class="text-danger"><?php echo isset($validation['tags']) ? $validation['tags'] : null;  ?></small>
								</div>
							</div>


                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Country</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Country" name="country" value="<?php echo set_value('country',$row->country_name);?>"/>
                                    <small class="text-danger"><?php echo isset($validation['country']) ? $validation['country'] : null;  ?></small>
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Portfolio Image</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="file" name="portfolio_image"/>   
                                    <small class="text-danger"><?php echo isset($validation['portfolio_image']) ? $validation['portfolio_image'] : null;  ?></small>

                                     <?php
                                     $img_dir_path = FCPATH . 'uploads/portfolio/'.$row->portfolio_image;
                                     if(is_file($img_dir_path)){
                                        $img_url_path = site_url('public/uploads/portfolio/'.$row->portfolio_image);
                                        echo '<img src="'.$img_url_path.'" width="250" height="250" alt="">';
                                     }
                                    ?>
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Description</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control" name="description" style="height: 100px;"><?php echo set_value('description',$row->description);?></textarea>
                                    <small class="text-danger"><?php echo isset($validation['description']) ? $validation['description'] : null;  ?></small>
								</div>
							</div>
                            

                           <div class="modal-footer">
                            <input type="submit" value="Save" class="btn btn-primary" />
                            <a href="<?php echo site_url('admin/portfolio');?>" class="btn btn-warning">Cancel</a>
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