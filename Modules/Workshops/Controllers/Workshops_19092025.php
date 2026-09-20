<?php
namespace Modules\Workshops\Controllers;

use App\Controllers\FrontendController;
use App\Libraries\MyLibrary;
  				
use Config\Services;

use Modules\Workshops\Models\WorkshopsModel;
use Modules\Pages\Models\PagesModel;

class Workshops extends FrontendController {

    protected $viewDirectory;
    protected $my_model;
	protected $pages_model;
    protected $helpers = ['form'];
    protected $mylib;
    

    public function __construct(){

        $this->my_model = new WorkshopsModel();
		$this->pages_model = new PagesModel();
        $this->mylib = new MyLibrary(); 

        // $uri = current_url(true);               
        // $module_name = ucfirst($uri->getSegment(1));
        // if(empty($module_name)){
        //     $module_name = 'Pages';
        // }
        $module_name = 'Workshops';

        $this->viewDirectory = 'Modules/'. $module_name.'/Views';
    }
    
    public function index() {
        
        $data['meta_title'] = 'Workshops';
        $data['meta_desc'] = '';
        $data['meta_keyword'] = '';

        
		$curr_date = date('Y-m-d');        
        $cond = " AND `workshop_end_date` >='".$curr_date."' ";

        $select_fld = '*';
        $records =  $this->my_model->getRecords($select_fld, $cond);
        //echo '<pre>';print_r($records);die;
        $data['records'] = $records;
        $data['include']        = $this->viewDirectory . '\workshops_views';
        
        $data['mylib'] = $this->mylib;

		$cond =" AND `banner_section` = 7 ";
        $banners = $this->pages_model->getBanners('banner_image',$cond);
        $data['banners'] = $banners;

		return view('container', $data);
        
    }

    public function details(){
        $uri = current_url(true);         
        $url_slug = $uri->getSegment(3);
       
        $records =  $this->my_model->getSingleRecord($url_slug);
        //echo '<pre>';print_r($records);
        $data['records'] = $records;
        //Gal
        $cond = " AND `status` = 1 AND `workshop_id` = '".$records->id."' ";
        $select_fld = 'photo,name';
        $gal_records =  $this->my_model->getGallery($select_fld, $cond);
        $data['gal_data'] = $gal_records;
        //Gal end

        $data['mylib'] = $this->mylib;

        $data['meta_title'] = 'Workshops';
        $data['meta_desc'] = '';
        $data['meta_keyword'] = '';

		$cond =" AND `banner_section` = 8 ";
        $banners = $this->pages_model->getBanners('banner_image',$cond);
        $data['banners'] = $banners;		

        $data['include']        = $this->viewDirectory . '\workshops_detail_views';
        return view('container', $data);

    }

		public function detailpost(){

			if ($this->request->is('post')) {

					$encrypter = \Config\Services::encrypter();

					$validation = service('validation');
					$request    = service('request');

						$rules = [               
							"payment_type" => [
									"label" => "payment type", 
									"rules" => "required"
							]
					];

					if ($this->validate($rules)) {      
						$payment_type= $this->request->getPost("payment_type");
						$workshop = $this->request->getPost("workshop");
						$session_id = session()->session_id;

						$plain_text = $payment_type .'~^'.$workshop.'~^'.$session_id;
						$token = bin2hex($encrypter->encrypt($plain_text));
						
						
						//$encrypted_url_safe = bin2hex($token);
						//$decrypted_text = $encrypter->decrypt(hex2bin($encrypted_url_safe));
						

						return redirect()->to(site_url('workshops/billing-info').'?token='.$token);
						die; 
					}

				}
		}

    public function checkout(){
			
			if($this->request->getVar('token')==NULL){
				return redirect()->to(site_url('workshops'));
			}else{
				$token = $this->request->getVar('token');
			}

			$encrypter = \Config\Services::encrypter();
			
			$decrypted_token = $encrypter->decrypt(hex2bin($token));
			$decrypted_token_arr = explode('~^',$decrypted_token);
			$payment_type = (int)$decrypted_token_arr[0];
			$workshop_id = (int) $decrypted_token_arr[1];

			$workshop_dtl =  $this->my_model->getRecordById($workshop_id);
			if(!is_object($workshop_dtl)){
				return redirect()->to(site_url('workshops'));
			}
			$data['workshop_info'] = $workshop_dtl;
			$data['payment_type'] = $payment_type;

			$price = $order_price = $workshop_dtl->down_payment;
			if($payment_type == 1){
				$price = $workshop_dtl->full_payment;
				if($workshop_dtl->full_payment_discounted>0){
					$price = $order_price = $workshop_dtl->full_payment_discounted;
				}
			}
			$price = $this->mylib->getPriceWithCurr($price);
			$data['price'] = $price;

			/** Post the form */
			if ($this->request->is('post')) {

				$validation = service('validation');
				$request    = service('request');

					$rules = [               
						"name" => [
								"label" => "name", 
								"rules" => "required"
						],
						"email" => [
								"label" => "email", 
								"rules" => "required|valid_email"
						],
						"phone" => [
								"label" => "phone", 
								"rules" => "required|regex_match[/^[0-9]{10}$/]"
						],
						"address" => [
								"label" => "address", 
								"rules" => "required"
						],
						"country" => [
								"label" => "country", 
								"rules" => "required"
						],
						"state" => [
								"label" => "state", 
								"rules" => "required"
						],
						"city" => [
								"label" => "city", 
								"rules" => "required"
						],
						"zip_code" => [
								"label" => "zip code", 
								"rules" => "required"
						],
						"comments" => [
								"label" => "comments", 
								"rules" => "required"
						]

						
				];

				if ($this->validate($rules)) {      

					$curr_date = date('Y-m-d H:i:s');

					//$order_data = $this->my_model->getTokens($token);
					$order_id = (int)session()->get('order_id');
					if($order_id && $order_id>0){
						// update order

						$postdata = [											
											"pkg_payment_type" => $payment_type,
											"order_price" => $order_price,
											"bill_name" => $this->request->getPost("name"),
											"bill_email" => $this->request->getPost("email"),
											"bill_phone" => $this->request->getPost("phone"),
											"bill_address" => $this->request->getPost("address"),
											"bill_country" => $this->request->getPost("country"),
											"bill_state" => $this->request->getPost("state"),
											"bill_city" => $this->request->getPost("city"),
											"bill_zip_code" => $this->request->getPost("zip_code"),
											"comments" => $this->request->getPost("comments")
									];
						$this->my_model->updateRecord($postdata,'tbl_orders',$order_id);

						$postdata = [											
											"product_id" => $workshop_id,
											"product_price" => $order_price,
											"workshop_location" => $workshop_dtl->workshop_location,
											"workshop_date" => $workshop_dtl->workshop_date,
											"photographar_id " => $workshop_dtl->photographar_id
									];
						$order_dtl_id = $this->my_model->updateRecord($postdata,'tbl_orders_dtl',$order_id);	

					}else{
						// insert new order					
						$postdata = [
											"token_no"=>$token,
											"pkg_payment_type" => $payment_type,
											"order_price" => $order_price,
											"bill_name" => $this->request->getPost("name"),
											"bill_email" => $this->request->getPost("email"),
											"bill_phone" => $this->request->getPost("phone"),
											"bill_address" => $this->request->getPost("address"),
											"bill_country" => $this->request->getPost("country"),
											"bill_state" => $this->request->getPost("state"),
											"bill_city" => $this->request->getPost("city"),
											"bill_zip_code" => $this->request->getPost("zip_code"),
											"comments" => $this->request->getPost("comments"),
											"created_at"=> $curr_date
									];
						$order_id = $this->my_model->addRecord($postdata,'tbl_orders');			

						if($order_id>0){

							$order_sess_arr = array('order_id' => $order_id);
							session()->set($order_sess_arr);

							$postdata = [
											"order_id" => $order_id,
											"product_id" => $workshop_id,
											"product_price" => $order_price,
											"workshop_location" => $workshop_dtl->workshop_location,
											"workshop_date" => $workshop_dtl->workshop_date,
											"photographar_id " => $workshop_dtl->photographar_id
									];
							$order_dtl_id = $this->my_model->addRecord($postdata,'tbl_orders_dtl');			
						}
					}

					return redirect()->to(site_url('workshops/payment').'?token='.$token);
				}else{
					$data["validation"] = $validation->getErrors();
					//echo '<pre>'; print_r( $validation->getErrors());die;
				}

			}
			/** End posting the form */
			$country_list = $this->my_model->getCountries();
			$data['country_list'] = $country_list;
						

			$data['meta_title'] = 'Checkout';
			$data['meta_desc'] = '';
			$data['meta_keyword'] = '';

			$cond =" AND `banner_section` = 11 ";
            $banners = $this->pages_model->getBanners('banner_image',$cond);
            $data['banners'] = $banners;

			$data['include']        = $this->viewDirectory . '\checkout_views';
			return view('container', $data);
			
    }

		public function verifycoupon(){

			if ($this->request->isAJAX()) {

				/////////////////////////////////////////////
				$encrypter = \Config\Services::encrypter();

				$token = $this->request->getPost('token');
			
				$decrypted_token = $encrypter->decrypt(hex2bin($token));
				$decrypted_token_arr = explode('~^',$decrypted_token);
				$payment_type = (int)$decrypted_token_arr[0];
				$workshop_id = (int) $decrypted_token_arr[1];

				$workshop_dtl =  $this->my_model->getRecordById($workshop_id);
				
				$price = $order_price = $workshop_dtl->down_payment;
				if($payment_type == 1){
					$price = $workshop_dtl->full_payment;
					if($workshop_dtl->full_payment_discounted>0){
						$price = $order_price = $workshop_dtl->full_payment_discounted;
					}
				}
				//$price = $this->mylib->getPriceWithCurr($price);
				/////////////////////////////////////////////////
				$coupon_code = $this->request->getPost('coupon_code');
				$return_data=['status'=>0,'msg'=>'Errors! Invalid Coupon.'];

				$coupon_info = $this->my_model->getCouponInfo($coupon_code);
           
				if(is_object($coupon_info)){

					$coupon_type = $coupon_info->coupon_type;
					$coupon_discount = $coupon_info->coupon_discount;
					$coupon_code = $coupon_info->coupon_code;

					if($coupon_type==1){
						$cup_discount = (($order_price*$coupon_discount)/100);
						$order_price = $order_price - $cup_discount;
					}else{
						$cup_discount = $coupon_discount;
						$order_price = $order_price - $coupon_discount;
					}
					$price =  $this->mylib->getPriceWithCurr($order_price);

					$sess_arr = array(							
							'coupon_id' =>$coupon_info->id,
							'coupon_code'=>$coupon_code,
							'coupon_value'=>$coupon_discount,
							'coupon_discount'=>$cup_discount,
							'coupon_discount_type'=>$coupon_type
						);
						session()->set($sess_arr);

					$return_data=['status'=>1,'msg'=>'Coupon('.$coupon_code.') Applied!!.','price'=>$price];   
				}

				
				$return_data = json_encode($return_data);
				echo $return_data;

			}

		}

		public function payment(){			

			if($this->request->getVar('token')==NULL){
				return redirect()->to(site_url('workshops'));
			}else{
				$token = $this->request->getVar('token');
			}
			$order_id = (int)session()->get('order_id');
			if($order_id==0){
				return redirect()->to(site_url('workshops'));
			}

			$encrypter = \Config\Services::encrypter();
			
			$decrypted_token = $encrypter->decrypt(hex2bin($token));
			$decrypted_token_arr = explode('~^',$decrypted_token);
			$payment_type = (int)$decrypted_token_arr[0];
			$workshop_id = (int) $decrypted_token_arr[1];

			$workshop_dtl =  $this->my_model->getRecordById($workshop_id);
			if(!is_object($workshop_dtl)){
				return redirect()->to(site_url('workshops'));
			}
			$data['workshop_info'] = $workshop_dtl;
			$data['payment_type'] = $payment_type;

			$price = $order_price = $workshop_dtl->down_payment;
			if($payment_type == 1){
				$price = $workshop_dtl->full_payment;
				if($workshop_dtl->full_payment_discounted>0){
					$price = $order_price = $workshop_dtl->full_payment_discounted;
				}
			}
			$price = $this->mylib->getPriceWithCurr($price);
			$data['price'] = $price;
			$data['order_price'] = $order_price;	

			$data['meta_title'] = 'Checkout';
			$data['meta_desc'] = '';
			$data['meta_keyword'] = '';

			/** Post the form */
			if ($this->request->is('post')) {

				$validation = service('validation');
				$request    = service('request');

					$rules = [               
						"payment_method" => [
								"label" => "payment method", 
								"rules" => "required"
						],
						"terms" => [
								"label" => "terms and condition", 
								"rules" => "required"
						]						
				];

				if ($this->validate($rules)) {      

					$curr_date = date('Y-m-d H:i:s');

					//$order_data = $this->my_model->getTokens($token);
					$order_id = (int)session()->get('order_id');
					if($order_id && $order_id>0){
						// update order
						$coupon_id = 0;
						$coupon_value = 0;
						$coupon_discount = '0';
						$coupon_discount_type = ''; //1=Flat, 2=Percent

						if((int)session()->get('coupon_id') > 0){

							$coupon_id = (int)session()->get('coupon_id');
							$coupon_value = session()->get('coupon_value');
							$coupon_discount = session()->get('coupon_discount');
							$coupon_discount_type = session()->get('coupon_discount_type'); //1=Flat, 2=Percent

							$order_price = $order_price - $coupon_discount;
						}

						$postdata = [																						
											"order_no" => $order_id,
											"order_price" => $order_price,
											"coupon_id" => $coupon_id,
											"coupon_value" => $coupon_value,
											"coupon_discount" => $coupon_discount,
											"coupon_discount_type" => $coupon_discount_type,
											"payment_method" => $this->request->getPost("payment_method"),
											"order_status"=>1
									];
						$this->my_model->updateRecord($postdata,'tbl_orders',$order_id);						

					}
					$session_id = session()->session_id;
					$plain_text = $order_id.'~^'.$session_id;
					$token = bin2hex($encrypter->encrypt($plain_text));
					$ordmaster = '';

					
					$ordmaster = ['order_price'=>$order_price, 'order_id'=>$order_id, 'order_no'=>$order_id];

					//Unset all session
					if( session()->get('order_id') ){
						$sess_arr = array(
							'order_id' => 0,
							'coupon_id' =>0,
							'coupon_code' =>0,
							'coupon_value'=>0,
							'coupon_discount'=>0,
							'coupon_discount_type'=>0
						);
						session()->set($sess_arr);
						//session()->destroy();
					}
				
					$this->mylib->paypalForm($ordmaster);
					exit;

					//return redirect()->to(site_url('workshops/invoice').'?token='.$token);
				}else{
					$data["validation"] = $validation->getErrors();
					//echo '<pre>'; print_r( $validation->getErrors());die;
				}

			}

			$cond =" AND `banner_section` = 11 ";
            $banners = $this->pages_model->getBanners('banner_image',$cond);
            $data['banners'] = $banners;
			
			/** End posting the form */
			$data['mylib'] = $this->mylib;
			$data['include']        = $this->viewDirectory . '\payment_views';
			return view('container', $data);

		}

		public function success(){

			$post_data=$_REQUEST;
			$post_data = ['status'=>'success']; //will be comment later
			if(isset($post_data) && $post_data['status']=="success"){

				$uri = current_url(true);               
				$ordId = $uri->getSegment(4);

				$cond = ['md5(id)'=>$ordId];
				$order_dtl = $this->my_model->getOrderData("tbl_orders",$cond);
				if(!is_object($order_dtl)){
					return redirect()->to(site_url('workshops'));
				}else{
					$postdata = ["order_status"=>2];
					$this->my_model->updateRecord($postdata,'tbl_orders',$order_dtl->id);

					
					$this->my_model->reduceWorkshopSpots('tbl_workshop',$order_dtl->id);
					$this->my_model->updateCouponUsage('tbl_coupons',$order_dtl->id);
					


				}
				
			}

			$data['meta_title'] = 'Payment Success';
			$data['meta_desc'] = '';
			$data['meta_keyword'] = '';
			$data['order_dtl'] = $order_dtl;
			$order_price = $this->mylib->getPriceWithCurr($order_dtl->order_price);
			$data['order_price'] = $order_price;

			$data['country_info'] = $this->my_model->getOrderData("tbl_country",['id'=>$order_dtl->bill_country],'country_name');

			$data['company_email'] = $this->mylib->siteinfo()->user_email;
			$data['company_phone'] = $this->mylib->siteinfo()->phone1;

			$cond = ['md5(order_id)'=>$ordId];
			$order_product_info = $this->my_model->getOrderData("tbl_orders_dtl",$cond);
			$data['order_product_info'] = $order_product_info;

			$data['include']        = $this->viewDirectory . '\invoice_views';
			return view('container', $data);
		}

		public function cancle(){

			$post_data=$_REQUEST;
			//echo '<pre>';print_r($post_data);
			/*
			if(isset($post_data) && $post_data['status']=="success"){

				$ordId = $this->uri->segment(4);

				$cond = ['md5(id)'=>$ordId];
				$order_dtl = $this->my_model->getOrderData("tbl_orders",$cond);
				if(!is_object($order_dtl)){
					return redirect()->to(site_url('workshops'));
				}else{
					$postdata = [																																	
											"order_status"=>3
									];
						$this->my_model->updateRecord($postdata,'tbl_orders',$order_dtl->id);	
				}
				
			}*/

			$data['meta_title'] = 'Payment Cancle';
			$data['meta_desc'] = '';
			$data['meta_keyword'] = '';

			$data['include']        = $this->viewDirectory . '\payment_cancle_view';
			return view('container', $data);
		}

		public function printinvoice(){

			
			$post_data = ['status'=>'success']; 
			if(isset($post_data) && $post_data['status']=="success"){

				$uri = current_url(true);               
				$ordId = $uri->getSegment(4);

				$cond = ['md5(id)'=>$ordId];
				$order_dtl = $this->my_model->getOrderData("tbl_orders",$cond);

				if(!is_object($order_dtl)){
					return redirect()->to(site_url('workshops'));
				}else{
					$postdata = [																																	
											"order_status"=>2
									];
						$this->my_model->updateRecord($postdata,'tbl_orders',$order_dtl->id);	
				}
				
			}

			$data['meta_title'] = 'Payment Success';
			$data['meta_desc'] = '';
			$data['meta_keyword'] = '';
			$data['order_dtl'] = $order_dtl;
			$order_price = $this->mylib->getPriceWithCurr($order_dtl->order_price);
			$data['order_price'] = $order_price;

			$data['country_info'] = $this->my_model->getOrderData("tbl_country",['id'=>$order_dtl->bill_country],'country_name');

			$data['company_email'] = $this->mylib->siteinfo()->user_email;
			$data['company_phone'] = $this->mylib->siteinfo()->phone1;

			$cond = ['md5(order_id)'=>$ordId];
			$order_product_info = $this->my_model->getOrderData("tbl_orders_dtl",$cond);
			$data['order_product_info'] = $order_product_info;

			//$data['include']        = $this->viewDirectory . '\invoice_print_views';
			return view($this->viewDirectory . '\invoice_print_views', $data);
		}

		/** Notify me */
		public function notify(){

       
        $mylib = new MyLibrary();
        $siteinfo = $mylib->siteinfo();
        
        if ($this->request->isAJAX()) {
			
			$this->session = Services::session();

            $name = $this->request->getPost('nname');
            $phone = $this->request->getPost('nphone');            
            $email = $this->request->getPost('nemail');
            $workshop_id = $this->request->getPost('workshopid');
			$workshop_name = $this->request->getPost('workshop_name');
            
            
            //echo '<pre>';print_r( $this->request->getPost());  die;
            $return_data=['status'=>0,'msg'=>'Errors! Something went wrong.'];
			$curr_date = date('Y-m-d');
			$cond = "workshop_id='".$workshop_id."' AND email='".$email."' and date(created_at) = '".$curr_date."' ";

			$available_records = $this->my_model->getNotify($cond);

			if(is_object($available_records)){
				$return_data=['status'=>0,'msg'=>'Alert! You have already sent the notify request.'];
			}else{
				$insert_data = ['name'=>$name,'email'=>$email,'phone'=>$phone,'email'=>$email, 'workshop_id'=>$workshop_id, 'created_at'=>date('Y-m-d H:i:s')];

				$insert_id = $this->my_model->addNotify($insert_data);       
				 $return_data=['status'=>1,'msg'=>'success! Data added.'];
				 
				 $thanks_msg = 'You have joined our waiting list successfully for <b>'.$workshop_name.'</b> workshop, You will be notified when this workshop will be available for booking.';
				 $this->session->setFlashData("success", $thanks_msg);
			}
            
           
            
            $return_data = json_encode($return_data);
            echo $return_data;

            
        }
    }

       
}