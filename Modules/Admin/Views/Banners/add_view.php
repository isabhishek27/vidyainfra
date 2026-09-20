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
                                        <a href="<?php echo site_url('admin/banners');?>">Banner</a>
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
						
						<?php echo form_open_multipart('admin/banners/add');?>							
                            
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Banner Section</label>
								<div class="col-sm-12 col-md-10">									
                                    <?php $post_banner_val = set_value('banner_section');?>
                                    <select class="form-control" name="banner_section" id="banner_section">
                                        <option value=''>Select Section</option>
                                        <?php
                                        foreach($banner_section as $bk=>$bv){
                                            $bs_sel = ($bk==$post_banner_val)?'selected':'';
                                            echo '<option value="'.$bk.'" '.$bs_sel.'>'.$bv.'</option>';
                                        }
                                        ?>

                                    </select>
                                    <small class="text-danger"><?php echo isset($validation['banner_section']) ? $validation['banner_section'] : null;  ?></small>
								</div>
							</div>
                            <div id="image_container">
                                <?php
                                
                                for($i=1;$i<=5;$i++){
                                    echo ($i==2)?'<div class="text-danger">Only for home page add more 4 banners</div>':'';
                                ?>            
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Banner Image<?php echo $i;?></label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control" type="file" name="banner_image<?php echo $i;?>"/>   
                                        <small class="text-danger"><?php echo isset($validation['banner_image1'.$i]) ? $validation['banner_image1'.$i] : null;  ?></small>

                                        <p>Recommended Image Dimension: 1920 X 800</p>
                                    </div>
                                </div>
                                <?php } ?>
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