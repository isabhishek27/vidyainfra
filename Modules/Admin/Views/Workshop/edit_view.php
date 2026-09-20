<!DOCTYPE html>
<html>

<head>
	<?php echo view('Modules\Admin\Views\inc\top_head'); ?>

	<script src="<?php echo assets_image_url('admin/tinymce/js/tinymce/tinymce.min.js');?>" referrerpolicy="origin" crossorigin="anonymous"></script>

	<script src="<?php echo assets_image_url('admin/tinymce/load_tinymce.js');?>"></script>
	<script src="<?php echo assets_image_url('admin/tinymce/load_tinymce2.js');?>"></script>
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
                                        <a href="<?php echo site_url('admin/workshop');?>">Photographar</a>
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
						
						<?php echo form_open_multipart('admin/workshop/edit/'.$row->id);?>
                            <input type="hidden" name="id" value="<?php echo $row->id;?>">

							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Workshop Title</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Workshop Title" name="name" value="<?php echo set_value('name',$row->name);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['name']) ? $validation['name'] : null;  ?></small>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Photo</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="file" name="photo"/>   
                                    <small class="text-danger"><?php echo isset($validation['photo']) ? $validation['photo'] : null;  ?></small>

                                     <?php
                                     $img_dir_path = FCPATH . 'uploads/workshop/'.$row->photo;
                                     if(is_file($img_dir_path)){
                                        $img_url_path = site_url('public/uploads/workshop/'.$row->photo);
                                        echo '<img src="'.$img_url_path.'" width="250" height="250" alt="">';
                                     }
                                    ?>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Banner</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="file" name="banner"/>   
                                    <small class="text-danger"><?php echo isset($validation['banner']) ? $validation['banner'] : null;  ?></small>
									 <p class="text-danger">Recommended size: 1920 x 800 px</p>
                                     <?php
                                     $img_dir_path = FCPATH . 'uploads/workshop/'.$row->banner;
                                     if(is_file($img_dir_path)){
                                        $img_url_path = site_url('public/uploads/workshop/'.$row->banner);
                                        echo '<img src="'.$img_url_path.'" width="250" height="250" alt="">';
                                     }
                                    ?>
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Total Students Allowed</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Total Students Allowed" name="total_seat" value="<?php echo set_value('total_seat',$row->total_seat);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['total_seat']) ? $validation['total_seat'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Full Payment</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Full Payment" name="full_payment" value="<?php echo set_value('full_payment',$row->full_payment);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['full_payment']) ? $validation['full_payment'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Discounted Full Payment</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Discounted Full Payment" name="full_payment_discounted" value="<?php echo set_value('full_payment_discounted', $row->full_payment_discounted);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['full_payment_discounted']) ? $validation['full_payment_discounted'] : null;  ?></small>
								</div>
							</div>                          

                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Down Payment</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Downpayment" name="down_payment" value="<?php echo set_value('down_payment', $row->down_payment);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['down_payment']) ? $validation['down_payment'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Workshop Location</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Workshop Location" name="workshop_location" value="<?php echo set_value('workshop_location', $row->workshop_location);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['workshop_location']) ? $validation['workshop_location'] : null;  ?></small>
								</div>
							</div>
							<?php /*		 
							<div class="form-group row">								
								<label class="col-sm-12 col-md-2 col-form-label">Photographar</label>
								<div class="col-sm-12 col-md-10">
									<?php $sel_photographar = set_value('photographar_id', $row->photographar_id);?>
									<select class="form-control" name="photographar_id">
										<option value="">Select Photographar</option>
										<?php
										if(is_array($photographars) && count($photographars)>0){
											foreach($photographars as $pk=>$pv){
												$psel = ($pv->id == $sel_photographar)?'selected':'';
												echo '<option value="'.$pv->id.'" '.$psel.'>'.$pv->name.'</option>';
											}
										}
										?>
									</select>
									
									<small class="text-danger"><?php echo isset($validation['photographar_id']) ? $validation['photographar_id'] : null;  ?></small>
								</div>
							</div>

							*/ ?>

							<div class="form-group row">								
								<label class="col-sm-12 col-md-2 col-form-label">Photographers</label>
								<div class="col-sm-12 col-md-10">
									<?php 									

									 $sel_photographar = set_value('photographar_id', explode(',', $row->photographar_id));
        							$sel_photographar = is_array($sel_photographar) ? $sel_photographar : [];
									?>
									<select class="selectpicker form-control" name="photographar_id[]" multiple data-live-search="true">
										<option value="">Select Photographar</option>
										<?php
										if(is_array($photographars) && count($photographars)>0){
											foreach($photographars as $pk=>$pv){
												
												$psel = in_array($pv->id, $sel_photographar) ? 'selected' : '';
												echo '<option value="'.$pv->id.'" '.$psel.'>'.$pv->name.'</option>';
											}
										}
										?>
									</select>
									
									<small class="text-danger"><?php echo isset($validation['photographar_id']) ? $validation['photographar_id'] : null;  ?></small>
								</div>
							</div>


                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Workshop Start Date</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control date-picker2" type="text" placeholder="Workshop Start date" name="workshop_date" value="<?php echo set_value('workshop_date', $row->workshop_date);?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['workshop_date']) ? $validation['workshop_date'] : null;  ?></small>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Workshop End Date</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control date-picker2" type="text" placeholder="Workshop End Date" name="workshop_end_date" value="<?php echo set_value('workshop_end_date',$row->workshop_end_date);?>"/>
									<small class="text-danger"><?php echo isset($validation['workshop_end_date']) ? $validation['workshop_end_date'] : null;  ?></small>
								</div>
							</div>                            

                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">About Workshop</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control" id="cmscontainer" rows="10" placeholder="About Workshop" name="workshop_desc"><?php echo set_value('workshop_desc', $row->workshop_desc);?></textarea>
                                    <small class="text-danger"><?php echo isset($validation['workshop_desc']) ? $validation['workshop_desc'] : null;  ?></small>
								</div>
							</div>

							 <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Itinerary</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control" id="itinerary" rows="10" placeholder="About Workshop" name="workshop_itinerary"><?php echo set_value('workshop_itinerary', $row->workshop_itinerary);?></textarea>
                                    <small class="text-danger"><?php echo isset($validation['workshop_itinerary']) ? $validation['workshop_itinerary'] : null;  ?></small>
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
                            <a href="<?php echo site_url('admin/workshop');?>" class="btn btn-warning">Cancel</a>
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
<script>
  $('.selectpicker').selectpicker();
</script>
</html>