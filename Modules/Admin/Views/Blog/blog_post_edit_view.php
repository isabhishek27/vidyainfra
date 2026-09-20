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
                                        <a href="<?php echo site_url('admin/blog/post');?>">Blog Post</a>
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
						
						<?php echo form_open_multipart('admin/blog/post_edit/'.$row->id);?>
                            <input type="hidden" name="id" value="<?php echo $row->id;?>">

                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Post Title</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Post title" name="b_title" value="<?php echo set_value('b_title',$row->b_title);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['b_title']) ? $validation['b_title'] : null;  ?></small>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Post Image</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="file" name="b_image"/>   
                                    <small class="text-danger"><?php echo isset($validation['b_image']) ? $validation['b_image'] : null;  ?></small>

                                     <?php
                                     $img_dir_path = FCPATH . 'uploads/blog/'.$row->b_image;
                                     if(is_file($img_dir_path)){
                                        $img_url_path = site_url('public/uploads/blog/'.$row->b_image);
                                        echo '<img src="'.$img_url_path.'" width="250" height="250" alt="">';
                                     }
                                    ?>
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Post Content</label>
								<div class="col-sm-12 col-md-10">
									<textarea name="b_content" id="cmscontainer" style="height: 200px;"
                                                            class="form-control border-radius-0"
                                                            placeholder="Enter text ..."><?php echo set_value('b_content',$row->b_content);?></textarea>
                                    <small class="text-danger"><?php echo isset($validation['b_content']) ? $validation['b_content'] : null;  ?></small>
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Meta Title</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Meta Title" name="meta_title" value="<?php echo set_value('meta_title',$row->meta_title);?>"/>
                                    <small class="text-danger"><?php echo isset($validation['meta_title']) ? $validation['meta_title'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Meta Description</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control" name="meta_desc" style="height: 100px;"><?php echo set_value('meta_desc',$row->meta_desc);?></textarea>
                                    <small class="text-danger"><?php echo isset($validation['meta_desc']) ? $validation['meta_desc'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Meta Keyword</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control" name="meta_keyword" style="height: 100px;"><?php echo set_value('meta_keyword',$row->meta_keyword);?></textarea>
                                    <small class="text-danger"><?php echo isset($validation['meta_keyword']) ? $validation['meta_keyword'] : null;  ?></small>
								</div>
							</div>

                            
                            

                           <div class="modal-footer">
                            <input type="submit" value="Save" class="btn btn-primary" />
                            <a href="<?php echo site_url('admin/blog/post');?>" class="btn btn-warning">Cancel</a>
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