<?php
namespace Modules\Pages\Controllers;
use App\Controllers\FrontendController;

use Config\Services;
use Modules\Pages\Models\PagesModel;
use App\Libraries\MyLibrary; 

class Pages extends FrontendController {

    protected $viewDirectory;
    protected $my_model;
    protected $helpers = ['form'];
    protected $seg1;    
    protected $ml;
    protected $mylib;

    public function __construct(){
        
        $uri = current_url(true);
        $this->seg1 = $uri->getSegment(1);
        $this->my_model = new PagesModel();    
        $this->mylib = new MyLibrary();            

        $module_name = 'Pages';        
        $this->viewDirectory = 'Modules/'. $module_name.'/Views';
    }
    
    public function index() {
        
        return redirect()->to(base_url());
        
    }

    public function about(){        
        $cond=" AND `page_slug` = '".$this->seg1."' ";
        $select_fld = "`page_title`,`page_content`,`meta_title`,`meta_desc`,`meta_keyword`";
        $pg_data = $this->my_model->getSingleRecord($select_fld, $cond);
        
        $data['meta_title']		= $pg_data->meta_title;
        $data['meta_desc']		= $pg_data->meta_desc;
        $data['meta_keyword']	= $pg_data->meta_keyword;

        $data['page_title']	    = $pg_data->page_title;
        $data['page_content']	= str_replace('{{img_path}}',base_url().'/public/assets/',$pg_data->page_content);

        $cond =" AND `banner_section` = 2 ";
        $banners = $this->my_model->getBanners('banner_image',$cond);
        $data['banners'] = $banners;

        $data['include']        = $this->viewDirectory . '\about_views';

		return view('container', $data);
    }

    public function cms(){
                
        $cond=" AND `page_slug` = '".$this->seg1."' ";
        $select_fld = "p.`page_title`,p.`page_content`,p.`meta_title`,p.`meta_desc`,p.`meta_keyword`,p.`is_main_page`,c.`cat_name`";
        $pg_data = $this->my_model->getCmsPageContent($select_fld, $cond);
        
        $data['meta_title']		= $pg_data->meta_title;
        $data['meta_desc']		= $pg_data->meta_desc;
        $data['meta_keyword']	= $pg_data->meta_keyword;
        
        $data['page_title']	    = $pg_data->page_title;
        $data['page_content']	= str_replace('{{img_path}}',base_url().'/public/assets/',$pg_data->page_content);
        $data['page_cat']	    = $pg_data->cat_name;
        $data['is_main_page']	= $pg_data->is_main_page;        
        $data['page_slug'] = $this->seg1;

        $ban_sec = 0;
        if($this->seg1 == 'terms-and-conditions'){
            $ban_sec = 9;
        }elseif($this->seg1 == 'privacy-policy'){
            $ban_sec = 10;
        }
        if($ban_sec>0){
            $cond =" AND `banner_section` = $ban_sec ";
            $banners = $this->my_model->getBanners('banner_image',$cond);
            $data['banners'] = $banners;
        }

        $data['include']        = $this->viewDirectory . '\cms_views';

		return view('container', $data);
    }

    public function newsletter(){
        if ($this->request->isAJAX()) {
            $n_name = $this->request->getPost('n_name');
            $n_email = $this->request->getPost('n_email');

            $return_data=['status'=>0,'msg'=>'Errors! Something went wrong.'];

            $is_subscriber_exist = $this->my_model->isNewsletterExists($n_email);
            if($is_subscriber_exist){
                $update_data = ['name'=>$n_name, 'is_subscribed'=>1];
                $is_updated = $this->my_model->updateNewsletter($n_email, $update_data);
                if($is_updated){
                    $return_data=['status'=>1,'msg'=>'Thanks for subscribing with us.'];
                }
                
            }else{
                $insert_data = ['name'=>$n_name, 'email'=>$n_email, 'is_subscribed'=>1,'created_at'=>date('Y-m-d H:i:s')];
                $insert_id = $this->my_model->addNewsletter($insert_data);
                if($insert_id){
                    $return_data=['status'=>1,'msg'=>'Thanks for subscribing with us.'];   
                }
            }

            
            $return_data = json_encode($return_data);
            echo $return_data;

            
        }
    }

    public function post_request_a_quote(){
        if ($this->request->isAJAX()) {
            $first_name = $this->request->getPost('first_name');
            $last_name = $this->request->getPost('last_name');
            $email = $this->request->getPost('email');
            $mobile_number = $this->request->getPost('mobile_number');                        
            $workshop = $this->request->getPost('workshop');
            $travel_location = $this->request->getPost('travel_location');
            
            //echo '<pre>';print_r( $this->request->getPost());  die;
            $return_data=['status'=>0,'msg'=>'Errors! Something went wrong.'];

            $insert_data = ['first_name'=>$first_name, 'last_name'=>$last_name, 'mobile_number'=>$mobile_number,'email'=>$email, 'workshop'=>$workshop, 'travel_location'=>$travel_location, 'created_at'=>date('Y-m-d H:i:s')];
           
            $insert_id = $this->my_model->addRequestQuote($insert_data);
            
            if($insert_id){
                
                
                #Puah data on MailerLight
                
                $is_push_to_mailerlight = 0;
                if(getenv('CI_ENVIRONMENT') == 'production'){
                   $is_push_to_mailerlight = 1; 
                }
                if($is_push_to_mailerlight){

                    $name = $first_name;
                    if(!empty($last_name)){
                        $name .=' '.$last_name;
                    }                                    
                   
                    if(!empty($email)){
                        $response = service('curlrequest')->post(
                            'https://connect.mailerlite.com/api/subscribers',
                            [
                                //'http_errors' => false,
                                //'verify' => false,
                                'headers' => [
                                    'Authorization' => 'Bearer ' . getenv('MAILERLITE_API_KEY'),
                                    'Accept'        => 'application/json',
                                    'Content-Type'  => 'application/json',
                                ],
                                'json' => [
                                    'email' => $email,
                                    'fields' => [
                                        'name' => $name
                                    ]
                                ],
                            ]
                        );

                        $data = json_decode($response->getBody(), true);
                        //var_dump($data);die;
                    }
                } 

                $return_data=['status'=>1,'msg'=>'Thanks for showing interest with us.'];
            }

            
            $return_data = json_encode($return_data);
            echo $return_data;

            
        }
    }
    /*
    public function request_a_quote(){
        $data['meta_title']		= 'Web Development Company In India | Website Development Agency In New York | USA | Near Me';
        $data['meta_desc']		= 'Are you looking for a top web development company in India? Our Website development agency in New York, Near Me, delivers cutting-edge websites tailored to your business needs. Contact us today for local and affordable web development services in USA near me';
        $data['meta_keyword']	= 'Web Development Company In India, Website Development Agency In New York, Web Development Company In USA, Web Development Company In Australia, Web Development Company In USA, Near Me';

        $data['include']        = $this->viewDirectory . '\request_a_quote_views';

		return view('container', $data);
    }
    */

    public function contact_us(){
        
        $cond = "`slug`='contact-us' AND `status` = 1 ";
		$args = ['tbl_name'=>'tbl_seo','select_fld'=>'meta_title,meta_keyword,meta_desc','where'=>$cond];
		$meta_info = $this->mylib->getRecords($args);
		if(is_array($meta_info) && count($meta_info)>0){
			$meta_info = $meta_info[0];
		}
        
        $data['meta_title'] = (isset($meta_info->meta_title) && !empty($meta_info->meta_title))?$meta_info->meta_title:'Contact Us';
        $data['meta_desc'] = (isset($meta_info->meta_desc) && !empty($meta_info->meta_desc))?$meta_info->meta_desc:'Contact Us';
        $data['meta_keyword'] = (isset($meta_info->meta_keyword) && !empty($meta_info->meta_keyword))?$meta_info->meta_keyword:'';

        $data['contact_main_page'] = 1;

        $cond =" AND `banner_section` = 6 ";
        $banners = $this->my_model->getBanners('banner_image',$cond);
        $data['banners'] = $banners;

        $data['include']        = $this->viewDirectory . '\contact_us_views';

		return view('container', $data);
    }

    public function post_contact_us_bkp(){

       
        $mylib = new MyLibrary();
        $siteinfo = $mylib->siteinfo();
        
        if ($this->request->isAJAX()) {
            $first_name = $this->request->getPost('first_name');
            $last_name = $this->request->getPost('last_name');
            $address = $this->request->getPost('address');
            $mobile_number = $this->request->getPost('mobile_number');            
            $email_addr = $this->request->getPost('email');
            $message = $this->request->getPost('message');
            
            
            //echo '<pre>';print_r( $this->request->getPost());  die;
            $return_data=['status'=>0,'msg'=>'Errors! Something went wrong.'];

            $insert_data = ['first_name'=>$first_name,'last_name'=>$last_name, 'address'=>$address, 'mobile_number'=>$mobile_number,'email'=>$email_addr, 'requirements'=>$message, 'created_at'=>date('Y-m-d H:i:s')];
           
            $insert_id = $this->my_model->addContact($insert_data);
            
            if($insert_id){

                $is_send_mail = 1;                
                $mail_sent_msg = "Email not sent due to emailer not enabled.";

                #Puah data on MailerLight
                $is_push_to_mailerlight = 0;
                if(getenv('CI_ENVIRONMENT') == 'production'){
                   $is_push_to_mailerlight = 1; 
                }
                if($is_push_to_mailerlight){

                    $name = $first_name;
                    if(!empty($last_name)){
                        $name .=' '.$last_name;
                    }
                    $email = $email_addr;                   
                   
                    if(!empty($email)){
                        $response = service('curlrequest')->post(
                            'https://connect.mailerlite.com/api/subscribers',
                            [
                                //'http_errors' => false,
                                //'verify' => false,
                                'headers' => [
                                    'Authorization' => 'Bearer ' . getenv('MAILERLITE_API_KEY'),
                                    'Accept'        => 'application/json',
                                    'Content-Type'  => 'application/json',
                                ],
                                'json' => [
                                    'email' => $email,
                                    'fields' => [
                                        'name' => $name
                                    ],
                                ]
                            ]
                        );

                        $data = json_decode($response->getBody(), true);
                    }
                }

                if($is_send_mail){

                    //Sending mail start
                    $email = \Config\Services::email();
                    $mylib = new MyLibrary();
                    $siteinfo = $mylib->siteinfo();

                    $name=  $first_name." ".$last_name ;
                    
                    
                    /** Send confirmation mail to visitor start */
                    $body = file_get_contents(FCPATH."assets/email-template/confirmation.htm");
                    
                    $subject  =  "Thanks for sending enquiry on ".$siteinfo->comp_name;
                    $content	=	 "Thanks for sending enquiry with us. Our team will contact you shortly.";
                    $body			=	str_replace('{mem_name}',$name,$body);
                    $body			=	str_replace('{content}',$content,$body);
                    
                    $body			=	str_replace('{site_name}',$siteinfo->comp_name,$body);
                    $body			=	str_replace('{admin_email}',$siteinfo->user_email,$body);
                    $body			=	str_replace('{base_url}',base_url(),$body);
                    $body			=	str_replace('{copyright_year}',date('Y'),$body);    
                    

                    $email->setFrom($siteinfo->user_email, $siteinfo->comp_name);
                    //$email->setFrom($email->fromEmail, $email->fromName); 
                    $email->setReplyTo($siteinfo->user_email, 'Internationalphotoworkshops');
                    $email->setTo($email_addr);
                    $email->setSubject('Thank!! Your enquiry has been received');
                    $email->setMessage($body);
                    $email->setMailType('html');
                    //echo '<pre>';print_r($email);die;

                    if ($email->send()) {
                        $mail_sent_msg = 'Email sent successfully!';
                    } else {
                        $mail_sent_msg = 'Email sending failed.';
                        //echo $email->printDebugger(['headers']);die('dfsdf');
                    }
                    /** Send confirmation mail to visitor end */




                    /** Send mail to Admin start */
                    $email = \Config\Services::email();
                    
                    $body = file_get_contents(FCPATH."assets/email-template/contact_us.htm");
                    $address = (!empty($address))?$address:'NA';

                    $subject  =  "New contactus enquiry received at ".config('MyApplication')->site_name;
                    $body			=	str_replace('{mem_name}',"Admin",$body);
                    $body			=	str_replace('{content}',"New contactus enquiry received.",$body);
                    $body			=	str_replace('{name}',$name,$body);
                    $body			=	str_replace('{email}',$email_addr,$body);
                    $body			=	str_replace('{address}',$address,$body);
                    $body			=	str_replace('{mobile_no}',$mobile_number,$body);                    
                    $body			=	str_replace('{comments}',$message,$body);
                    $body			=	str_replace('{site_name}',$siteinfo->comp_name,$body);
                    $body			=	str_replace('{admin_email}',$siteinfo->user_email,$body);
                    $body			=	str_replace('{base_url}',base_url(),$body);
                    $body			=	str_replace('{copyright_year}',date('Y'),$body);

                    $email->setFrom($siteinfo->user_email, 'Internationalphotoworkshops');
                    //$email->setFrom($email->fromEmail, $email->fromName);
                    $email->setReplyTo($email->fromEmail, $email->fromName); 
                    $email->setTo($siteinfo->user_email);
                    $email->setSubject($subject);
                    $email->setMessage($body);
                    $email->setMailType('html');

                    if ($email->send()) {
                        $mail_sent_msg = 'Email sent successfully!';
                    } else {
                        $mail_sent_msg = 'Email sending failed.';
                        //echo $email->printDebugger(['headers']);
                    }                    
                    /** Send mail to Admin ends */

                    //Sending mail ends
                }

                $return_data=['status'=>1,'msg'=>'Contact enquiry added.','mail_sent_msg'=>$mail_sent_msg];   
            }

            
            $return_data = json_encode($return_data);
            echo $return_data;

            
        }
    }

    public function post_contact_us()
    {
        $mylib = new MyLibrary();
        $siteinfo = $mylib->siteinfo();

        if ($this->request->isAJAX()) {
            $first_name    = trim((string) $this->request->getPost('first_name'));
            $last_name     = trim((string) $this->request->getPost('last_name'));
            $address       = trim((string) $this->request->getPost('address'));
            $mobile_number = trim((string) $this->request->getPost('mobile_number'));
            $email_addr    = trim((string) $this->request->getPost('email'));
            $message       = trim((string) $this->request->getPost('message'));

            $return_data = ['status'=>0,'msg'=>'Errors! Something went wrong.'];

            $insert_data = [
                'first_name'    => $first_name,
                'last_name'     => $last_name,
                'address'       => $address,
                'mobile_number' => $mobile_number,
                'email'         => $email_addr,
                'requirements'  => $message,
                'created_at'    => date('Y-m-d H:i:s'),
            ];

            $insert_id = $this->my_model->addContact($insert_data);

            if ($insert_id) {
                $is_send_mail   = 1;
                $mail_sent_msg  = 'Email not sent due to emailer not enabled.';

                #Puah data on MailerLight
                $is_push_to_mailerlight = 0;
                if(getenv('CI_ENVIRONMENT') == 'production'){
                   $is_push_to_mailerlight = 1; 
                }
                if($is_push_to_mailerlight){

                    $name = $first_name;
                    if(!empty($last_name)){
                        $name .=' '.$last_name;
                    }
                    $email = $email_addr;                   
                   
                    if(!empty($email)){
                        $response = service('curlrequest')->post(
                            'https://connect.mailerlite.com/api/subscribers',
                            [
                                //'http_errors' => false,
                                //'verify' => false,
                                'headers' => [
                                    'Authorization' => 'Bearer ' . getenv('MAILERLITE_API_KEY'),
                                    'Accept'        => 'application/json',
                                    'Content-Type'  => 'application/json',
                                ],
                                'json' => [
                                    'email' => $email,
                                    'fields' => [
                                        'name' => $name
                                    ],
                                ]
                            ]
                        );

                        $data = json_decode($response->getBody(), true);
                    }
                }

                if ($is_send_mail) {
                    // One shared Email instance; clear between sends
                    $mailer = \Config\Services::email();
                    $cfg    = config('Email');

                    // Build common data
                    $name   = trim($first_name . ' ' . $last_name);

                    // 1) Visitor confirmation
                    $bodyVisitor = file_get_contents(FCPATH . 'assets/email-template/confirmation.htm');
                    $bodyVisitor = str_replace('{mem_name}', $name, $bodyVisitor);
                    $bodyVisitor = str_replace('{content}', 'Thanks for sending enquiry with us. Our team will contact you shortly.', $bodyVisitor);
                    $bodyVisitor = str_replace('{site_name}', $siteinfo->comp_name, $bodyVisitor);
                    $bodyVisitor = str_replace('{admin_email}', $siteinfo->user_email, $bodyVisitor);
                    $bodyVisitor = str_replace('{base_url}', base_url(), $bodyVisitor);
                    $bodyVisitor = str_replace('{copyright_year}', date('Y'), $bodyVisitor);

                    // From must be your Zoho mailbox or verified alias
                    $mailer->setFrom($cfg->fromEmail, $cfg->fromName);
                    $mailer->setTo($email_addr);
                    $mailer->setSubject('Thank you! Your enquiry has been received');
                    $mailer->setMessage($bodyVisitor);
                    $mailer->setMailType('html');
                    //echo '<pre>';print_r($mailer);die;
                    $ok1 = $mailer->send();
                    if (! $ok1) {
                        // Debug when needed:
                        // log_message('error', print_r($mailer->printDebugger(['headers', 'subject', 'body']), true));
                    }

                    // 2) Admin notification
                    $mailer->clear(true); // reset recipients/headers/attachments as documented
                    $bodyAdmin = file_get_contents(FCPATH . 'assets/email-template/contact_us.htm');
                    $bodyAdmin = str_replace('{mem_name}', 'Admin', $bodyAdmin);
                    $bodyAdmin = str_replace('{content}', 'New contactus enquiry received.', $bodyAdmin);
                    $bodyAdmin = str_replace('{name}', $name, $bodyAdmin);
                    $bodyAdmin = str_replace('{email}', $email_addr, $bodyAdmin);
                    $bodyAdmin = str_replace('{address}', (!empty($address) ? $address : 'NA'), $bodyAdmin);
                    $bodyAdmin = str_replace('{mobile_no}', $mobile_number, $bodyAdmin);
                    $bodyAdmin = str_replace('{comments}', $message, $bodyAdmin);
                    $bodyAdmin = str_replace('{site_name}', $siteinfo->comp_name, $bodyAdmin);
                    $bodyAdmin = str_replace('{admin_email}', $siteinfo->user_email, $bodyAdmin);
                    $bodyAdmin = str_replace('{base_url}', base_url(), $bodyAdmin);
                    $bodyAdmin = str_replace('{copyright_year}', date('Y'), $bodyAdmin);

                    $subjectAdmin = 'New contact enquiry received at ' . config('MyApplication')->site_name;

                    $mailer->setFrom($cfg->fromEmail, $cfg->fromName);         // Zoho-authenticated sender (do not use visitor here)
                    $mailer->setTo($siteinfo->user_email);                     // Admin recipient
                    $mailer->setReplyTo($email_addr, $name);                   // Let admin reply to the visitor safely
                    $mailer->setSubject($subjectAdmin);
                    $mailer->setMessage($bodyAdmin);
                    $mailer->setMailType('html');

                    $ok2 = $mailer->send();
                    if ($ok1 && $ok2) {
                        $mail_sent_msg = 'Email(s) sent successfully!';
                        //echo $siteinfo->user_email.'----'.$email_addr;die;

                    } else {
                        $mail_sent_msg = 'One or more emails failed to send.';
                    }
                }

                $return_data = ['status'=>1,'msg'=>'Contact enquiry added.','mail_sent_msg'=>$mail_sent_msg];
            }

            echo json_encode($return_data);
        }
    }


    public function thank_you(){
        $this->session = Services::session();
        $data['meta_title']		= 'Thank you';
        $data['meta_desc']		= 'Thank you';
        $data['meta_keyword']	= 'Thank you';
                
        $data['include']        = $this->viewDirectory . '\thanks_views';

		return view('container', $data);
    }

    public function sitemap()
    {

        $db = \Config\Database::connect();

        // Get pages
        $builder = $db->table('tbl_pages');
        $pages = $builder
            ->where('page_slug !=', 'home')
            ->where('page_slug !=', 'home-page-footer')
            ->select('page_slug')
            ->get()
            ->getResult();

        // Get SEO slugs
        $builder = $db->table('tbl_seo');
        $seo = $builder
            ->select('slug')
            ->get()
            ->getResult();

        // Get Work slugs
        $builder = $db->table('tbl_workshop');
        $workshop = $builder
            ->where('status','1')
            ->select('url_slug')
            ->get()
            ->getResult();
            
        // Get Blog Post slugs
        $builder = $db->table('tbl_posts');
        $blogpost = $builder
            ->where('status','1')
            ->select('b_slug')
            ->get()
            ->getResult();    

        $data = [
            'result' => $pages,
            'result2' => $seo,
            'result3' => $workshop,
            'result4' => $blogpost
        ];

        return $this->response
            ->setHeader('Content-Type', 'application/xml')
            ->setBody(view($this->viewDirectory . '\sitemap', $data));
    }

    public function port_test(){
        $host = 'smtp.zoho.com';
        $ports = [25, 465, 587];

        foreach ($ports as $port) {
            echo "Testing port $port...<br>";
            $connection = @fsockopen($host, $port, $errno, $errstr, 10);
            if ($connection) {
                echo "✅ Port $port is OPEN<br><br>";
                fclose($connection);
            } else {
                echo "❌ Port $port is BLOCKED or FILTERED ($errstr)<br><br>";
            }
        }
    }
}