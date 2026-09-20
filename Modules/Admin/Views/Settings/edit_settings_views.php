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
                                        <a href="<?php echo site_url('admin/dashboard');?>">Dashboard</a>
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

                         <?php
                        if (session()->getFlashdata('success') !== NULL){
                        ?>   
                        <div class="alert alert-success" role="alert"><?php echo session()->getFlashdata('success');?></div>
                        <?php } ?>

                        <?php
                        if (session()->getFlashdata('error') !== NULL){
                        ?>   
                        <div class="alert alert-danger" role="alert"><?php echo session()->getFlashdata('error');?></div>
                        <?php } ?>
						
						<?php echo form_open('admin/settings');?>
                            <input type="hidden" name="id" value="<?php echo $row->id;?>">

                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Company Name</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control" type="text" placeholder="Company name" name="comp_name" value="<?php echo set_value('comp_name',$row->comp_name);?>"/>
                                    <small class="text-danger"><?php echo isset($validation['comp_name']) ? $validation['comp_name'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Email Address</label>
								<div class="col-sm-12 col-md-10">									
                                    <input class="form-control" type="text" placeholder="Email Address" name="user_email" value="<?php echo set_value('user_email',$row->user_email);?>"/>
                                    <small class="text-danger"><?php echo isset($validation['user_email']) ? $validation['user_email'] : null;  ?></small>
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Email Address2</label>
								<div class="col-sm-12 col-md-10">									
                                    <input class="form-control" type="text" placeholder="Email Address" name="user_email2" value="<?php echo set_value('user_email2',$row->user_email2);?>"/>
                                    <small class="text-danger"><?php echo isset($validation['user_email2']) ? $validation['user_email2'] : null;  ?></small>
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Email Address3</label>
								<div class="col-sm-12 col-md-10">									
                                    <input class="form-control" type="text" placeholder="Email Address" name="user_email3" value="<?php echo set_value('user_email3',$row->user_email3);?>"/>
                                    <small class="text-danger"><?php echo isset($validation['user_email3']) ? $validation['user_email3'] : null;  ?></small>
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Phone 1</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Phone 1" name="phone1" value="<?php echo set_value('phone1',$row->phone1);?>"/>
                                    <small class="text-danger"><?php echo isset($validation['phone1']) ? $validation['phone1'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Phone 2</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Phone 2" name="phone2" value="<?php echo set_value('phone2',$row->phone2);?>"/>
                                    <small class="text-danger"><?php echo isset($validation['phone2']) ? $validation['phone2'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Address</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control" name="address" placeholder="Address" style="height: 100px;"><?php echo set_value('address',$row->address);?></textarea>
                                    <small class="text-danger"><?php echo isset($validation['address']) ? $validation['address'] : null;  ?></small>
								</div>
							</div>
                            
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">X Url</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="X Url" name="twitter_link" value="<?php echo set_value('twitter_link',$row->twitter_link);?>"/>
                                    <small class="text-danger"><?php echo isset($validation['twitter_link']) ? $validation['twitter_link'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Facebook Url</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Facebook Url" name="fb_link" value="<?php echo set_value('fb_link',$row->fb_link);?>"/>
                                    <small class="text-danger"><?php echo isset($validation['fb_link']) ? $validation['fb_link'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">LinkedIn Url</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="LinkedIn Url" name="linkedin_link" value="<?php echo set_value('linkedin_link',$row->linkedin_link);?>"/>
                                    <small class="text-danger"><?php echo isset($validation['linkedin_link']) ? $validation['linkedin_link'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Google+ Url</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Google+ Url" name="gplus_link" value="<?php echo set_value('gplus_link',$row->gplus_link);?>"/>
                                    <small class="text-danger"><?php echo isset($validation['gplus_link']) ? $validation['gplus_link'] : null;  ?></small>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Instagram Url</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Instagram Url" name="instagram_link" value="<?php echo set_value('instagram_link',$row->instagram_link);?>"/>
                                    <small class="text-danger"><?php echo isset($validation['instagram_link']) ? $validation['instagram_link'] : null;  ?></small>
								</div>
							</div>                           
                            

                           <div class="modal-footer">
                            <input type="submit" value="Save" class="btn btn-primary" />                           
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