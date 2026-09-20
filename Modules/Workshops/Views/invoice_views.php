    <!-- BANNER -->
    <section class="mybanner mybannerinside" style=" background-color:#2a2a2a; background-image: linear-gradient(rgba(0,0,0,.2), rgba(0,0,0,.5)), url(<?php echo assets_url('images/bannerBg12.jpg');?>); background-attachment: fixed; background-size: cover; background-position:0;">
			<div class="container">
				<div class="bannerContentInside">
					<div class="leftBar">
						<h1>Invoice</h1>
						<ul class="breadcrumb">
							<li><a href="<?php echo base_url();?>">Home</a></li>
							<li>Invoice</li>
						</ul>
					</div>
				</div>
			</div>
		</section>
    <!-- BANNER ENDS -->

    <!-- middle -->

    <div class="container-fluid">
			<div class="middleCon mb30">
				<div class="middleInner">
					<div class="box">
						<div class="thanksBox">
							<img src="<?php echo assets_url('images/yes.png');?>" alt="">
							<h4>Thank You, Alex! <small>You've successfuly booked our workshop. A confirmation email and invoice have been sent to your email id <b class="yellow">(<?php echo $order_dtl->bill_email;?>)</b></small></h4>
						</div>
						
						<!---->\
						<div class="mt30 mb50">
							<div>
								<div class="invoice_logo"> <img src="<?php echo assets_url('images/logo.svg');?>" width="120" alt=""> </div>
								<div>
									<h5 class="mb0 fs24 text-uppercase">Internation Photo Workshops </h5>
									<p>
										<span>Email Us: <b><a href="mailto:<?php echo $company_email;?>"><?php echo $company_email;?></a></b></span> 
										Phone: <b><a href="tel:<?php echo $company_phone;?>"> <?php echo $company_phone;?></a></b>
									</p>
								</div>
								
								<div class="clearfix"></div>
								<div class="row">
									<div class="col-lg-6 col-md-6 mt15">
										<div class="invoiceBox">
											<div class="bb fs16 pb10 mb10 text-uppercase">Workshop Details</div>
											<div class="mt5 fs14">Invoice No.: <b><?php echo $order_dtl->order_no;?></b> (Dated: <?php echo getDateFormat($order_dtl->created_at,1);?>)</div>
											<div class="mt10 fs14">
												Location: <b><?php echo $order_product_info->workshop_location;?></b><br>
												Date: <b><?php echo getDateFormat($order_product_info->workshop_date,1);?></b><br>
												Total Amount: <b><?php echo $order_price;?></b>
											</div>
										</div>
									</div>
									
									<div class="col-lg-6 col-md-6 mt15">
										<div class="invoiceBox">
											<div class="bb fs16 pb10 mb10 text-uppercase">Billing Info</div>
											<div class="mt5 fs14">
												<b><?php echo $order_dtl->bill_name;?></b><br>
												Contact No.: <b><?php echo $order_dtl->bill_phone;?></b><br>
												Email: <b><?php echo $order_dtl->bill_email;?></b>
												<br>
												Address: <b><?php echo $order_dtl->bill_address;?>, <?php echo $order_dtl->bill_city;?>, <?php echo $order_dtl->bill_state;?>, <?php echo $country_info->country_name;?></b>
											</div>
										</div>
									</div>
									
									<div class="clearfix"></div>
									<div class="clearfix"></div>
								</div>
								<div class=" btnCon mt30">
									<div class="text-center">
										<a href="<?php echo site_url('workshops/payment/printinv/'.md5($order_dtl->id));?>" class="btn-large btn btn-info" target="_blank">Print Invoice</a>
									</div>
									
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
						<!---->
					</div>
				</div>
			
			</div>
		
		</div>
		
		<!-- middle end-->