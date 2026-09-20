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
                                        <a href="<?php echo site_url('admin/coupon');?>">Coupons</a>
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
						
						<?php echo form_open_multipart('admin/coupon/edit/'.$row->id);?>
						<input type="hidden" name="id" value="<?php echo $row->id;?>">

							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Coupon Name</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Name" name="coupon_title" value="<?php echo set_value('coupon_title',$row->coupon_title);?>"/>
									<small class="text-danger"><?php echo isset($validation['coupon_title']) ? $validation['coupon_title'] : null;  ?></small>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Coupon Code</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Coupon Code" name="coupon_code" value="<?php echo set_value('coupon_code',$row->coupon_code);?>"/>
									<small class="text-danger"><?php echo isset($validation['coupon_code']) ? $validation['coupon_code'] : null;  ?></small>
								</div>
							</div>

							<div class="form-group row">								
								<label class="col-sm-12 col-md-2 col-form-label">Coupon Type</label>
								<div class="col-sm-12 col-md-10">
									<?php $sel_coupon_type = set_value('coupon_type',$row->coupon_type);?>
									<select class="form-control" name="coupon_type">
										<option value="">Coupon Type</option>
										<option value="1" <?php echo ($sel_coupon_type==1)?'selected':'';?>>Percent(%)</option>
										<option value="2" <?php echo ($sel_coupon_type==2)?'selected':'';?>>Flat Discount</option>
									</select>
									
									<small class="text-danger"><?php echo isset($validation['coupon_type']) ? $validation['coupon_type'] : null;  ?></small>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Coupon Discount</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="text" placeholder="Coupon Discount" name="coupon_discount" value="<?php echo set_value('coupon_discount',$row->coupon_discount);?>"/>
									<small class="text-danger"><?php echo isset($validation['coupon_discount']) ? $validation['coupon_discount'] : null;  ?></small>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Start Date</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control date-picker2" type="text" placeholder="Start date" name="start_date" value="<?php echo set_value('start_date',$row->start_date);?>"/>
									<small class="text-danger"><?php echo isset($validation['start_date']) ? $validation['start_date'] : null;  ?></small>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">End Date</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control date-picker2" type="text" placeholder="End date" name="end_date" value="<?php echo set_value('end_date',$row->end_date);?>"/>
									<small class="text-danger"><?php echo isset($validation['end_date']) ? $validation['end_date'] : null;  ?></small>
								</div>
							</div>          

                           

							<div class="modal-footer">
								<input type="submit" value="Save" class="btn btn-primary" />
								<a href="<?php echo site_url('admin/coupon');?>" class="btn btn-warning">Cancel</a>
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