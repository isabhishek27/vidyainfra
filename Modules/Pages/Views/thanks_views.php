

    <!-- BANNER -->

    <section class="mybanner mybannerinside" style=" background-color:#2a2a2a; background-image: linear-gradient(rgba(0,0,0,.2), rgba(0,0,0,.5)), url(<?php echo assets_url('images/bannerBg12.jpg');?>); background-attachment: fixed; background-size: cover; background-position:0;">

        <div class="container">

            <div class="bannerContentInside">

                <div class="leftBar">

                    <h1>Thank You</h1>

                    <ul class="breadcrumb">

                        <li><a href="<?php echo base_url();?>">Home</a></li>

                        <li>Thank You</li>

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

                            <?php
                            if (session()->getFlashdata('success') !== NULL){
                                ?>
                                <h4>Thank You, <small><?php echo session()->getFlashdata('success');?></small></h4>
                                <?php
                            }else{
                                echo '<h4>Thank You, <small>We have successfully received your enquiry and we will get back to you soon.</small></h4>';
                            }
                            ?>

						</div>

					</div>

				</div>

			</div>

		</div>

		<!-- middle end-->

		<?php echo view('Modules\Pages\Views\get_in_touch_view');?>