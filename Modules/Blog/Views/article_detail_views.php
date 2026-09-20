    <!-- BANNER -->
	 <?php
	$banner_img_path = assets_url('images/bannerBg13.jpg');
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
						<h1>Blog Details</h1>
						<ul class="breadcrumb">
							<li><a href="<?php echo base_url();?>">Home</a></li>
							<li><a href="<?php echo site_url('blog');?>">Blog</a></li>
							<li>Blog Details</li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<!-- BANNER ENDS -->
		
		<!-- middle -->
		<div class="container">
			<div class="middleCon">
				<div class="cmsArea">
					<p class="time"><?php echo getDateFormat($records->created_at,1);?></p>
					<h3 class="mt30"><?php echo $records->b_title;?></h3>
					<div class="text-justify"><?php echo $records->b_content;?></div>
					
					<a href="<?php echo site_url('blog');?>" class="btn btn-info mt50">Back to the listing</a>
				</div>
			</div>
		</div>
		<!-- middle end-->
		<?php echo view('Modules\Pages\Views\get_in_touch_view');?>