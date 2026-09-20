<?php
use App\Libraries\MyLibrary;
$mylib = new MyLibrary();
$siteinfo = $mylib->siteinfo();

$curr_date = date('Y-m-d');        
$cond = "`workshop_end_date` >='".$curr_date."' AND `status` = 1 ";

$args = ['tbl_name'=>'tbl_workshop','select_fld'=>'id,name','where'=>$cond];
$workshop_info = $mylib->getRecords($args);

$cond1 = "`page_id` = 10 ";
$args1 = ['tbl_name'=>'tbl_pages','select_fld'=>'page_content','where'=>$cond1];
$page_info = $mylib->getRecords($args1);

?>
<!-- photography adventure end-->

  <!-- get in touch -->
  <div class="getInToucht">
    <div class="container">
      <div class="text-center">
        <!-- <h2 class="commanTitle">Book your photo adventure</h2>
        <p class="mt20 secondaryTxt"></p> -->
        <?php echo $page_info[0]->page_content;?>
      </div>

      <?php echo form_open('',['csrf_id'=>'my-id','id'=>'contactus']);?>
        <div class="form">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" class="form-control" id="ffirst_name" name="ffirst_name" placeholder="First name*">
                <span id="ffirst_name_error" class="v_error"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" class="form-control" id="flast_name" name="flast_name" placeholder="Last name*">
                <span id="flast_name_error" class="v_error"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="email" class="form-control" id="femail" name="femail" placeholder="Email address*">
                <span id="femail_error" class="v_error"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" class="form-control" id="fmobile_number" name="fmobile_number" placeholder="Phone*">
                <span id="fmobile_number_error" class="v_error"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <select name="fworkshop" id="fworkshop" class="form-control" style="background:#2A2A2A;">
                  <option value="">Workshops*</option>
                  <?php
                  if(is_array($workshop_info) && count($workshop_info)>0){
                    foreach($workshop_info as $k=>$v){
                      echo '<option value="'.$v->name.'">'.$v->name.'</option>';
                    }
                  }
                  ?>                  
                </select>
                <span id="fworkshop_error" class="v_error"></span>
              </div>
            </div>
            
            
            <div class="col-md-6">
              <div class="form-group">
                <textarea class="form-control" id="ftravel_location" rows="3" name="ftravel_location" placeholder="Comments*"></textarea>
                <span id="ftravel_location_error" class="v_error"></span>
              </div>
            </div>
            <div class="col-md-12 mt20 text-center">
              <div class="form-group">
                <button type="button" class="btn btn-info btn-large rqSubmit">Book Now</button>
              </div>
            </div>
          </div>
        </div>
      <?php echo form_close();?>
    </div>
  </div>
  <!-- get in touch end-->
