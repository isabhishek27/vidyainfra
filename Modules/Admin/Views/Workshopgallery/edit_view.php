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
                                        <a href="<?php echo site_url('admin/workshopgallery');?>">Workshop Gallery</a>
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
						
						<?php echo form_open_multipart('admin/workshopgallery/edit/'.$row->id);?>
                            <input type="hidden" name="id" value="<?php echo $row->id;?>">

							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Name</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Name" name="name" value="<?php echo set_value('name',$row->name);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['name']) ? $validation['name'] : null;  ?></small>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Photo</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="file" name="photo"/>   
                                    <small class="text-danger"><?php echo isset($validation['photo']) ? $validation['photo'] : null;  ?></small>

                                     <?php
                                     $img_dir_path = FCPATH . 'uploads/workshopgallery/'.$row->photo;
                                     if(is_file($img_dir_path)){
                                        $img_url_path = site_url('public/uploads/workshopgallery/'.$row->photo);
                                        echo '<img src="'.$img_url_path.'" width="250" height="250" alt="">';
                                     }
                                    ?>
								</div>
							</div>

                            
							<div class="form-group row">								
								<label class="col-sm-12 col-md-2 col-form-label">Workshop</label>
								<div class="col-sm-12 col-md-10">
									<?php $sel_photographar = set_value('workshop_id', $row->workshop_id);?>
									<select class="form-control" name="workshop_id">
										<option value="">Select Workshop</option>
										<?php
										if(is_array($workshop_list) && count($workshop_list)>0){
											foreach($workshop_list as $pk=>$pv){
												$psel = ($pv->id == $sel_photographar)?'selected':'';
												echo '<option value="'.$pv->id.'" '.$psel.'>'.$pv->name.'</option>';
											}
										}
										?>
									</select>
									
									<small class="text-danger"><?php echo isset($validation['workshop_id']) ? $validation['workshop_id'] : null;  ?></small>
								</div>
							</div>
                           
                            

                           <div class="modal-footer">
                            <input type="submit" value="Save" class="btn btn-primary" />
                            <a href="<?php echo site_url('admin/workshopgallery');?>" class="btn btn-warning">Cancel</a>
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