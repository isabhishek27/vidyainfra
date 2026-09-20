<section class="page-hero">
  <div class="container">
    <span class="eyebrow">Showroom</span>
    <h1>Our Inventory</h1>
    <div class="crumbs"><a href="<?php echo site_url('/');?>">Home</a> &nbsp;/&nbsp; Inventory</div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="search-bar">
      <input type="text" id="invSearch" placeholder="Search by make or model (e.g. Land Rover)" />
      <select id="invStatus">
        <option value="all">All Status</option>
        <option value="available">Available</option>
        <option value="sold">Sold</option>
      </select>
    </div>
    <div class="inventory-grid" id="inventoryGrid">
      <?php
      if (!empty($products) && is_array($products)) {
          foreach ($products as $v) {
              echo view('Modules\Products\Views\vehicle_card', ['v' => $v]);
          }
      } else {
          echo '<p style="text-align:center;grid-column:1/-1">No vehicles found.</p>';
      }
      ?>
    </div>
  </div>
</section>

<section class="section section-dark" id="enquiry">
  <div class="container">
    <div class="section-head">
      <span class="eyebrow">Enquire</span>
      <h2>Interested? Let's Talk.</h2>
      <div class="divider"></div>
      <p>Send us a message and our team will reply within one business day.</p>
    </div>
    <div style="max-width:760px;margin:0 auto">
      <div class="form-card">
        <div class="form-success" id="enquirySuccess">Thank you — your enquiry has been received. We'll be in touch shortly.</div>
        <form id="inventoryEnquiryForm" method="post" action="javascript:void(0);">
          <div class="form-row">
            <div class="form-group"><label>Name</label><input type="text" name="first_name" required /></div>
            <div class="form-group"><label>Phone</label><input type="tel" name="mobile_number" required /></div>
          </div>
          <div class="form-row">
            <div class="form-group"><label>Email</label><input type="email" name="email" required /></div>
            <div class="form-group"><label>Vehicle Interested In</label><input type="text" id="vehicleInterest" name="address" placeholder="e.g. 2016 Land Rover Discovery Sport" /></div>
          </div>
          <div class="form-group"><label>Message</label><textarea name="message" rows="5" required></textarea></div>
          <input type="hidden" name="last_name" value="" />
          <input type="hidden" name="enquiry_type" value="interest" />
          <button type="submit" class="btn btn-gold">Send Enquiry</button>
        </form>
      </div>
    </div>
  </div>
</section>
<script>
document.getElementById('inventoryEnquiryForm')?.addEventListener('submit', function(e){
  e.preventDefault();
  var form = this;
  var fd = new FormData(form);
  fetch('<?php echo site_url('post-contact-us');?>', {
    method: 'POST',
    headers: {'X-Requested-With': 'XMLHttpRequest'},
    body: fd
  }).then(r => r.json()).then(function(res){
    var ok = document.getElementById('enquirySuccess');
    if(ok){ ok.classList.add('show'); ok.scrollIntoView({behavior:'smooth',block:'center'}); }
    form.reset();
    setTimeout(function(){ ok && ok.classList.remove('show'); }, 6000);
  }).catch(function(){ alert('Unable to send enquiry. Please try again.'); });
});
</script>
