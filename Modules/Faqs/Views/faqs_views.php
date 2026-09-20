
    <!--SLIDER-->
    <section class="sliderCon sliderConInside">



        <div class="cols right">

            <div class="inner">

                <h1>Faq's</h1>

                <ul class="breadcrumb">                    
                    <li><a href="<?php echo base_url();?>">Home</a></li>
                    <li>Faq's</li>
                </ul>




            </div>



        </div>



    </section>
    <!--SLIDER-->





    <!-- form -->
    <div class="container">
        <div class="faqCon cms_area">



            <div class="faq-content" id="accordion">
                <?php
              if(is_array($records) && count($records) > 0 ){
                $cnt=0;
                foreach($records as $k=>$v){
                  $cnt++;
                  ?>
                <div class="card">
                    <div class="card-header"> <a class="card-link collapsed" data-toggle="collapse" href="#collapse<?php echo $cnt;?>" aria-expanded="false"><i class="more-less icon-plus"></i> <?php echo $v->question;?> </a>
                    </div>
                    <div id="collapse<?php echo $cnt;?>" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <p><?php echo $v->answer;?></p>
                           
                        </div>
                    </div>
                </div>
                <?php
                }
              }
                ?>
                
            </div>
        </div>
    </div>
    <!-- form end-->