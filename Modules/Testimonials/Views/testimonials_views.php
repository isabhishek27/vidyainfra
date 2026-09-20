    <!--SLIDER-->
    <section class="sliderCon sliderConInside">
        <div class="cols right">
            <div class="inner">
                <h1>Testimonials</h1>
                <ul class="breadcrumb">
                    <li><a href="<?php echo base_url();?>">Home</a></li>
                    <li>Testimonials</li>
                </ul>
            </div>
        </div>
    </section>
    <!--SLIDER-->

    <!-- form -->
    <div class="">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8 mt-5 mb50">
            <div class="testimonialsCon testimonialsConInside">
            
              <?php
              if(is_array($records) && count($records) > 0 ){
                foreach($records as $k=>$v){
                  ?>
                  <div class="box">
                    <figure><?php echo $v->name;?><!--<br><small>Klocko Fort, Canada</small> --></figure>
                    <figcaption>
                      <p><?php echo $v->testimonial;?> <img src="<?php echo assets_image_url('images/quote2.svg');?>" alt=""></p>
                    </figcaption>
                  </div>
                  <?php
                }
              }
              ?>
            </div>
          </div>
          
          <div class="col-md-4 mt-5 mb50">

            <?php echo form_open('',['csrf_id'=>'my-id','id'=>'testimonials']);?>

            <div class="stickySidebar">
              <h4 class="text-uppercase">Post Testimonial</h4>
              <div class="row form mt0">
                <div class="col-md-12">
                  <div class="form-group">                    
                    <input type="text" id="t_name" name="t_name" class="form-control" placeholder="Name*">
                    <span id="t_name_error" class="v_error"></span>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="text" id="email" name="email" class="form-control" placeholder="Email*">
                    <span id="email_error" class="v_error"></span>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">                    
                    <textarea name="testimonial" id="testimonial" class="form-control" rows="3" placeholder="Write Review*"></textarea>
                  <span id="testimonial_error" class="v_error"></span>
                  </div>
                </div>
              
                <div class="col-md-12 mt30">                  
                  <button type="button" class="btn btn1 btn-info tSubmit">Submit</button>
                </div>
              </div>
            </div>
            <?php echo form_close();?>
          
          </div>
          <div class="clearfix"></div>

        </div>
      </div>
    </div>
    <!-- form end-->