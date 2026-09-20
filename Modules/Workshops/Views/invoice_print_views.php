<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Welcome</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
</head>
<body style="font-size:12px; color:#000; margin:0px; padding:0; font-family:Arial, Helvetica, sans-serif; background: #f2f2f2;">
  <div style="max-width: 1024px; margin: auto; background: #fff; padding: 20px;">
    <table width="100%" border="0" align="center" cellpadding="4" cellspacing="1">
      <tbody>
        <tr>
          <td align="left">
            <p style="padding-top:2px; margin:0px; color:#000; line-height:18px;">
							<strong style="color:#000000; font-size:20px; text-transform:uppercase;">Internation Photo Workshops</strong><br>
							<span style=" padding-top:3px;">
								Email Us: <a href="mailto:<?php echo $company_email;?>" style="color:#000; font-weight:bold;"><?php echo $company_email;?></a>
							</span> Phone: <strong><?php echo $company_phone;?></strong>
						</p>
            <br>
          </td>
          <td align="right" valign="middle" style="padding-right:10px;"><img src="<?php echo assets_url('images/logo.SVG');?>" alt="" width="100" height="auto">
				</td>
			</tr>
		</tbody>
    </table>
    <br>
    <div style="width:44%; border:1px solid #ddd; padding:15px; min-height:140px; float:left;">
      <div style="font:600 16px/20px Arial, Helvetica, sans-serif; color:#000; border-bottom:1px solid #ccc; margin-bottom:10px; padding-bottom: 5px;"> Workshop Details</div>
			<div style="margin-top:5px; font:normal 12px/20px Arial, Helvetica, sans-serif">Invoice No.: <b><?php echo $order_dtl->order_no;?></b>(Dated: <?php echo getDateFormat($order_dtl->created_at,1);?>)</div>
			<div style="margin-top:10px; font:normal 12px/20px Arial, Helvetica, sans-serif">Location: <strong><?php echo $order_product_info->workshop_location;?></strong><br> 

        Date: <strong><?php echo getDateFormat($order_product_info->workshop_date,1);?></strong><br>

        Total Amount: <strong><?php echo $order_price;?></strong>

      </div>

    </div>

    <div style="width:44%; border:1px solid #ddd; padding:15px; min-height:140px; float:right;">

      <div

        style="font:bold 16px/20px Arial, Helvetica, sans-serif; color:#000; border-bottom:1px solid #ccc; margin-bottom:10px; padding-bottom: 5px;">

        Billing Info</div>

      <div style="margin-top:5px; font:normal 12px/20px Arial, Helvetica, sans-serif"><b><?php echo $order_dtl->bill_name;?> </b><br>

        Contact No.: <strong><?php echo $order_dtl->bill_phone;?></strong> <br>

        Email: <strong><?php echo $order_dtl->bill_email;?></strong><br>

      Address: <strong><?php echo $order_dtl->bill_address;?>, <?php echo $order_dtl->bill_city;?>, <?php echo $order_dtl->bill_state;?>, <?php echo $country_info->country_name;?></strong>

      

      </div>

       

    </div>

    <div style="clear:both"></div>

  



    <div style="margin-top: 10px; text-align: center; width: 100%; padding-top: 10px;"><a href="#" onclick="window.print()"

        style="color:#777; text-decoration:none;  font:bold 13px/22px Arial, Helvetica, sans-serif; text-transform:uppercase;">Print

        Invoice</a></div>

    



    <div style="clear:both;"></div>



  </div>







</body>



</html>