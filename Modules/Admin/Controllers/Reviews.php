<?php
namespace Modules\Admin\Controllers;

use CodeIgniter\Files\File;
use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;

use Config\Services;
use Modules\Admin\Models\ReviewsModel;

class Reviews extends BackendController {

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

        $this->my_model = new ReviewsModel();
        
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

        $data['meta_title']		= 'Reviews';
        $data['meta_desc']		= 'Reviews';
        $data['meta_keyword']	= 'Reviews';        

        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){

            $this->my_model->updateStatus($action_type,$arr_ids);
            $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            return redirect()->to(site_url('admin/reviews')); 
            
        }

        $keyword = '';
        $status = '';
        $like_cond =[];
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['tbl_testimonials.name'] =  $keyword = $this->request->getVar('keyword');           
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
        

        $data['page_heading']	    = 'Reviews';        
        return view($this->viewDirectory . '\reviews_list_view', $data);
        
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
            return redirect()->to(site_url('admin/reviews')); 
         }

        
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
                 
                "id" => [
                    "label" => "Review Id", 
                    "rules" => "max_length[19]|is_natural_no_zero"
                ], 
                "name" => [
                    "label" => "name", 
                    "rules" => "required|min_length[3]|max_length[200]"
                ],
                "email" => [
                    "label" => "Email", 
                    "rules" => "required|min_length[3]|max_length[200]|valid_email"
                ],
                "testimonial_rating" => [
                    "label" => "Rating", 
                    "rules" => "required"
                ],                
                "testimonial" => [
                    "label" => "Testimonial", 
                    "rules" => "required|min_length[3]|max_length[2000]"
                ]
            ];
            
           // echo '-----'.$this->validate($rules);die;
           if ($this->validate($rules)) {

                $postdata = [
                    "name" => $this->request->getPost("name"),
                    "email" => $this->request->getPost("email"),
                    "testimonial_rating" => $this->request->getPost("testimonial_rating"),                    
                    "testimonial" => $this->request->getPost("testimonial")
                ];
               

                $this->my_model->updateRecord($postdata,$row->id);                
                $this->session->setFlashData("success", "Record has been updated successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                $redirect_url = site_url('admin/reviews');
                if($this->request->getPost('page')!=NULL){
                    $redirect_url .='?page='.$this->request->getPost('page');
                }
                return redirect()->to($redirect_url); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['meta_title']		= 'Edit Reviews';
        $data['meta_desc']		= 'Edit Reviews';
        $data['meta_keyword']	= 'Edit Reviews';

        $data['page_heading']	    = 'Edit Reviews';        
        return view($this->viewDirectory . '\reviews_edit_view', $data);
    }   

    public function add(){
        
        $data['testimonial_rating'] = $this->request->getPost('testimonial_rating');
        if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
               "name" => [
                    "label" => "name", 
                    "rules" => "required|min_length[3]|max_length[200]"
                ],
                "email" => [
                    "label" => "Email", 
                    "rules" => "required|min_length[3]|max_length[200]|valid_email"
                ],
                "testimonial_rating" => [
                    "label" => "Rating", 
                    "rules" => "required"
                ],                
                "testimonial" => [
                    "label" => "Testimonial", 
                    "rules" => "required|min_length[3]|max_length[2000]"
                ]
            ];
            
            
           if ($this->validate($rules)) {               
              
               $postdata = [
                    "name" => $this->request->getPost("name"),
                    "email" => $this->request->getPost("email"),
                    "testimonial_rating" => $this->request->getPost("testimonial_rating"),
                    "testimonial" => $this->request->getPost("testimonial"),
                    "testimonial_by" => $this->login_admin_id,
                    "status" => 1,
                    "created_at" => $this->current_date_time
                ];
                $this->my_model->addRecord($postdata);                
                $this->session->setFlashData("success", "Record has been added successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                return redirect()->to(site_url('admin/reviews')); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['meta_title']		= 'Add Reviews';
        $data['meta_desc']		= 'Add Reviews';
        $data['meta_keyword']	= 'Add Reviews';

        $data['page_heading']	    = 'Add Reviews';        
        return view($this->viewDirectory . '\reviews_add_view', $data);
    }

    public function delete(){
        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $this->my_model->deleteRecord($id);                
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        
        //echo $this->request->getUserAgent()->getReferrer();die;
        return redirect()->to(site_url('admin/reviews')); 
    }

    
   
}