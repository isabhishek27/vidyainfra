<?php
namespace Modules\Admin\Controllers;

use CodeIgniter\Files\File;
use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;

use Config\Services;
use Modules\Admin\Models\WorkshopModel;

class Workshop extends BackendController {

    protected $viewDirectory;
    protected $my_model;
    protected $helpers = ['form'];
    protected $login_admin_id;
    protected $current_date_time;

    public function __construct(){

        // start session
        $this->session = Services::session();

        $admin_auth = new Adminauth(); // loads and creates instance
        $admin_auth->isAdminLoggedIn();
        $this->login_admin_id = session()->get('admin_id');
        $this->current_date_time = date('Y-m-d H:i:s');

        $this->my_model = new WorkshopModel();
        
        $uri = current_url(true); 
        $module_name = ucfirst($uri->getSegment(1));
        $module_view_folder = ucfirst($uri->getSegment(2));

        $this->viewDirectory = 'Modules/'. $module_name.'/Views/'.$module_view_folder;
        //echo WRITEPATH;die;
       
    }    
    
    public function index() {

        $pager = Services::pager();
        $data['pager'] =  $this->my_model->pager;
        
        $data['curr_paging'] = $this->request->getVar('page');

        $data['meta_title']		= 'Workshop';
        $data['meta_desc']		= 'Workshop';
        $data['meta_keyword']	= 'Workshop';        

        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){

            $this->my_model->updateStatus($action_type,$arr_ids);
            $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            return redirect()->to(site_url('admin/workshop')); 
            
        }

        $keyword = '';
        $status = '';
        $region = '';
        $country = '';

        $like_cond =[];
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['tbl_workshop.name'] =  $keyword = $this->request->getVar('keyword');           
        }
        $cond['tbl_workshop.status !='] = 3;

        if($this->request->getVar('status')!=NULL){
            $cond['tbl_workshop.status'] =  $status = $this->request->getVar('status');
        }        
        $data['keyword'] = $keyword;
        $data['region']  = $region;
        $data['country'] = $country;
        $data['status']  = $status;
        
        $per_page = config('MyApplication')->admin_per_page;
        
        
        $results = $this->my_model->getRecord($cond,$like_cond,$per_page); 
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];
        

        $data['page_heading']	    = 'Workshop';        
        return view($this->viewDirectory . '\list_view', $data);
        
    }

    public function edit(){

        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $row = $this->my_model->getSingleRecord($id);
        //echo '<pre>';print_r($row);die;
        $data['row'] = $row;
        $data['curr_page'] = ($this->request->getVar('page')!=NULL)?$this->request->getVar('page'):'';

         if(!is_object($row)){

            $this->session->setFlashData("error", "Invalid Id.");
            return redirect()->to(site_url('admin/workshop')); 
         }

        
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
                 
                "id" => [
                    "label" => "Id", 
                    "rules" => "max_length[19]|is_natural_no_zero"
                ], 
                "name" => [
                    "label" => "workshop title", 
                    "rules" => "required|min_length[3]|max_length[200]|is_unique[tbl_workshop.name,tbl_workshop.id,{id} ]"
                ],                
                "total_seat" => [
                    "label" => "total students allowed", 
                   "rules" => "required|numeric|greater_than[0]"
                ],
                "full_payment" => [
                    "label" => "full payment amount", 
                    "rules" => "required|decimal|greater_than[0]"
                ],
                "full_payment_discounted" => [
                    "label" => "full payment discounted amount", 
                    "rules" => "trim"
                ],
                "down_payment" => [
                    "label" => "down payment amount", 
                    "rules" => "required|numeric|decimal|greater_than[0]"
                ],                
                "workshop_location" => [
                    "label" => "workshop location", 
                    "rules" => "required|min_length[3]|max_length[200]"
                ],
                "photographar_id" => [
                    "label" => "photographer", 
                    "rules" => "required"
                ],
                "workshop_date" => [
                    "label" => "workshop start date", 
                    "rules" => "required"
                ],
				"workshop_end_date" => [
                    "label" => "workshop end date", 
                    "rules" => "required"
                ],								
				"photo" => [
                    "label" => "Photo", 
                    "rules" => "is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/gif,image/png,image/webp]"
                 ],
                "workshop_desc" => [
                    "label" => "about workshop", 
                    "rules" => "required|min_length[3]"
                ],
                "banner" => [
                    "label" => "Banner image", 
                    "rules" => "is_image[banner]|mime_in[photo,image/jpg,image/jpeg,image/gif,image/png,image/webp]"
                 ],
                "meta_title" => [
                    "label" => "Meta title", 
                    "rules" => "max_length[200]"
                ],
                "meta_desc" => [
                    "label" => "Meta descripton", 
                    "rules" => "max_length[200]"
                ],
                "meta_keyword" => [
                    "label" => "Meta keyword", 
                    "rules" => "max_length[200]"
                ]
            ];
            
           // echo '-----'.$this->validate($rules);die;
           if ($this->validate($rules)) {

                $photographar_ids = implode(",", (array) $this->request->getPost("photographar_id"));
                $postdata = [
                    "photographar_id" => $photographar_ids,
                    "name" => $this->request->getPost("name"),
                    "url_slug" => url_title($this->request->getPost("name"),'-',true),
                    "full_payment" => $this->request->getPost("full_payment"),
                    "full_payment_discounted" => $this->request->getPost("full_payment_discounted"),
                    "down_payment" => $this->request->getPost("down_payment"),
                    "total_seat" => $this->request->getPost("total_seat"),
                    "workshop_location" => $this->request->getPost("workshop_location"),
                    "workshop_desc" => $this->request->getPost("workshop_desc"),
                    "workshop_itinerary" => $this->request->getPost("workshop_itinerary"),
                    "workshop_date" => $this->request->getPost("workshop_date"),
                    "workshop_end_date" => $this->request->getPost("workshop_end_date"),
                    "meta_title" => $this->request->getPost("meta_title"),
                    "meta_desc" => $this->request->getPost("meta_desc"),
                    "meta_keyword" => $this->request->getPost("meta_keyword")
                ];
								
                /** Image Upload */                
                $img = $this->request->getFile('photo');
                
                if ($img->isValid() && ! $img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move(FCPATH . 'uploads/workshop/', $newName);

                        $postdata['photo'] = $newName;

                        /** Unlink old image */
                        $old_img = $row->photo;
                        $old_img_path = FCPATH . 'uploads/workshop/'.$old_img;
                        if(is_file($old_img_path)){
                                unlink($old_img_path);
                        }
                }
                /** End Image Upload */

                /** Banner Image Upload */                
                $banner_img = $this->request->getFile('banner');
                
                if ($banner_img->isValid() && ! $banner_img->hasMoved()) {
                        $bnewName = $banner_img->getRandomName();
                        $banner_img->move(FCPATH . 'uploads/workshop/', $bnewName);

                        $postdata['banner'] = $bnewName;

                        /** Unlink old image */
                        $bold_img = $row->banner;
                        $bold_img_path = FCPATH . 'uploads/workshop/'.$bold_img;
                        if(is_file($bold_img_path)){
                                unlink($bold_img_path);
                        }
                }
                /** End Image Upload */
                
                //Notify to waiting list user
                $total_seat_before_update = $row->total_seat;
                $total_seat_update = $this->request->getPost("total_seat");
                if($total_seat_before_update==0 && $total_seat_update> 0){

                    $this->__notifyToWaitingUsers($row->id);
                    
                }


                $this->my_model->updateRecord($postdata,$row->id);                
                $this->session->setFlashData("success", "Record has been updated successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                $redirect_url = site_url('admin/workshop');
                if($this->request->getPost('page')!=NULL){
                    $redirect_url .='?page='.$this->request->getPost('page');
                }
                return redirect()->to($redirect_url); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['photographars'] = $this->my_model->getPhotographar(); 

        $data['meta_title']		= 'Edit Workshop';
        $data['meta_desc']		= 'Edit Workshop';
        $data['meta_keyword']	= 'Edit Workshop';

        $data['page_heading']	    = 'Edit Workshop';        
        return view($this->viewDirectory . '\edit_view', $data);
    }   

    public function add(){
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [               
                "name" => [
                    "label" => "workshop title", 
                    "rules" => "required|min_length[3]|max_length[200]|is_unique[tbl_workshop.name]"
                ],
                "total_seat" => [
                    "label" => "total students allowed", 
                   "rules" => "required|numeric|greater_than[0]"
                ],
                "full_payment" => [
                    "label" => "full payment amount", 
                    "rules" => "required|decimal|greater_than[0]"
                ],
                "full_payment_discounted" => [
                    "label" => "full payment discounted amount", 
                    "rules" => "trim"
                ],
                "down_payment" => [
                    "label" => "down payment amount", 
                    "rules" => "required|numeric|decimal|greater_than[0]"
                ],                
                "workshop_location" => [
                    "label" => "workshop location", 
                    "rules" => "required|min_length[3]|max_length[200]"
                ],
                "photographar_id" => [
                    "label" => "photographer", 
                    "rules" => "required"
                ],
                "workshop_date" => [
                    "label" => "workshop start date", 
                    "rules" => "required"
                ],
                "workshop_end_date" => [
                    "label" => "workshop end date", 
                    "rules" => "required"
                ],
                "photo" => [
                "label" => "Photo", 
                "rules" => "uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/gif,image/png,image/webp]"
                ],
                "banner" => [
                "label" => "Banner image", 
                "rules" => "uploaded[banner]|is_image[banner]|mime_in[photo,image/jpg,image/jpeg,image/gif,image/png,image/webp]"
                ],
                "workshop_desc" => [
                    "label" => "about workshop", 
                    "rules" => "required|min_length[3]"
                ],                
                "meta_title" => [
                    "label" => "Meta title", 
                    "rules" => "max_length[200]"
                ],
                "meta_desc" => [
                    "label" => "Meta descripton", 
                    "rules" => "max_length[200]"
                ],
                "meta_keyword" => [
                    "label" => "Meta keyword", 
                    "rules" => "max_length[200]"
                ]
            ];
            
            
           if ($this->validate($rules)) {               
               
                /** Image Upload */                
                $img = $this->request->getFile('photo');
                $newName = '';
                if ($img->isValid() && ! $img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move(FCPATH . 'uploads/workshop/', $newName);
                }
                /** End Image Upload */

                /** Banner Image Upload */                
                $banner_img = $this->request->getFile('banner');
                $bnewName = '';
                if ($banner_img->isValid() && ! $banner_img->hasMoved()) {
                        $bnewName = $banner_img->getRandomName();
                        $banner_img->move(FCPATH . 'uploads/workshop/', $bnewName);
                }
                /** End Banner Image Upload */

               $display_order = $this->my_model->getDisplayOrder()+1; 
               $photographar_ids = implode(",", (array) $this->request->getPost("photographar_id"));
               $postdata = [
                   "photographar_id" => $photographar_ids,
                    "name" => $this->request->getPost("name"),
                    "url_slug" => url_title($this->request->getPost("name"),'-',true),
                    "photo" => $newName,
                    "banner" => $bnewName,
                    "disp_order" => $display_order,
                    "full_payment" => $this->request->getPost("full_payment"),
                    "full_payment_discounted" => $this->request->getPost("full_payment_discounted"),
                    "down_payment" => $this->request->getPost("down_payment"),
                    "total_seat" => $this->request->getPost("total_seat"),
                    "workshop_location" => $this->request->getPost("workshop_location"),
                    "workshop_desc" => $this->request->getPost("workshop_desc"),
                    "workshop_itinerary" => $this->request->getPost("workshop_itinerary"),
                    "workshop_date" => $this->request->getPost("workshop_date"),
					"workshop_end_date" => $this->request->getPost("workshop_end_date"),
                    "status" => 1,
                    "created_at" => $this->current_date_time,
                    "meta_title" => $this->request->getPost("meta_title"),
                    "meta_desc" => $this->request->getPost("meta_desc"),
                    "meta_keyword" => $this->request->getPost("meta_keyword")
                ];
                $this->my_model->addRecord($postdata);                
                $this->session->setFlashData("success", "Record has been added successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                return redirect()->to(site_url('admin/workshop')); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['meta_title']		= 'Add Workshop';
        $data['meta_desc']		= 'Add Workshop';
        $data['meta_keyword']	= 'Add Workshop';

        $data['photographars'] = $this->my_model->getPhotographar();

        $data['page_heading']	    = 'Add Workshop';        
        return view($this->viewDirectory . '\add_view', $data);
    }

    public function delete(){
        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $this->my_model->deleteRecord($id);                
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        
        //echo $this->request->getUserAgent()->getReferrer();die;
        return redirect()->to(site_url('admin/workshop')); 
    }

    /** Waiting List */
     public function waitinglist() {

        $pager = Services::pager();
        $data['pager'] =  $this->my_model->pager;
        
        $data['curr_paging'] = $this->request->getVar('page');

        $data['meta_title']		= 'Waiting List';
        $data['meta_desc']		= 'Waiting List';
        $data['meta_keyword']	= 'Waiting List';

        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){

            $this->my_model->deleteWaitingLists($arr_ids);
            $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            return redirect()->to(site_url('admin/workshop/waitinglist')); 
            
        }

        $cond['id !='] = 2;

        $keyword = '';
        $status = '';
        $like_cond =[];
        $cond =[];
        
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['tbl_notify.name'] =  $keyword = $this->request->getVar('keyword');           
        }
        
        $cond['tbl_notify.id !='] = 0;

        if($this->request->getVar('status')!=NULL){
            $cond['tbl_notify.status'] =  $status = $this->request->getVar('status');
        }
        $data['keyword'] = $keyword;
        $data['status'] = $status;
        
        
        $per_page = config('MyApplication')->admin_per_page;
       
        $per_page = config('MyApplication')->admin_per_page;
        
        $results = $this->my_model->getWaitingList($cond,$like_cond,$per_page); 
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];

        $data['page_heading']	    = 'Workshop Waiting List';        
        return view($this->viewDirectory . '\waitinglist_views', $data);
        
    }   

    public function waitinglist_delete(){
        $uri = current_url(true); 
        $cat_id = (int)($uri->getSegment(4));
        
        $this->my_model->deleteWaitingList($cat_id);                
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        
        //echo $this->request->getUserAgent()->getReferrer();die;
        return redirect()->to(site_url('admin/workshop/waitinglist')); 
    }

    private function __notifyToWaitingUsers($workshop_id){

        $send_mail = false;

        if($send_mail){
            $condition = "tbl_notify.status=0 AND tbl_notify.workshop_id='".$workshop_id."'";
            $result = $this->my_model->getNotifyUsers($condition);
            if(is_array($result) && count($result) > 0){

                //Sending mail start
                $email = \Config\Services::email();
                $mylib = new MyLibrary();
                $siteinfo = $mylib->siteinfo();

                foreach($result as $k=>$row){
                    
                    $update_data = ['status'=>1];
                    $this->my_model->updateWaitingList($update_data,$row->id);
                    
                    $name = $row->name;
                    $email = $row->email;
                    $workshop_name = $row->workshop_name;
                    $workshop_url = site_url('workshop/details/'.$row->url_slug);

                    /** Send confirmation mail to visitor start */
                    $body = file_get_contents(FCPATH."assets/email-template/confirmation.htm");
                    
                    $subject  =  "$workshop_name Workshop spots is now available on ".$siteinfo->comp_name;
                    $content	=	 "Workshop ($workshop_name) spots is now available. <a href='".$workshop_url."'>Click here</a> to book your spots.";
                    $body			=	str_replace('{mem_name}',$name,$body);
                    $body			=	str_replace('{content}',$content,$body);
                    
                    $body			=	str_replace('{site_name}',$siteinfo->comp_name,$body);
                    $body			=	str_replace('{admin_email}',$siteinfo->user_email,$body);
                    $body			=	str_replace('{base_url}',base_url(),$body);
                    $body			=	str_replace('{copyright_year}',date('Y'),$body);    
                    

                    $email->setFrom($siteinfo->user_email, $siteinfo->comp_name);
                    $email->setTo($email);
                    $email->setSubject($subject);
                    $email->setMessage($body);

                }
            }
        }
    }

    
   
}