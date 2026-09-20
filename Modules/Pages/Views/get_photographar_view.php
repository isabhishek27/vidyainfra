<?php  

use App\Libraries\MyLibrary;

$mylib = new MyLibrary();

$params = ['tbl_name'=>'tbl_photographar','select_fld'=>'*','where'=>['status'=>1]];

$records = $mylib->getRecords($params);

if(is_array($records) && count($records)>0){

	?>



	<div class="teamsCon" id="photographer-bio">

		<div class="container-fluid">

			<div class="inner">

				<div class="text-center">

					<h2 class="commanTitle">Photographers</h2>

				</div>

				<div class="clearfix mt30"></div>





				<?php

				$cnt=0;

				foreach($records as $k=>$v){

					

					$div_cls = ($cnt%2 == 0)?'rows trans_eff':'rows rows-reverse trans_eff';

					$img_path = uploaded_image_url('photographar/'.$v->photo);

					?>

<div class="<?php echo $div_cls;?>" id="photographer-<?php echo strtolower(str_replace(' ', '-', $v->name)); ?>">

					<div class="cols left">

						<figure><img src="<?php echo $img_path;?>" alt=""></figure>

					</div>

					<div class="cols right">

						<h3><?php echo $v->name;?> <small> <?php echo $v->region;?>, <?php echo $v->country;?></small></h3>

						<P><?php echo $v->about;?></P>

						<div class="social">
							<?php
							if(!empty($v->insta_link)){
								?>
								<a href="<?php echo $v->insta_link;?>"><span class="icon-instagram"></span></a>
								<?php
							}		
							if(!empty($v->fb_link)){
								?>
								<a href="<?php echo $v->fb_link;?>"><span class="icon-facebook"></span></a>
								<?php

							}
							if(!empty($v->x_link)){
								?>
								<a href="<?php echo $v->x_link;?>"><span class="icon-twitter-x"></span></a>
								<?php

							}							

							if(!empty($v->linkedin_link)){

								?>

								<a href="<?php echo $v->linkedin_link;?>"><span class="icon-linkedin"></span></a>

								<?php

							}

							?>

							

						</div>

					</div>

				</div>

					<?php

					$cnt++;

				}

				?>				



			</div>

		</div>

	</div>

	<?php

}

?>