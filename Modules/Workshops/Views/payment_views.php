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

						<h1>Payment</h1>

						<ul class="breadcrumb">

								<li><a href="<?php echo base_url();?>">Home</a></li>

								<li>Payment</li>

						</ul>

					</div>

				</div>

			</div>

    </section>

    <!-- BANNER ENDS -->



	<?php

	$coupon_id = (int)session()->get('coupon_id');

	$coupon_value = session()->get('coupon_value');

	$coupon_discount = session()->get('coupon_discount');

	$coupon_discount_type = session()->get('coupon_discount_type');

	$coupon_code = session()->get('coupon_code');

	

	$coupon_applied_msg = '';

	if( $coupon_id > 0 && $coupon_discount>0){

		$coupon_applied_msg = 'Coupon('.$coupon_code.') Applied!!.';

		$order_price = $order_price - $coupon_discount;

		$price =  $mylib->getPriceWithCurr($order_price);

	}

	

	?>



    <!-- middle -->



    <div class="container-fluid">

			<div class="middleCon mb30">

				<div class="cmsArea">

					<div class="row">

						

						<div class="col-md-7">

							<h2 class="comman-title text-uppercase">Make Payment</h1>

							<p class="fs18">Total Payable Cost: <strong class="black weight700 net_payable"><?php echo $price;?></strong></p>



							<?php echo form_open('');?>

							<div class="bg-gray1 mt15">

								<div class="otherServiceAddonList paymentCon">

									<ul>

										<li>

											<div class="cols">

												<label>

													<input class="selectStyleCheckBox" id="tab1" name="payment_method" value="paypal" type="radio" required="" checked="">

													<div class="box">

														<h5><img src="<?php echo assets_url('images/pp.jpg');?>" alt=""></h5>

													</div>

												</label>

											</div>

										</li>

										<div class="clearfix"></div>

									</ul>

									

									<!-- paypal -->

									<?php /* 

									<div class="cardDetails on">

										<h4>Paypal</h4>

										<div class="row">

											<div class="col-md-12">

												<div class="form-group">

													<label for="f_name">Card number <span class="red">*</span></label>

													<input name="card_number" type="text" placeholder="Card Number" class="form-control" id="card_number" value="">

												</div>

											</div>

											

											<div class="col-md-4">

												<div class="form-group">

													<label for="f_name">Expiry Month <span class="red">*</span></label>

													<input name="expiry_month" type="text" class="form-control" placeholder="MM" id="expiry_month" maxlength="2" value="">

												</div>

											</div>

											

											<div class="col-md-4">

												<div class="form-group">

													<label for="f_name">Expiry Year <span class="red">*</span></label>

													<input name="expiry_year" maxlength="4" type="text" class="form-control" placeholder="YYYY" id="expiry_year" value="">

												</div>

											</div>

											

											<div class="col-md-4">

												<div class="form-group">

													<label for="f_name">CVV <span class="red">*</span></label>

													<input name="cvv" type="text" class="form-control" placeholder="CVV" id="cvv" maxlength="3" value="">

												</div>

											</div>

											

											<div class="col-md-12">

												<div class="form-group">

													<label for="f_name">Name On Card <span class="red">*</span></label>

													<input name="name_on_card" type="text" class="form-control" placeholder="Name On Card" id="name_on_card" maxlength="50" value="">

												</div>

											</div>



										</div>

									</div> */ ?>

								

								</div>

								

								<div class="clearfix"></div>

								<!-- links ends -->

								 

								<div class="form-check mt30 checkbox">

									<label class="form-check-label">

										<input type="checkbox" class="form-check-input" name="terms" id="terms"> I Agree with 

										<a href="<?php echo site_url('terms-and-conditions');?>" class="" target="_blank">Terms &amp; Condition!</a> </label>

										<div>

											<small class="text-danger"><?php echo isset($validation['terms']) ? $validation['terms'] : null;  ?></small>

										</div>

								</div>

								

								<p class="text-center mt20 mb30">

									<input type="submit" value="Complete My Booking" class="btn btn-large btn-info">

								</p>

								

								<div class="clearfix"></div>

							

							</div>

							<?php echo form_close(); ?>

						

						</div>

						

						<div class="col-md-5">

							

							<div class="contactInfo contactInfoInside">

								<h4>Workshop Details</h4>

								<div class="contactInfo">

									<p class="mt20">Name: <?php echo $workshop_info->name;?></p>

									<p>Location: <?php echo $workshop_info->workshop_location;?></p>

									<p>Date: <?php echo getDateFormat($workshop_info->workshop_date,1);?></p>



									<p><strong class="net_payable"><?php echo $price;?></strong> (Per person)</p>

								</div>

							

							</div>

							<?php echo form_open('',['csrf_id'=>'my-id','id'=>'coupon']);?>

							<div class="row mt30">

								

								<div class="col-md-9">

									<input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="Enter Coupon Code">

									<span id="coupon_code_error" class="v_error"></span>

									<span id="coupon_code_success" class="text-success" style="color:green;"><?php echo $coupon_applied_msg;?></span>

									

								</div>

								<input type="hidden" id="token" name="token" value="<?php echo $_GET['token'];?>">

								<div class="col-md-3">

									<button type="button" class="btn btn-info btn-block couponSubmit">Apply</button>

								</div>

							</div>

							<?php echo form_close();?>

						

						</div>

						<div class="clearfix"></div>



					</div>

				</div>

			</div>

		</div>

		<!-- middle end-->