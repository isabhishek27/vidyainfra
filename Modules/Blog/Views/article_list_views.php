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
				<h1 class="title">Blog</h1>
				<ul class="breadcrumb">
					<li><a href="<?php echo base_url();?>">Home</a></li>
					<li>Blog</li>
				</ul>
			</div>
		</div>
	</div>
</section>
<!-- BANNER ENDS -->
 
<!-- middle -->
<div class="container-fluid">
	<div class="middleCon pt30">
		<div class="blogCon newsInside">
			<div class="row">
				<?php
				if(is_array($records) && count($records) > 0 ){
					$cnt=0;
					foreach($records as $k=>$v){
						$cnt++;
						$img_path = uploaded_image_url('blog/'.$v->b_image);
						$b_title = (strlen($v->b_title)>70)?substr($v->b_title,0,70).'...':$v->b_title;
						$b_link = site_url('blog/article/'.$v->b_slug);
						$b_desc = strip_tags($v->b_content);
						$b_desc = (strlen($b_desc)>140)?substr($b_desc,0,140).'...':$b_desc;
						?>
						
						<div class="col-sm-6 col-md-3" style="cursor:pointer;" onclick="window.location.href='<?php echo $b_link;?>';">							
							<div class="card mt30">
								<figure class="cardIcon"><a href="<?php echo $b_link;?>"><img src="<?php echo $img_path;?>" alt=""></a></figure>
								<figcaption class="cardItems">
									<p class="time"><?php echo getDateFormat($v->created_at,1);?></p>
									<h5><a href="<?php echo $b_link;?>"><?php echo $b_title?></a></h5>
									<p><?php echo $b_desc;?></p>									
								</figcaption>
								<p style="text-align:center; padding-bottom:10px;"><a href="<?php echo $b_link;?>">Read</a></p>
							</div>
						</div>
						
						<?php
					}
				}
				?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<!-- middle end-->
<?php echo view('Modules\Pages\Views\get_in_touch_view');?>