<?php
namespace Modules\Admin\Controllers;

use CodeIgniter\Files\File;
use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;

use Config\Services;
use Modules\Admin\Models\CmsModel;

class Cms extends BackendController {

    protected $viewDirectory;
    protected $my_model;
    protected $helpers = ['form'];
    protected $login_admin_id;

    public function __construct(){

        // start session
        $this->session = Services::session();

        $admin_auth = new Adminauth(); // loads and creates instance
        $admin_auth->isAdminLoggedIn();
        $this->login_admin_id = session()->get('admin_id');

        $this->my_model = new CmsModel();
        
        $uri = current_url(true); 
        $module_name = ucfirst($uri->getSegment(1));
        $module_view_folder = ucfirst($uri->getSegment(2));

        $this->viewDirectory = 'Modules/'. $module_name.'/Views/'.$module_view_folder;
       
    }    
    
    public function index() {

        $pager = Services::pager();
        $data['pager'] =  $this->my_model->pager;
        
        $data['curr_paging'] = $this->request->getVar('page');

        $data['meta_title']		= 'CMS Pages';
        $data['meta_desc']		= 'CMS Pages';
        $data['meta_keyword']	= 'CMS Pages';        

        

        $keyword = '';
        $category_id = '';        
        $like_cond =[];
        //$cond =[];
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['tbl_pages.page_title'] =  $keyword = $this->request->getVar('keyword');           
        }
        if($this->request->getVar('category_id')!=NULL){
            
            $cond['tbl_page_category.id'] =  $category_id = $this->request->getVar('category_id');           
        }
       $cond['tbl_pages.page_id !='] = 0;
        
        $data['keyword'] = $keyword; 
        $data['category_id'] = $category_id;      
        $per_page = config('MyApplication')->admin_per_page;
        
        
        $results = $this->my_model->getCMSRecords($cond,$like_cond,$per_page); 
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];

        $data['categories'] = $this->my_model->getCmsCategoriesForDropdown(['status !='=>2]);

        $data['page_heading']	    = 'CMS Pages';        
        return view($this->viewDirectory . '\cms_list_views', $data);
        
    }

    public function edit_page(){

        $uri = current_url(true); 
        $page_id = (int)($uri->getSegment(4));

        $row = $this->my_model->getCMSSingleRecord(" AND page_id='".$page_id."'");
        //echo '<pre>';print_r($row);die;
        $data['row'] = $row;        
        $data['curr_page'] = ($this->request->getVar('page')!=NULL)?$this->request->getVar('page'):'';

         if(!is_object($row)){

            $this->session->setFlashData("error", "Invalid Id.");
            return redirect()->to(site_url('admin/cms')); 
         }

        
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
                 
                "page_id" => [
                    "label" => "Page Id", 
                    "rules" => "max_length[19]|is_natural_no_zero"
                ],     
                "page_content" => [
                    "label" => "Page content", 
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
            
           // echo '-----'.$this->validate($rules);die;
           if ($this->validate($rules)) {

                $postdata = [                    
                    "page_content" => $this->request->getPost("page_content"),
                    "meta_title" => $this->request->getPost("meta_title"),
                    "meta_desc" => $this->request->getPost("meta_desc"),
                    "meta_keyword" => $this->request->getPost("meta_keyword")
                ];
                $this->my_model->updatePage($postdata,$row->page_id);                
                $this->session->setFlashData("success", "Page has been updated successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                $redirect_url = site_url('admin/cms');
                if($this->request->getPost('page')!=NULL){
                    $redirect_url .='?page='.$this->request->getPost('page');
                }
                return redirect()->to($redirect_url); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['meta_title']		= 'Edit CMS Page';
        $data['meta_desc']		= 'Edit CMS Page';
        $data['meta_keyword']	= 'Edit CMS Page';

        $data['page_heading']	    = 'Edit CMS Page';        
        return view($this->viewDirectory . '\edit_cms_page_views', $data);
    }

    public function page_details(){
        
        if ($this->request->isAJAX()) {
            $page_id = (int) $this->request->getPost('page_id');

            $return_data=['status'=>0,'data'=>'','msg'=>'Errors! Something went wrong.'];
            $cond = " AND page_id='".$page_id."'";
            $data = $this->my_model->getCMSSingleRecord($cond);
            
            if(!empty($data)){
                $return_data=['status'=>1,'data'=>$data,'msg'=>'record fetched.'];   
            }

            
            $return_data = json_encode($return_data);
            echo $return_data;

            
        }
    }
    
    public function tm_image_upload(){

        /** Image Upload */                
        $img = $this->request->getFile('file');
        
        if ($img->isValid() && ! $img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/cmspgimages/', $newName);
            
            $image_path = uploaded_image_url('cmspgimages/'.$newName);
            //echo json_encode(['location' => $image_path]);
        }
        /** End Image Upload */
    }
   
}