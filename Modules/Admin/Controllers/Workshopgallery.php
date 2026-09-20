<?php
namespace Modules\Admin\Controllers;

use CodeIgniter\Files\File;
use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;

use Config\Services;
use Modules\Admin\Models\WorkshopgalleryModel;

class Workshopgallery extends BackendController {

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

        $this->my_model = new WorkshopgalleryModel();
        
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

        $data['meta_title']		= 'Workshop Gallery';
        $data['meta_desc']		= 'Workshop Gallery';
        $data['meta_keyword']	= 'Workshop Gallery';        

        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){

            $this->my_model->updateStatus($action_type,$arr_ids);
            $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            return redirect()->to(site_url('admin/workshopgallery')); 
            
        }

        $keyword = '';
        $status = '';
        $workshop_id = '';

        $like_cond =[];
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['tbl_workshop_gallery.name'] =  $keyword = $this->request->getVar('keyword');           
        }
        if($this->request->getVar('workshop_id')!=NULL){
            $like_cond['tbl_workshop_gallery.workshop_id'] =  $workshop_id = $this->request->getVar('workshop_id');           
        }
        
        $cond['tbl_workshop_gallery.status !='] = 2;

        if($this->request->getVar('status')!=NULL){
            $cond['tbl_workshop_gallery.status'] =  $status = $this->request->getVar('status');
        }        
        $data['keyword'] = $keyword;
        $data['workshop_id']  = $workshop_id;
        $data['status']  = $status;
        
        $per_page = config('MyApplication')->admin_per_page;
        
        
        $results = $this->my_model->getRecord($cond,$like_cond,$per_page); 
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];
        

        $data['page_heading']	    = 'Workshop Gallery';        
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
            return redirect()->to(site_url('admin/workshopgallery')); 
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
                    "label" => "name", 
                    "rules" => "required|min_length[3]|max_length[200]"
                ],
                "workshop_id" => [
                    "label" => "workshop", 
                    "rules" => "required"
                ],
                "photo" => [
                    "label" => "Photo", 
                    "rules" => "is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/gif,image/png,image/webp]"
                ]
                
            ];
            
           // echo '-----'.$this->validate($rules);die;
           if ($this->validate($rules)) {

                $postdata = [
                    "name" => $this->request->getPost("name"),
                     "workshop_id" => $this->request->getPost("workshop_id"),                  
                ];

                /** Image Upload */                
                $img = $this->request->getFile('photo');
                
                if ($img->isValid() && ! $img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move(FCPATH . 'uploads/workshopgallery/', $newName);

                    $postdata['photo'] = $newName;

                    /** Unlink old image */
                    $old_img = $row->photo;
                    $old_img_path = FCPATH . 'uploads/workshopgallery/'.$old_img;
                    if(is_file($old_img_path)){
                        unlink($old_img_path);
                    }
                }
                /** End Image Upload */

                $this->my_model->updateRecord($postdata,$row->id);                
                $this->session->setFlashData("success", "Record has been updated successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                $redirect_url = site_url('admin/workshopgallery');
                if($this->request->getPost('page')!=NULL){
                    $redirect_url .='?page='.$this->request->getPost('page');
                }
                return redirect()->to($redirect_url); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }
        $data['workshop_list'] = $this->my_model->getWorkshop(); 
        $data['meta_title']		= 'Edit Workshopgallery';
        $data['meta_desc']		= 'Edit Workshopgallery';
        $data['meta_keyword']	= 'Edit Workshopgallery';

        $data['page_heading']	    = 'Edit Workshopgallery';        
        return view($this->viewDirectory . '\edit_view', $data);
    }   

    public function add(){
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
               "name" => [
                    "label" => "name", 
                    "rules" => "required|min_length[3]|max_length[200]"
                ],
                "workshop_id" => [
                    "label" => "workshop", 
                    "rules" => "required"
                ],               
                "photo" => [
                    "label" => "Photo", 
                    "rules" => "uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/gif,image/png,image/webp]"
                ]
            ];
            
            
           if ($this->validate($rules)) {

                /** Image Upload */                
                $img = $this->request->getFile('photo');
                $newName = '';
                if ($img->isValid() && ! $img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move(FCPATH . 'uploads/workshopgallery/', $newName);
                }
                /** End Image Upload */
               

               $display_order = $this->my_model->getDisplayOrder()+1; 
               $postdata = [
                    "name" => $this->request->getPost("name"),
                    "workshop_id" => $this->request->getPost("workshop_id"),
                    "disp_order" => $display_order,
                    "photo" => $newName,
                    "status" => 1,
                    "created_at" => $this->current_date_time
                ];
                $this->my_model->addRecord($postdata);                
                $this->session->setFlashData("success", "Record has been added successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                return redirect()->to(site_url('admin/workshopgallery')); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['workshop_list'] = $this->my_model->getWorkshop(); 
        $meta_title = "Add Workshop Gallery"; 
        $data['meta_title']		= $meta_title;
        $data['meta_desc']		= $meta_title;
        $data['meta_keyword']	= $meta_title;

        $data['page_heading']	    = $meta_title;        
        return view($this->viewDirectory . '\add_view', $data);
    }

    public function delete(){
        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $this->my_model->deleteRecord($id);                
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        
        //echo $this->request->getUserAgent()->getReferrer();die;
        return redirect()->to(site_url('admin/workshopgallery')); 
    }

    
   
}