
        <!-- banner info -->
        <div class="bannerInfo">

            <h1 class="title">Blogs</h1>
            <ul class="breadcrumb">
                <li><a href="<?php echo base_url();?>">Home</a></li>
                 <li>Blogs</li>
            </ul>
        </div>
        <!-- banner info end-->


        <!-- contact button -->
        <?php echo view('Modules\Pages\Views\contact_button_view');?>
        <!-- contact button -->

    </div>

    <!-- banner end -->


    <!-- middle -->

    <div class="middleCon">
        <div class="container-fluid">
            <div class="blogCon newsInside">

                <div class="row">

                  <?php
                  if(is_array($records) && count($records) > 0 ){
                    $cnt=0;
                    foreach($records as $k=>$v){
                        
                      $img_path = uploaded_image_url('blog/'.$v->b_image);
                      $cnt++;
                      $b_title = (strlen($v->b_title)>70)?substr($v->b_title,0,70).'...':$v->b_title;
                      $b_link = site_url('blog/'.$v->b_slug);
                      ?>
                      <div class="col-sm-6 col-md-4">
                          <div class="card mt30">
                              <figure class="cardIcon"><a href="<?php echo $b_link;?>"><img src="<?php echo $img_path;?>" alt="<?php echo $v->b_title;?>"></a>
                              </figure>
                              <figcaption class="cardItems">
                                  <h5><a href="<?php echo $b_link;?>"><?php echo $b_title;?></a></h5>
                              </figcaption>
                          </div>
                      </div>
                    <?php
                    }
                  }else{
                    echo '<div class="col-sm-12 text-center">Record(s) not found!!</div>';
                  }
                  ?>  
                    

                    <div class="clearfix"></div>
                </div>


            </div>
        </div>
    </div>

    <!-- middle end-->

    <?php echo view('Modules\Pages\Views\website_stats_view');?>

    </div>

    <!-- faqs -->
    <?php echo view('Modules\Pages\Views\faq_view');?>
    <!-- faqs end-->

    <!-- lets talk -->
    <?php echo view('Modules\Pages\Views\lets_talk_view');?>
    <!-- lets talk end-->
