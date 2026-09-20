 <!-- testimonials-->
  <?php if(is_array($testimonials) && count($testimonials) > 0){ ?>
  <div class="testimonialsCon">


    <h2 class="text-uppercase text-center">Testimonials</h2>


    <div class="listOuter mt-4">
      <ul class="list owl-carousel owl-theme" id="loop">
        <?php
        foreach($testimonials as $k=>$v){
          ?>
          <li class="item">
            <div class="box">
              <figure><?php echo $v->name;?><br></figure>
              <figcaption>
                <p><?php echo $v->testimonial;?> <img src="<?php echo assets_image_url('images/quote2.svg');?>" alt=""></p>
              </figcaption>
            </div>
          </li>
          <?php
        }
        ?>
      </ul>
    </div>

    <div class="text-center mt-4">
      <a href="<?php echo site_url('testimonials');?>" class="btn btn-primary btn1">View All Testimonial</a>
    </div>

  </div>
  <?php } ?>
  <!-- testimonials end-->