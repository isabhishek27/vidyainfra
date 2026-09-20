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
                                        <a href="<?php echo site_url('admin/reviews');?>">Reviews</a>
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
						
						<?php echo form_open_multipart('admin/reviews/add');?>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Name</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Name" name="name" value="<?php echo set_value('name');?>"/>                                   
                                    <small class="text-danger"><?php echo isset($validation['name']) ? $validation['name'] : null;  ?></small>
								</div>
							</div>
                            
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Email</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Email" name="email" value="<?php echo set_value('email');?>"/>
                                    <small class="text-danger"><?php echo isset($validation['email']) ? $validation['email'] : null;  ?></small>
								</div>
							</div>

                             <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Rating</label>
								<div class="col-sm-12 col-md-10">
									<select class="form-control" name="testimonial_rating">
                                       <option value="">Select Star Rating</option>
                                       <?php
                                       for($i=1;$i<=5;$i++){
                                        $selected = ($testimonial_rating == $i)?'selected':'';
                                        echo '<option value="'.$i.'" '.$selected.'>Star Rating - '.$i.'</option>';
                                       }
                                       ?> 

                                    </select>
                                    <small class="text-danger"><?php echo isset($validation['testimonial_rating']) ? $validation['testimonial_rating'] : null;  ?></small>
								</div>
							</div>

                           

                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Testimonial</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control" name="testimonial" style="height: 100px;"><?php echo set_value('testimonial');?></textarea>
                                    <small class="text-danger"><?php echo isset($validation['testimonial']) ? $validation['testimonial'] : null;  ?></small>
								</div>
							</div>

                           <div class="modal-footer">
                            <input type="submit" value="Save" class="btn btn-primary" />
                            <a href="<?php echo site_url('admin/reviews');?>" class="btn btn-warning">Cancel</a>
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