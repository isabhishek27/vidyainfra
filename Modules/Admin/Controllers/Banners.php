<?php
namespace Modules\Admin\Controllers;

use CodeIgniter\Files\File;
use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;

use Config\Services;
use Modules\Admin\Models\BannersModel;

class Banners extends BackendController {

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

        $this->my_model = new BannersModel();
        
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

        $data['meta_title']		= 'Banners';
        $data['meta_desc']		= 'Banners';
        $data['meta_keyword']	= 'Banners';        

        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){

            $this->my_model->updateStatus($action_type,$arr_ids);
            $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            return redirect()->to(site_url('admin/banners')); 
            
        }

        $banner_section = '';
        $status = '';
        $like_cond =[];
        
        if($this->request->getVar('banner_section')!=NULL){
            $cond['tbl_banners.banner_section'] =  $banner_section = $this->request->getVar('banner_section');           
        }
        $cond['status !='] = 2;

        if($this->request->getVar('status')!=NULL){
            $cond['status'] =  $status = $this->request->getVar('status');
        }
        $data['banner_section'] = $banner_section;
        $data['status'] = $status;

        $per_page = config('MyApplication')->admin_per_page;
        
        
        $results = $this->my_model->getRecord($cond,$like_cond,$per_page); 
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];
        $data['banner_section'] = $this->__bannerSections();

        $data['page_heading']	    = 'Banners';        
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
            return redirect()->to(site_url('admin/banners')); 
         }

        
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
                 
                "id" => [
                    "label" => "Banner Id", 
                    "rules" => "max_length[19]|is_natural_no_zero"
                ], 
                "banner_section" => [
                    "label" => "banner section", 
                    "rules" => "required|is_natural_no_zero|is_unique[tbl_banners.banner_section,tbl_banners.id,{id} ]"
                ]
            ];
            
           //echo '-----'.$this->validate($rules);die;
           if ($this->validate($rules)) {

                $postdata = [
                    "banner_section" => $this->request->getPost("banner_section")
                ];

                /** Image Upload */
                if($this->request->getPost("banner_section") ==1){
                    $old_images = $row->banner_image;
                    $old_image_arr = explode(",",$old_images);
                    $new_image_arr = [];
                    for($i=1;$i<=5;$i++){

                        $img = $this->request->getFile('banner_image'.$i);
                        $k=$i-1;
                        if ($img->isValid() && ! $img->hasMoved()) {
                            $newName = $img->getRandomName();
                            $img->move(FCPATH . 'uploads/banners/', $newName);                            
                            
                            $new_image_arr[]= $newName;

                            /** Unlink old image */
                            $old_img = $old_image_arr[$k];
                            $old_img_path = FCPATH . 'uploads/banners/'.$old_img;
                            if(is_file($old_img_path)){
                                unlink($old_img_path);
                            }
                        }else{
                            
                            $new_image_arr[]= $old_image_arr[$k];
                        }
                        /** End Image Upload */

                    }
                    $img_str = '';
                    if(is_array($new_image_arr) && count($new_image_arr)>0){
                        $img_str = implode(',',$new_image_arr);
                    }
                    $postdata['banner_image'] = $img_str;

                }else{
                    $img = $this->request->getFile('banner_image1');
                
                    if ($img->isValid() && ! $img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move(FCPATH . 'uploads/banners/', $newName);

                        $postdata['banner_image'] = $newName;

                        /** Unlink old image */
                        $old_img = $row->banner_image;
                        $old_img_path = FCPATH . 'uploads/banners/'.$old_img;
                        if(is_file($old_img_path)){
                            unlink($old_img_path);
                        }
                    }
                    /** End Image Upload */
                }                
                

                $this->my_model->updateRecord($postdata,$row->id);                
                $this->session->setFlashData("success", "Record has been updated successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                $redirect_url = site_url('admin/banners');
                if($this->request->getPost('page')!=NULL){
                    $redirect_url .='?page='.$this->request->getPost('page');
                }
                return redirect()->to($redirect_url); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['meta_title']		= 'Edit Banners';
        $data['meta_desc']		= 'Edit Banners';
        $data['meta_keyword']	= 'Edit Banners';
        $data['banner_section'] = $this->__bannerSections();

        $data['page_heading']	    = 'Edit Banners';        
        return view($this->viewDirectory . '\edit_view', $data);
    }   

    public function add(){
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
               "banner_section" => [
                    "label" => "banner section", 
                    "rules" => "required|is_natural_no_zero|is_unique[tbl_banners.banner_section]"
                ]
                
            ];

            $requested_banner_section = $this->request->getPost('banner_section');
            $loopval = ($requested_banner_section==1)?5:'1';
            for($i=1;$i<=$loopval;$i++){
                $inputname = "banner_image".$i;

                $rules[$inputname] = [
                        "label" => "Banner image".$i, 
                        "rules" => "uploaded[$inputname]|is_image[$inputname]|mime_in[$inputname,image/jpg,image/jpeg,image/gif,image/png,image/webp]"
                ];
            }
            
           //echo '<pre>'; print_r($rules);die;
           if ($this->validate($rules)) {

                /** Image Upload */
                $requested_banner_section = $this->request->getPost('banner_section');
                $loopval = ($requested_banner_section==1)?5:'1';   
                $uploaded_img = [];

                for($i=1;$i<=$loopval;$i++){

                    $inputname = "banner_image".$i;
                    $img = $this->request->getFile($inputname);
                    $newName = '';
                    if ($img->isValid() && ! $img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move(FCPATH . 'uploads/banners/', $newName);
                        $uploaded_img[] = $newName;
                    }
                    
                }
                /** End Image Upload */
               
               $uploaded_img_str = '';
               if(is_array($uploaded_img) && count($uploaded_img)>0){
                $uploaded_img_str = implode(',', $uploaded_img);
               } 

               
               $postdata = [
                    "banner_section" => $this->request->getPost("banner_section"),
                    "banner_image" => $uploaded_img_str,
                    "status" => 1,
                    "created_at" => $this->current_date_time
                ];
                $this->my_model->addRecord($postdata);                
                $this->session->setFlashData("success", "Record has been added successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                return redirect()->to(site_url('admin/banners')); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['meta_title']		= 'Add Banner';
        $data['meta_desc']		= 'Add Banner';
        $data['meta_keyword']	= 'Add Banner';
        $data['banner_section'] = $this->__bannerSections();

        $data['page_heading']	    = 'Add Banner';        
        return view($this->viewDirectory . '\add_view', $data);
    }

    public function delete(){
        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $this->my_model->deleteRecord($id);                
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        
        //echo $this->request->getUserAgent()->getReferrer();die;
        return redirect()->to(site_url('admin/banners')); 
    }

    private function __bannerSections(){
        $bsec = ['1'=>'Home Page','2'=>'About Us','3'=>'Blog','4'=>'Blog Detail','6'=>'Get in Touch','7'=>'Workshops','8'=>'Workshop Details','9'=>'Terms & Conditions','10'=>'Privacy Policy','11'=>'Checkout','12'=>'Payment'];

        return $bsec;
    }

    
   
}