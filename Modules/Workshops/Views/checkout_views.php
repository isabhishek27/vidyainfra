    <!-- BANNER -->
	<?php
	$banner_img_path = assets_url('images/bannerBg12.jpg');
	if(is_object($banners)){
		$banner_img = $banners->banner_image;
		
		$img_dir_path = FCPATH . 'uploads/banners/'.$banner_img;
		if(is_file($img_dir_path)){
			$banner_img_path = site_url('public/uploads/banners/'.$banner_img);
		}
	}
	?>
    <section class="mybanner mybannerinside" style=" background-color:#2a2a2a; background-image: linear-gradient(rgba(0,0,0,.2), rgba(0,0,0,.5)), url(<?php echo $banner_img_path;?>); background-attachment: fixed; background-size: cover; background-position:0;">

			<div class="container">

				<div class="bannerContentInside">

					<div class="leftBar">

						<h1>Billing Info</h1>

						<ul class="breadcrumb">

							<li><a href="<?php echo base_url();?>">Home</a></li>

							<li>Billing Info</li>

						</ul>

					</div>

				</div>

			</div>

		</section>

    <!-- BANNER ENDS -->



    <!-- middle -->

    <div class="container-fluid">

        <div class="middleCon mb30">

            <div class="cmsArea">

							

							<div class="row">

								

								<div class="col-md-7">

									<div class="form mt20 ">

										

										<?php echo form_open('');?>



											<div class="form-group">

												<label for="name">Name <span class="red">*</span></label>

												<input type="text" class="form-control" name="name" value="<?php echo set_value('name');?>">

												<small class="text-danger"><?php echo isset($validation['name']) ? $validation['name'] : null;  ?></small>

											</div>

											

											<div class="form-group">

												<label for="email">Email address<span class="red">*</span></label>

												<input type="text" class="form-control" name="email" value="<?php echo set_value('email');?>">

												<small class="text-danger"><?php echo isset($validation['email']) ? $validation['email'] : null;  ?></small>

											</div>

											

											<div class="form-group">

												<label for="phone">Phone<span class="red">*</span></label>

												<input type="text" class="form-control" name="phone" value="<?php echo set_value('phone');?>">

												<small class="text-danger"><?php echo isset($validation['phone']) ? $validation['phone'] : null;  ?></small>

											</div>

											

											<div class="form-group">

												<label for="address">Address<span class="red">*</span></label>

												<input type="text" class="form-control" name="address" value="<?php echo set_value('phone');?>">

												<small class="text-danger"><?php echo isset($validation['address']) ? $validation['address'] : null;  ?></small>

											</div>



											<?php

											$country_post_val = set_value('country');

											?>

											<div class="form-group">

												<label for="country">Country<span class="red">*</span></label>

												<select name="country" id="country" class="form-control">

													<option value="">--Select--</option>

													<?php

													foreach($country_list as $ck=>$cv){

														$country_sel = ($cv->id == $country_post_val)?'selected':'';

														echo '<option value="'.$cv->id.'" '.$country_sel.'>'.$cv->country_name.'</option>';

													}

													?>

												</select>

												<small class="text-danger"><?php echo isset($validation['country']) ? $validation['country'] : null;  ?></small>

											</div>

											

											<div class="form-group">

												<label for="state">State<span class="red">*</span></label>

												<input type="text" class="form-control" name="state" value="<?php echo set_value('state');?>">

												<small class="text-danger"><?php echo isset($validation['state']) ? $validation['state'] : null;  ?></small>

											</div>

											

											<div class="form-group">

												<label for="city">City<span class="red">*</span></label>

												<input type="text" class="form-control" name="city" value="<?php echo set_value('city');?>">

												<small class="text-danger"><?php echo isset($validation['city']) ? $validation['city'] : null;  ?></small>

											</div>

											

											<div class="form-group">

												<label for="zipcode">Zipcode<span class="red">*</span></label>

												<input type="text" class="form-control" name="zip_code" value="<?php echo set_value('zip_code');?>">

												<small class="text-danger"><?php echo isset($validation['zip_code']) ? $validation['zip_code'] : null;  ?></small>

											</div>

											

											<div class="form-group">

												<textarea name="comments" class="form-control" style="height: 150px;" placeholder="Message/Comment"><?php echo set_value('comments');?></textarea>

												<small class="text-danger"><?php echo isset($validation['comments']) ? $validation['comments'] : null;  ?></small>

											</div>



											<div class="form-group">

												<button type="submit" class="btn btn-large btn-info">Continue</button>

											</div>

										

										<?php echo form_close();?>

									

									</div>

								

								</div>

								

								<div class="col-md-5">

									<div class="contactInfo contactInfoInside">

										

										<h4>Workshop Details</h4>

										<div class="contactInfo">

											<p class="mt20">Name: <?php echo $workshop_info->name;?></p>

											<p>Location: <?php echo $workshop_info->workshop_location;?></p>

											<p>Date: <?php echo getDateFormat($workshop_info->workshop_date,1);?></p>



											<p><strong><?php echo $price;?></strong> (Per person)</p>

										</div>

									</div>

								</div>

								

								<div class="clearfix"></div>

							

							</div>

						

						</div>

					

					</div>

				

				</div>

				

				<!-- middle end-->