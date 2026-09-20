<?php
namespace Modules\Admin\Controllers;

use CodeIgniter\Files\File;
use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;

use Config\Services;
use Modules\Admin\Models\SeoModel;

class Seo extends BackendController {

    protected $viewDirectory;
    protected $my_model;
    protected $helpers = ['form'];
    protected $login_admin_id;
    protected $current_date_time;
    protected $page_name_arr;

    public function __construct(){

        // start session
        $this->session = Services::session();

        $admin_auth = new Adminauth(); // loads and creates instance
        $admin_auth->isAdminLoggedIn();
        $this->login_admin_id = session()->get('admin_id');
        $this->current_date_time = date('Y-m-d H:i:s');

        $this->my_model = new SeoModel();
        
        $uri = current_url(true); 
        $module_name = ucfirst($uri->getSegment(1));
        $module_view_folder = ucfirst($uri->getSegment(2));

        $this->viewDirectory = 'Modules/'. $module_name.'/Views/'.$module_view_folder;
        //echo WRITEPATH;die;

        $this->page_name_arr = ['workshop'=>'Workshop','blog'=>'Blog','contact-us'=>'Contact Us'];
       
    }    
    
    public function index() {

        $pager = Services::pager();
        $data['pager'] =  $this->my_model->pager;
        
        $data['curr_paging'] = $this->request->getVar('page');

        $data['meta_title']		= 'SEO';
        $data['meta_desc']		= 'SEO';
        $data['meta_keyword']	= 'SEO';        

        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){

            $this->my_model->updateStatus($action_type,$arr_ids);
            $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            return redirect()->to(site_url('admin/seo')); 
            
        }

        $keyword = '';
        $status = '';
        $like_cond =[];
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['tbl_seo.page_name'] =  $keyword = $this->request->getVar('keyword');           
        }
        $cond['status !='] = 3;

        if($this->request->getVar('status')!=NULL){
            $cond['status'] =  $status = $this->request->getVar('status');
        }
        $data['keyword'] = $keyword;
        $data['status'] = $status;

        $per_page = config('MyApplication')->admin_per_page;
        
        
        $results = $this->my_model->getRecord($cond,$like_cond,$per_page); 
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];
        $data['page_name_arr'] = $this->page_name_arr;
        

        $data['page_heading']	    = 'Manage Meta';        
        return view($this->viewDirectory . '\seo_list_view', $data);
        
    }

    public function edit(){

        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $row = $this->my_model->getSingleRecord($id);
        //echo '<pre>';print_r($row);die;
        $data['row'] = $row;
        $data['curr_page'] = ($this->request->getVar('page')!=NULL)?$this->request->getVar('page'):'';
        $data['page_name_arr'] = $this->page_name_arr;

         if(!is_object($row)){

            $this->session->setFlashData("error", "Invalid Id.");
            return redirect()->to(site_url('admin/seo')); 
         }

        
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
                 
                "id" => [
                    "label" => "Id", 
                    "rules" => "max_length[19]|is_natural_no_zero"
                ], 
                "page_name" => [
                    "label" => "page name", 
                    "rules" => "required|min_length[3]|max_length[255]|is_unique[tbl_seo.page_name,tbl_seo.id,{id} ]"
                ],      
                "meta_title" => [
                    "label" => "meta title", 
                    "rules" => "required|min_length[3]|max_length[255]"
                ],      
                "meta_keyword" => [
                    "label" => "meta keyword", 
                    "rules" => "required|min_length[3]|max_length[255]"
                ],      
                "meta_desc" => [
                    "label" => "meta description", 
                    "rules" => "required|min_length[3]|max_length[255]"
                ]
            ];
            
           // echo '-----'.$this->validate($rules);die;
           if ($this->validate($rules)) {
                $slug = $this->request->getPost("page_name");
                $pg_name_arr = $this->page_name_arr;
                $page_name = $pg_name_arr[$slug];
                $postdata = [
                    "page_name" => $page_name,
                    "slug" => $slug,
                    "meta_title" => $this->request->getPost("meta_title"),
                    "meta_keyword" => $this->request->getPost("meta_keyword"),
                    "meta_desc" => $this->request->getPost("meta_desc")
                ];
               

                $this->my_model->updateRecord($postdata,$row->id);                
                $this->session->setFlashData("success", "Record has been updated successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                $redirect_url = site_url('admin/seo');
                if($this->request->getPost('page')!=NULL){
                    $redirect_url .='?page='.$this->request->getPost('page');
                }
                return redirect()->to($redirect_url); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['meta_title']		= 'Edit Meta';
        $data['meta_desc']		= 'Edit Meta';
        $data['meta_keyword']	= 'Edit Meta';

        $data['page_heading']	    = 'Edit Meta';        
        return view($this->viewDirectory . '\seo_edit_view', $data);
    }   

    public function add(){        
        
        if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');

            $rules = [
               "page_name" => [
                    "label" => "page name", 
                    "rules" => "required|min_length[3]|max_length[255]|is_unique[tbl_seo.page_name]"
                ],      
                "meta_title" => [
                    "label" => "meta title", 
                    "rules" => "required|min_length[3]|max_length[255]"
                ],      
                "meta_keyword" => [
                    "label" => "meta keyword", 
                    "rules" => "required|min_length[3]|max_length[255]"
                ],      
                "meta_desc" => [
                    "label" => "meta description", 
                    "rules" => "required|min_length[3]|max_length[255]"
                ]
            ];
            
            
           if ($this->validate($rules)) {               
              
               $slug = $this->request->getPost("page_name");
               $pg_name_arr = $this->page_name_arr;
               $page_name = $pg_name_arr[$slug];

               $postdata = [
                    "page_name" => $page_name,
                    "slug" => $slug,
                    "meta_title" => $this->request->getPost("meta_title"),
                    "meta_desc" => $this->request->getPost("meta_desc"),
                    "meta_keyword" => $this->request->getPost("meta_keyword"),
                    "status" => 1,
                    "created_at" => $this->current_date_time
                ];
                $this->my_model->addRecord($postdata);                
                $this->session->setFlashData("success", "Record has been added successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                return redirect()->to(site_url('admin/seo')); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;
            }    
         }

        $data['meta_title']		= 'Add Meta';
        $data['meta_desc']		= 'Add Meta';
        $data['meta_keyword']	= 'Add Meta';

        $data['page_name_arr'] = $this->page_name_arr;

        $data['page_heading']	    = 'Add Meta';        
        return view($this->viewDirectory . '\seo_add_view', $data);

    }

    public function delete(){

        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $this->my_model->deleteRecord($id);                
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        
        //echo $this->request->getUserAgent()->getReferrer();die;
        return redirect()->to(site_url('admin/seo')); 
    }
    
   
}