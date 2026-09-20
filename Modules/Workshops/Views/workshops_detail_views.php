		<style>
		.lg-backdrop {
			background-color: #2a2a2a;
		}
		.lg-toolbar .lg-icon {
			color: #fff;
		}
		.lg-toolbar .lg-icon:hover {
			color: #84EBFF;
		}
		.lg-next,
		.lg-prev {
			background-color: #84EBFf;
			color: #2a2a2a;
		}
		.justified-gallery>a>.jg-caption,
		.justified-gallery>div>.jg-caption,
		.justified-gallery>figure>.jg-caption {
		padding: 10px;
		}
		</style>

    <!-- BANNER -->

	<?php
	$banner_img_path = assets_url('images/bannerBg5.jpg');
	//echo '<pre>';print_r($records);die;
	if(!empty($records->banner)){
		$banner_img = $records->banner;
		
		$img_dir_path = FCPATH . 'uploads/workshop/'.$banner_img;
		if(is_file($img_dir_path)){
			$banner_img_path = site_url('public/uploads/workshop/'.$banner_img);
		}
	}
	?>

    <section class="mybanner mybannerinside" style=" background-color:#2a2a2a; background-image: linear-gradient(rgba(0,0,0,.2), rgba(0,0,0,.5)), url(<?php echo $banner_img_path;?>); background-attachment: fixed; background-size: cover; background-position:0;">
			<div class="container">
				<div class="bannerContentInside">
					<div class="leftBar">
						<h1><?php echo $records->name;?></h1>
						<ul class="breadcrumb">
							<li><a href="<?php echo base_url();?>">Home</a></li>
							<li><a href="<?php echo site_url('workshops');?>">Workshops</a></li>
							<li><?php echo $records->name?></li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<!-- BANNER ENDS -->

    <!-- middle -->
    <div class="container-fluid">
			<div class="middleCon">

				<div class="workshopDetails">
					<?php
					$price = ($records->full_payment_discounted>0)?$records->full_payment_discounted:$records->full_payment; 
					$aval_seat = (int)($records->total_seat - $records->total_booked_seat);
					$aval_seat = ($aval_seat<1)?0:$aval_seat;
					//$photographar_photo = uploaded_image_url('photographar/'.$records->photographar_photo);
					?>
					<p class="text-center workshopInfo">
						<span><?php echo getDateFormat($records->workshop_date,1);?> <?php echo (!empty($records->workshop_end_date))?'- '.getDateFormat($records->workshop_end_date,1):'';?></span><span><?php echo $records->workshop_location;?></span>
						
						<span><strong><?php echo $records->total_seat;?></strong> Total Spots</span>
						<span>
							<strong>
								<?php
								if($records->full_payment_discounted>0){
									echo  '<strike>'.$mylib->getPriceWithCurr($records->full_payment).'</strike> ';
								}
								echo  $mylib->getPriceWithCurr($price);
								?>
							</strong> (Per person)
						</span>
						
						<?php if($aval_seat==0){?><span class="solOut">Sold Out</span><?php } ?> <span class="solOut left"><?php echo $aval_seat;?> Spots Left</span>
					</p>
					
					<div class="section1">
						<div class="cols left">
							<?php /*
							<div class="stickySidebar">
								<div class="inner ">
									<div class="cols1 bioPic"><img src="<?php echo $photographar_photo;?>" alt=""></div>
									<div class="cols1 bioName">
										<h4> <span style="color:#84ebff;">ABOUT</span> <br><?php echo $records->photographar_name;?></h4>
									</div>
									
								</div>
								
								<div class="text-center">
								   <?php
									$photographer_id = strtolower(str_replace(' ', '-', $records->photographar_name));
									?>
									<a href="<?php echo site_url('about-us#photographer-' . $photographer_id); ?>" class="btn btn-info btn-small mt30">Go to Bio</a>

								    
									<a href="<?php echo site_url('workshops');?>" class="btn btn-info btn-small mt30">Back to Listing</a>
								</div>
							</div>
							*/ ?>
							<div class="stickySidebar">
								<?php if (!empty($records->photographers)) : ?>
                				<?php foreach ($records->photographers as $ph) {
									$photographar_photo = uploaded_image_url('photographar/'.$ph->photographar_photo);	
									?>
									<div class="inner ">
										<div class="cols1 bioPic"><img src="<?php echo $photographar_photo;?>" alt=""></div>
										<div class="cols1 bioName">
											<h4> <span style="color:#84ebff;">ABOUT</span> <br><?php echo $ph->name;?></h4>
										</div>
									</div>
									<div class="text-center" style="padding-bottom:20px;">
										<?php $photographer_id = strtolower(str_replace(' ', '-', $ph->name)); ?>
										<a href="<?php echo site_url('about-us#photographer-' . $photographer_id); ?>" 
										class="btn btn-info btn-small mt30">
											Go to <?php echo $ph->name; ?>'s Bio
										</a>
									</div>
									<?php 
								} ?>
            					<?php endif; ?>

								<div class="text-center">
								

								<a href="<?php echo site_url('workshops');?>" class="btn btn-info btn-small mt30">Back to Listing</a>
							</div>
							</div>
						</div>
						<div class="cols right">
							<div class="inner2">
								
								<div class="imageSlider">
									<?php //if(is_array($gal_data) && count($gal_data)>0){?>
									<div id="myCarousel" class="carousel slide" data-ride="carousel">

										<!-- Wrapper for slides -->
										 <div class="carousel-inner">
											<?php $ws_img_path = uploaded_image_url('workshop/'.$records->photo);;?>
										 	<div class="item active">
												<img src="<?php echo $ws_img_path;?>" alt="<?php echo $records->name;?>>
												<!--div class="bck-aa" style="background-image: url('<?php echo $ws_img_path;?>');"></div-->
									
											</div>

										 	<?php
											if(is_array($gal_data) && count($gal_data)>0){
												$cnt=1;
												foreach($gal_data as $gk=>$gv){
													$gal_img_path = uploaded_image_url('workshopgallery/'.$gv->photo);
													?>
													<div class="item">
														<img src="<?php echo $gal_img_path;?>" alt="<?php echo $gv->name;?>>
														<!--div class="bck-aa" style="background-image: url('<?php  echo $gal_img_path;?>');"></div-->
													</div>
													<?php
													$cnt++;
												}
											}
											?>

										</div>
										<?php if(is_array($gal_data) && count($gal_data)>0){ ?>
										<!-- Left and right controls -->
										<a class="left carousel-control" href="#myCarousel" data-slide="prev">
											<span class="glyphicon-chevron-right icon-angleLeft"></span>
										</a>
										
										<a class="right carousel-control" href="#myCarousel" data-slide="next">
											<span class="glyphicon-chevron-right icon-angleRight"></span>
										</a>
										<?php } ?>
									</div>
									<?php
									//}
									?>

									<?php echo form_open('workshops/detailpost');?>
									<div class="price text-center">
										<label class="form-check-label">
											<input type="radio" class="form-check-input" name="payment_type" value="1" >Full Payment 
											<strong>
												<?php
												if($records->full_payment_discounted>0){
													echo  '<strike>'.$mylib->getPriceWithCurr($records->full_payment).'</strike> ';
												}
												echo  $mylib->getPriceWithCurr($price);
												?>
											</strong>
										</label>
										<label class="form-check-label">
											<input type="radio" class="form-check-input" name="payment_type" value="2" checked>Down Payment <strong>   (<?php echo  $mylib->getPriceWithCurr($records->down_payment);?>) </strong> 
										</label>
									</div>
									
									<div class="text-center mt40">
										<?php
										if($aval_seat>0){
										?>
										<button type="submit" class="btn btn-info btn-large">Book Now</button>
										<?php
										}else{
											?>
										<button type="button" class="btn btn-info btn-large" onclick="alert('Sorry!! Spots not available.');">Sold Out</button>

										<a href="javascript:;" class="btn btn-info btn-large" data-toggle="modal" data-target="#notifyMe">Join waiting list</a>
										<?php
										}
										?>
										
											
										
										
									</div>
									<input type="hidden" name="workshop" value="<?php echo $records->id;?>">
									<?php echo form_close();?>
								</div>
								
								<div class="cmsArea">
									<h2>Workshop Details</h2><br>
									<p><?php echo $records->workshop_desc;?></p>
									<?php /*
									<div class="imageGallery">
										<h2>Image Gallery</h2>
										<div class="inner">
											<div class="gallery-container" id="animated-thumbnails-gallery">

												<a data-lg-size="1164-1140" class="gallery-item" data-src="<?php echo assets_url('images/cuba/1.jpg');?>">
													<img alt="" class="img-responsive" src="<?php echo assets_url('images/cuba/1.jpg');?>" />
												</a>

												<a data-lg-size="1150-1140" class="gallery-item" data-src="<?php echo assets_url('images/cuba/2.jpg');?>">
													<img alt="" class="img-responsive" src="<?php echo assets_url('images/cuba/2.jpg');?>" />
												</a>
											
											</div>
										
										</div>

									</div> */?>

								</div>
								<?php
								if(!empty($records->workshop_itinerary)){
								?>
								<div class="cmsArea">
									<h2>Workshop Itinerary</h2><br>
									<p><?php echo $records->workshop_itinerary;?></p>
								</div>
								<?php } ?>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- middle end-->
		<?php echo view('Modules\Pages\Views\get_in_touch_view');?>
		
		
		
  <!-- Notify Me -->
  <div class="modal fade modalStyle001" id="notifyMe" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
         
        <div class="modal-body">
             <button type="button" class="close" data-dismiss="modal">&times;</button>
             
             <h3>Notify Me</h3>
             <br>
          <div class="form ">

                            <?php echo form_open('workshops/post-notifyme',['csrf_id'=>'my-id','id'=>'notifyme']);?>

                                <div class="form-group">

                                    <input type="text" class="form-control" id="nname" name="nname" placeholder="Name*">
									<span id="nname_error" class="v_error"></span>
                                </div>
								<input type="hidden" name="workshopid" id="workshopid" value="<?php echo $records->id;?>">	
								<input type="hidden" name="workshop_name" id="workshop_name" value="<?php echo $records->name;?>">	

                                <div class="form-group">

                                    <input type="text" class="form-control" id="nemail" name="nemail" placeholder="Email*">
									<span id="nemail_error" class="v_error"></span>
                                </div>



                                <div class="form-group">

                                    <input type="text" class="form-control" id="nphone" name="nphone" placeholder="Phone number*">
									<span id="nphone_error" class="v_error"></span>
                                </div>

									

                                <div class="form-group">
                               <button type="button" class="btn btn-bordered" data-dismiss="modal">Cancel</button>     <button type="button" class="btn btn-info ml10 notifySubmit">Submit</button>
                                </div>
	

                            <?php echo form_close();?>

                        </div>
        </div>
    
        
        
      </div>
    </div>
  </div>
		
		
		
		
		