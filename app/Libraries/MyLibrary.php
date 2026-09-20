<?php
namespace App\Libraries;
class MyLibrary
{    

    public function siteinfo(){
        $db = \Config\Database::connect();

        // Prefer site_settings when available
        try {
            if ($db->tableExists('site_settings')) {
                $rows = $db->table('site_settings')->get()->getResult();
                if ($rows) {
                    $map = [];
                    foreach ($rows as $row) {
                        $map[$row->setting_key] = $row->setting_value;
                    }
                    return (object) [
                        'user_email' => $map['email'] ?? '',
                        'user_email2' => '',
                        'user_email3' => '',
                        'comp_name' => $map['company_name'] ?? ($map['website_name'] ?? 'Vidya Infra Construction'),
                        'phone1' => $map['phone'] ?? '',
                        'phone2' => '',
                        'address' => $map['address'] ?? '',
                        'twitter_link' => '',
                        'fb_link' => $map['facebook_url'] ?? '',
                        'linkedin_link' => $map['linkedin_url'] ?? '',
                        'gplus_link' => '',
                        'instagram_link' => $map['instagram_url'] ?? '',
                        'whatsapp' => $map['whatsapp'] ?? '',
                        'logo' => $map['logo'] ?? '',
                        'footer_description' => $map['footer_description'] ?? '',
                        'copyright_text' => $map['copyright_text'] ?? '',
                    ];
                }
            }
        } catch (\Throwable $e) {
            // fall through
        }

        $builder = $db->table('tbl_users')->select('user_email,user_email2,user_email3,comp_name,phone1,phone2,address,twitter_link,fb_link,linkedin_link,gplus_link,instagram_link')->where('id',1);
        $result   = $builder->get()->getRow();
        return $result;
    }

    public function getRecords($args){
        $db = \Config\Database::connect();        
        $result = [];
        
        $tbl_name = ($args['tbl_name']!=NULL)?$args['tbl_name']:'';
        $select_fld = ($args['select_fld']!=NULL)?$args['select_fld']:'*';
        $where = ($args['where']!=NULL)?$args['where']:'';
		

        if(!empty($tbl_name) && !empty($select_fld) && !empty($where)){

            $builder = $db->table($tbl_name)->select($select_fld)->where($where);
            $result   = $builder->get()->getResult(); 
        }
        return $result;
    }


    public function getPriceWithCurr($price){
        return '$'.number_format($price);
    }

	public function paypalForm($order_res){
		
		$site_info = $this->siteinfo();

		define('PAYPAL_SANDBOX',false);	
		$amount    = $order_res['order_price'];
		$orderid   = $order_res['order_id'];	
		$order_no  = $order_res['order_no'];

		
		
		if (PAYPAL_SANDBOX){
			$paypalWeb = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; // TEST SANDBOX
			$bemail = 'sb-znbvx40680312@business.example.com';
		}else{
			$paypalWeb = 'https://www.paypal.com/cgi-bin/webscr';
			$bemail = 'info@internationalphotoworkshops.com'; 
		}
		
		//$paypalWeb = site_url('workshops/payment/success/'.md5($orderid)); //uncomment to skip to go on gatway
		
		?>
		<body style="margin:0px;">    
		<div style="text-align:left; font-size: 22px; font-weight:bold;  background-color:#f9f9f9; border:#efefef; padding:20px;">
			<?php echo $site_info->comp_name;?>
		</div>
			<table style="width: 100%;">
				<tr>
					<td width="100%" align="center">
						<div style="font-family: Arial; font-size: 16px; text-align: center; margin-top: 170px; background-color:#f9f9f9; border:#efefef; padding:20px; font-weight:bold; width:500px;"> 
						<?php echo "We are just transfering you to the Paypal in few seconds"; ?><br />  <br />
						<div style="width: 200px; margin-left:180px; text-align: left;  font-family: Arial; font-size: 22px; color:#090;">
							Please wait <span id="loading_please_wait"></span>
						</div> 
						</div> 
					

					</td>
			</tr>
			<tr>     
					<td width="100%" align="center">
					</td>
				</tr>
			</table>
			<?php echo form_open($paypalWeb,'name="form1"');?>
			<!--<form name="form1" action="<?php echo $paypalWeb;?>" method="post"> -->
			<input type="hidden" name="cmd" value="_xclick"> 
			<input type="hidden" name="cbt" value="Return To <?php echo $site_info->comp_name;?>"> 
			<input type="hidden" name="business" value="<?php echo $bemail;?>"> 
			<input type="hidden" name="item_name" value="Pay to purchase  in <?php echo $site_info->comp_name;?>"> 
			<input type="hidden" name="item_number" value="<?php echo $order_no; ?>"> 
			
			<input type="hidden" name="amount" value="<?php echo $amount; ?>">
			
			<input type="hidden" name="return" value="<?php echo base_url(); ?>workshops/payment/success/<?php echo md5($orderid);?>"> 
			<input type="hidden" name="cancel_return" value="<?php echo base_url(); ?>workshops/payment/cancle/<?php echo md5($orderid);?>"/>
			<input type="hidden" name="no_note" value="1"> 		
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="rm" value="2"> 
			</form> 	       
			<script type="text/javascript">
			
			form1.submit();
			
			i=-1;
			intvalid=setInterval(function(){append_dot('loading_please_wait',i++);},100);
			
			function append_dot(span_id,i)
			{
				span=document.getElementById(span_id);
				dots="";
				for(j=0;j<=i;j++)
				{
					dots+=".";
				}
				span.innerHTML=dots;
				num_dots=(span.innerHTML).length;
				if(parseInt(num_dots)>=8)
				{
					clearInterval(intvalid);
					i=-1;
					intvalid=setInterval(function(){append_dot('loading_please_wait',i++);},100);
				}
			}
			</script>
		<?php 
		
		die();
	}
		
	}
?>