	<!-- BANNER -->
	<?php
	$banner_img_path = assets_url('images/bannerBg2.jpg');
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
									<h1>Workshops</h1>
									<ul class="breadcrumb">
											<li><a href="<?php echo base_url();?>">Home</a></li>
											<li>Workshops</li>
									</ul>
							</div>
					</div>
			</div>
	</section>
	<!-- BANNER ENDS -->

	<!-- middle -->
	 <div class="projectCon">
		<div class="container-fluid">
			<div class="row">

				<?php 
				if(is_array($records) && count($records)>0){
					
					

					foreach($records as $k=>$v){
						$img_path = uploaded_image_url('workshop/'.$v->photo);
						$aval_seat = (int)($v->total_seat - $v->total_booked_seat);

						$desc = strip_tags($v->workshop_desc);
						if(strlen($desc)>100){
							$desc = substr($desc,0,100) . '...';
						}
						$price = ($v->full_payment_discounted>0)?$v->full_payment_discounted:$v->full_payment;
						$detail_link = site_url('photo-workshop/'.$v->url_slug);
						?>
						<div class="col-md-4  col-sm-6 cols">
							<div class="serviceCard">
								<div class="projectCard">
									<!--img src="<?php echo $img_path;?>" alt="" width="414" height="320"-->
									<div class="bck-a" style="background-image: url('<?php echo $img_path;?>');height:400px;background-position:top;background-size:cover;"></div>
									<h3 class="pTitle trans_eff"><?php echo $v->name;?></h3>
									
									<a href="<?php echo $detail_link;?>" class="overlay">
										<div class="items head">
											<p><?php echo $v->name;?></p>
											<hr>
										</div>
										
										<div class="bodyItem">
											<p><?php echo $desc;?></p>
											<p class="mt10"><?php echo getDateFormat($v->workshop_date,1);?> <?php echo (!empty($v->workshop_end_date))?'- '.getDateFormat($v->workshop_end_date,1):'';?></p>
											<p class="mt20">
												<strong>
											<p><strong><?php echo $v->total_seat;?></strong> Total Spots</p>
											<p><strong><?php echo $v->workshop_location;?></strong></p>
											
											 <?php
											 if($aval_seat>0){
												?>
												<p> <span class="solOut left"><?php echo $aval_seat;?> Spots Left</span></p>	
												<?php
											 }else{
												echo '<p> <span class="solOut">Sold Out</span></p>';
											 }
											 ?>
											 
										</div>
										<!-- <div class="items button">
											<span class="btn btn-info">View Workshop</span>
										</div> -->
									</a>
								</div>
							</div>
						</div>
						<?php
					}
				}else{
					echo '<div class="col-md-12  col-sm-12 cols"><b>No record(s) found.</div>';
				}
				?>

				
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!-- middle end-->

   <?php echo view('Modules\Pages\Views\get_in_touch_view');?>