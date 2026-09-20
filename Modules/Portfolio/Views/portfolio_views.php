<!-- banner info -->
<div class="bannerInfo">

    <h1 class="title">Portfolio</h1>
    <ul class="breadcrumb">
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li>Portfolio</li>
    </ul>

</div>
<!-- banner info end-->

<?php echo view('Modules\Pages\Views\contact_button_view');?>

</div>

<!-- banner end -->



<!-- middle -->

<div class="middleCon">
        <div class="container-fluid">


            <div class="row">

                <?php
                 if(is_array($records) && count($records) > 0 ){
                    $cnt=0;
                    foreach($records as $k=>$v){
                        $tags=[];
                        if(!empty($v->tags)){
                            $tags=explode(',',$v->tags);
                        }
                        $img_path = uploaded_image_url('portfolio/'.$v->portfolio_image);
                        $cnt++;
                        ?>
                        <div class="col-sm-6">
                            <!-- 001-->
                            <div> <a href="javascript:;" class="prtfolioCard" data-toggle="modal" data-target="#portfolioModal<?php echo $cnt;?>">
                                    <figcaption>
                                        <h3><?php echo $v->title;?></h3>
                                        <p class="from"><strong>From:</strong> <?php echo $v->country_name;?></p>
                                        <?php
                                        if(count($tags)){
                                            ?>
                                            <div class="tools">
                                                <?php
                                                foreach($tags as $tk=>$tv){
                                                    ?>
                                                    <span><?php echo $tv;?></span> 
                                                    <?php 
                                                } 
                                                ?> 
                                            </div>
                                            <?php
                                        }
                                        ?>    

                                        <p class="dscpn"><?php echo $v->description;?> </p>
                                        <div class="portfolio_thum"> <span><img src="<?php echo $img_path;?>" alt="<?php echo $v->title;?>" /></span>
                                        </div>
                                    </figcaption>
                                </a> 
                            </div>                              
                        </div>
                         <!-- Modal -->
                        <div id="portfolioModal<?php echo $cnt;?>" class="modal fade modalStyle001" role="dialog">
                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"><?php echo $v->title;?></h4>
                                    </div>
                                    <div class="modal-body modal-body-padding01">
                                        <div class="portfolioPupImg"> <img src="<?php echo $img_path;?>" alt="<?php echo $v->title;?>" /> </div>
                                    </div>
                                    <div class="modal-footer"><a href="<?php echo site_url('request-a-quote');?>" type="button" class="btn btn1 btn-border"
                                            target="_parent">Get a free quote</a> </div>
                                </div>
                            </div>
                        </div>
                        <!--portfolio modal end-->
                        <?php
                    }
                }
                ?>

               

                


            </div>



        </div>
    </div>

    <!-- middle end-->

   

<?php echo view('Modules\Pages\Views\website_stats_view');?>

</div>

<?php echo view('Modules\Pages\Views\faq_view');?>


</div>
</div>
<!-- faqs end-->


<?php echo view('Modules\Pages\Views\lets_talk_view');?>

