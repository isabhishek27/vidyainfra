<?php
namespace Modules\Admin\Controllers;

use CodeIgniter\Files\File;
use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;

use Config\Services;
use Modules\Admin\Models\BlogModel;

class Blog extends BackendController {

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

        $this->my_model = new BlogModel();
        
        $uri = current_url(true); 
        $module_name = ucfirst($uri->getSegment(1));
        $module_view_folder = ucfirst($uri->getSegment(2));

        $this->viewDirectory = 'Modules/'. $module_name.'/Views/'.$module_view_folder;
        //echo WRITEPATH;die;
       
    }
    
    public function index(){
        $redirect_url = site_url('admin/blog/post');
        return redirect()->to($redirect_url); 
    }
    
    public function category() {

        $pager = Services::pager();
        $data['pager'] =  $this->my_model->pager;
        
        $data['curr_paging'] = $this->request->getVar('page');

        $data['meta_title']		= 'Blog Category';
        $data['meta_desc']		= 'Blog Category';
        $data['meta_keyword']	= 'Blog Category';        

        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){

            $this->my_model->updateCatStatus($action_type,$arr_ids);
            $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            return redirect()->to(site_url('admin/blog/category')); 
            
        }

        $keyword = '';
        $status = '';
        $like_cond =[];
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['tbl_blog_category.b_title'] =  $keyword = $this->request->getVar('keyword');           
        }
        $cond['is_deleted !='] = 2;

        if($this->request->getVar('status')!=NULL){
            $cond['status'] =  $status = $this->request->getVar('status');
        }
        $data['keyword'] = $keyword;
        $data['status'] = $status;

        $per_page = config('MyApplication')->admin_per_page;
        
        
        $results = $this->my_model->getCatRecord($cond,$like_cond,$per_page); 
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];
        

        $data['page_heading']	    = 'Blog Category';        
        return view($this->viewDirectory . '\blog_cat_list_view', $data);
        
    }

    public function category_edit(){

        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $row = $this->my_model->getCatSingleRecord($id);
        //echo '<pre>';print_r($row);die;
        $data['row'] = $row;
        $data['curr_page'] = ($this->request->getVar('page')!=NULL)?$this->request->getVar('page'):'';

         if(!is_object($row)){

            $this->session->setFlashData("error", "Invalid Id.");
            return redirect()->to(site_url('admin/blog/category')); 
         }

        
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
                 
                "id" => [
                    "label" => "Category Id", 
                    "rules" => "max_length[19]|is_natural_no_zero"
                ], 
                "b_title" => [
                    "label" => "Category name", 
                    "rules" => "required|min_length[3]|max_length[200]|is_unique[tbl_blog_category.b_title,tbl_blog_category.id,{id} ]"
                ],
                 "b_image" => [
                    "label" => "category image", 
                    "rules" => "is_image[b_image]|mime_in[b_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]"
                ],
            ];
            
           // echo '-----'.$this->validate($rules);die;
           if ($this->validate($rules)) {

                $postdata = [
                    "b_title" => $this->request->getPost("b_title"),
                    "b_slug" => url_title($this->request->getPost("b_title")),                   
                ];

                /** Image Upload */                
                $img = $this->request->getFile('b_image');
                
                if ($img->isValid() && ! $img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move(FCPATH . 'uploads/blog/', $newName);

                    $postdata['b_image'] = $newName;

                    /** Unlink old image */
                    $old_img = $row->b_image;
                    $old_img_path = FCPATH . 'uploads/blog/'.$old_img;
                    if(is_file($old_img_path)){
                        unlink($old_img_path);
                    }
                }
                /** End Image Upload */

                $this->my_model->updateCatRecord($postdata,$row->id);                
                $this->session->setFlashData("success", "Record has been updated successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                $redirect_url = site_url('admin/blog/category');
                if($this->request->getPost('page')!=NULL){
                    $redirect_url .='?page='.$this->request->getPost('page');
                }
                return redirect()->to($redirect_url); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['meta_title']		= 'Edit Category';
        $data['meta_desc']		= 'Edit Category';
        $data['meta_keyword']	= 'Edit Category';

        $data['page_heading']	    = 'Edit Category';        
        return view($this->viewDirectory . '\blog_cat_edit_view', $data);
    }   

    public function category_add(){
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
               "b_title" => [
                    "label" => "Cateogry name", 
                    "rules" => "required|min_length[3]|max_length[200]|is_unique[tbl_posts.b_title]"
                ],               
                "b_image" => [
                    "label" => "Category image", 
                    "rules" => "uploaded[b_image]|is_image[b_image]|mime_in[b_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]"
                ]
            ];
            
            
           if ($this->validate($rules)) {

                /** Image Upload */                
                $img = $this->request->getFile('b_image');
                $newName = '';
                if ($img->isValid() && ! $img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move(FCPATH . 'uploads/blog/', $newName);
                }
                /** End Image Upload */
               
               $postdata = [
                    "b_title" => $this->request->getPost("b_title"),
                    "b_slug" => url_title($this->request->getPost("b_title")),
                    //"added_by" => $this->login_admin_id,                    
                    "b_image" => $newName,                   
                    "status" => 1,
                    "created_at" => $this->current_date_time
                ];
                $this->my_model->addCatRecord($postdata);                
                $this->session->setFlashData("success", "Record has been added successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                return redirect()->to(site_url('admin/blog/category')); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['meta_title']		= 'Add Category';
        $data['meta_desc']		= 'Add Category';
        $data['meta_keyword']	= 'Add Category';

        $data['page_heading']	    = 'Add Category';        
        return view($this->viewDirectory . '\blog_cat_add_view', $data);
    }

    public function category_delete(){
        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $this->my_model->deleteCatRecord($id);                
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        
        //echo $this->request->getUserAgent()->getReferrer();die;
        return redirect()->to(site_url('admin/blog/category')); 
    }

    /** Articles related functions */

    public function post() {

        $pager = Services::pager();
        $data['pager'] =  $this->my_model->pager;
        
        $data['curr_paging'] = $this->request->getVar('page');

        $data['meta_title']		= 'Blog Post';
        $data['meta_desc']		= 'Blog Post';
        $data['meta_keyword']	= 'Blog Post';        

        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){

            $this->my_model->updatePostStatus($action_type,$arr_ids);
            $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            return redirect()->to(site_url('admin/blog/post')); 
            
        }

        $keyword = '';
        $status = '';
        $category_id = '';     
        $like_cond =[];
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['tbl_posts.b_title'] =  $keyword = $this->request->getVar('keyword');           
        }
        if($this->request->getVar('category_id')!=NULL){
            
            $cond['tbl_posts.b_cat_id'] =  $category_id = $this->request->getVar('category_id');           
        }

        $cond['tbl_posts.is_deleted !='] = 2;

        if($this->request->getVar('status')!=NULL){
            $cond['status'] =  $status = $this->request->getVar('status');
        }
        $data['keyword'] = $keyword;
        $data['status'] = $status;
        $data['category_id'] = $category_id;

        $per_page = config('MyApplication')->admin_per_page;
        
        
        $results = $this->my_model->getPostRecord($cond,$like_cond,$per_page); 
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];

        $data['categories'] = $this->my_model->getBlogCategoriesForDropdown(['status !='=>2]);
        

        $data['page_heading']	    = 'Blog Post';        
        return view($this->viewDirectory . '\blog_post_list_view', $data);
        
    }

    public function post_edit(){

        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $row = $this->my_model->getPostSingleRecord($id);
        //echo '<pre>';print_r($row);die;
        $data['row'] = $row;
        $data['curr_page'] = ($this->request->getVar('page')!=NULL)?$this->request->getVar('page'):'';

         if(!is_object($row)){

            $this->session->setFlashData("error", "Invalid Id.");
            return redirect()->to(site_url('admin/blog/post')); 
         }

        
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
                 
                "id" => [
                    "label" => "Post Id", 
                    "rules" => "max_length[19]|is_natural_no_zero"
                ],                 
                "b_title" => [
                    "label" => "Post title", 
                    "rules" => "required|min_length[3]|max_length[200]|is_unique[tbl_posts.b_title,tbl_posts.id,{id} ]"
                ],
                "b_image" => [
                    "label" => "Post image", 
                    "rules" => "is_image[b_image]|mime_in[b_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]"
                ],
                "b_content" => [
                    "label" => "Post content", 
                    "rules" => "required"
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
                    "b_title" => $this->request->getPost("b_title"),
                    "b_slug" => url_title($this->request->getPost("b_title"),'-',true),
                    "b_content" => $this->request->getPost("b_content"),
                    "meta_title" => $this->request->getPost("meta_title"),
                    "meta_desc" => $this->request->getPost("meta_desc"),
                    "meta_keyword" => $this->request->getPost("meta_keyword")
                ];

                /** Image Upload */                
                $img = $this->request->getFile('b_image');
                
                if ($img->isValid() && ! $img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move(FCPATH . 'uploads/blog/', $newName);

                    $postdata['b_image'] = $newName;

                    /** Unlink old image */
                    $old_img = $row->b_image;
                    $old_img_path = FCPATH . 'uploads/blog/'.$old_img;
                    if(is_file($old_img_path)){
                        unlink($old_img_path);
                    }
                }
                /** End Image Upload */

                

                $this->my_model->updatePostRecord($postdata,$row->id);                
                $this->session->setFlashData("success", "Record has been updated successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                $redirect_url = site_url('admin/blog/post');
                if($this->request->getPost('page')!=NULL){
                    $redirect_url .='?page='.$this->request->getPost('page');
                }
                return redirect()->to($redirect_url); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['meta_title']		= 'Edit Post';
        $data['meta_desc']		= 'Edit Post';
        $data['meta_keyword']	= 'Edit Post';
        $data['categories'] = $this->my_model->getBlogCategoriesForDropdown(['status !='=>2]);

        $data['page_heading']	    = 'Edit Post';        
        return view($this->viewDirectory . '\blog_post_edit_view', $data);
    }   

    public function post_add(){
       
        if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
               "b_title" => [
                    "label" => "Post title", 
                    "rules" => "required|min_length[3]|max_length[200]|is_unique[tbl_blog_category.b_title]"
               ],
               "b_image" => [
                    "label" => "Post image", 
                    "rules" => "uploaded[b_image]|is_image[b_image]|mime_in[b_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]"
               ],
               "b_content" => [
                    "label" => "Post content", 
                    "rules" => "required"
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
                $img = $this->request->getFile('b_image');
                $newName = '';
                if ($img->isValid() && ! $img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move(FCPATH . 'uploads/blog/', $newName);
                }
                /** End Image Upload */ 
               
              $postdata = [
								"b_title" => $this->request->getPost("b_title"),
								"b_slug" => url_title($this->request->getPost("b_title"),'-',true),
								"b_image" => $newName,
								"b_content" => $this->request->getPost("b_content"),
								"status" => 1,
								"created_at" => $this->current_date_time,
                                "meta_title" => $this->request->getPost("meta_title"),
                                "meta_desc" => $this->request->getPost("meta_desc"),
                                "meta_keyword" => $this->request->getPost("meta_keyword")
							];
                $this->my_model->addPostRecord($postdata);                
                $this->session->setFlashData("success", "Record has been added successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                return redirect()->to(site_url('admin/blog/post')); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }
        $b_cat_id = ($this->request->getPost("b_cat_id")!=NULL)?$this->request->getPost("b_cat_id"):''; 
        $data['b_cat_id'] = $b_cat_id;
        $data['categories'] = $this->my_model->getBlogCategoriesForDropdown(['status !='=>2]); 

        $data['meta_title']		= 'Add Post';
        $data['meta_desc']		= 'Add Post';
        $data['meta_keyword']	= 'Add Post';

        $data['page_heading']	    = 'Add Post';        
        return view($this->viewDirectory . '\blog_post_add_view', $data);
    }

    public function post_delete(){
        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $this->my_model->deletePostRecord($id);                
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        
        //echo $this->request->getUserAgent()->getReferrer();die;
        return redirect()->to(site_url('admin/blog/post')); 
    }

    public function post_details(){
        
        if ($this->request->isAJAX()) {
            $id = (int) $this->request->getPost('id');

            $return_data=['status'=>0,'data'=>'','msg'=>'Errors! Something went wrong.'];
           
            $data = $this->my_model->getPostSingleRecord($id);
            
            if(!empty($data)){
                $return_data=['status'=>1,'data'=>$data,'msg'=>'record fetched.'];   
            }

            
            $return_data = json_encode($return_data);
            echo $return_data;

            
        }
    }

   
}