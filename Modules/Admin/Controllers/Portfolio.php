<?php
namespace Modules\Admin\Controllers;

use CodeIgniter\Files\File;
use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;

use Config\Services;
use Modules\Admin\Models\PortfolioModel;

class Portfolio extends BackendController {

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

        $this->my_model = new PortfolioModel();
        
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

        $data['meta_title']		= 'Portfolio';
        $data['meta_desc']		= 'Portfolio';
        $data['meta_keyword']	= 'Portfolio';        

        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){

            $this->my_model->updateStatus($action_type,$arr_ids);
            $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            return redirect()->to(site_url('admin/portfolio')); 
            
        }

        $keyword = '';
        $status = '';
        $like_cond =[];
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['tbl_portfolio.title'] =  $keyword = $this->request->getVar('keyword');           
        }
        $cond['status !='] = 2;

        if($this->request->getVar('status')!=NULL){
            $cond['status'] =  $status = $this->request->getVar('status');
        }
        $data['keyword'] = $keyword;
        $data['status'] = $status;

        $per_page = config('MyApplication')->admin_per_page;
        
        
        $results = $this->my_model->getRecord($cond,$like_cond,$per_page); 
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];
        

        $data['page_heading']	    = 'Portfolio';        
        return view($this->viewDirectory . '\portfolio_list_view', $data);
        
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
            return redirect()->to(site_url('admin/portfolio')); 
         }

        
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
                 
                "id" => [
                    "label" => "Portfolio Id", 
                    "rules" => "max_length[19]|is_natural_no_zero"
                ], 
                "title" => [
                    "label" => "Portfolio title", 
                    "rules" => "required|min_length[3]|max_length[200]"
                ],
                "tags" => [
                    "label" => "Portfolio tags", 
                    "rules" => "required|min_length[3]|max_length[200]"
                ],
                "country" => [
                    "label" => "Portfolio country", 
                    "rules" => "required|min_length[3]|max_length[200]"
                ],                
                "description" => [
                    "label" => "Description", 
                    "rules" => "required|min_length[3]|max_length[2000]"
                ]
            ];
            
           // echo '-----'.$this->validate($rules);die;
           if ($this->validate($rules)) {

                $postdata = [
                    "title" => $this->request->getPost("title"),
                    "tags" => $this->request->getPost("tags"),
                    "country_name" => $this->request->getPost("country"),
                    "description" => $this->request->getPost("description")
                ];

                /** Image Upload */                
                $img = $this->request->getFile('portfolio_image');
                
                if ($img->isValid() && ! $img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move(FCPATH . 'uploads/portfolio/', $newName);

                    $postdata['portfolio_image'] = $newName;

                    /** Unlink old image */
                    $old_img = $row->portfolio_image;
                    $old_img_path = FCPATH . 'uploads/portfolio/'.$old_img;
                    if(is_file($old_img_path)){
                        unlink($old_img_path);
                    }
                }
                /** End Image Upload */

                $this->my_model->updateRecord($postdata,$row->id);                
                $this->session->setFlashData("success", "Record has been updated successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                $redirect_url = site_url('admin/portfolio');
                if($this->request->getPost('page')!=NULL){
                    $redirect_url .='?page='.$this->request->getPost('page');
                }
                return redirect()->to($redirect_url); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['meta_title']		= 'Edit Portfolio';
        $data['meta_desc']		= 'Edit Portfolio';
        $data['meta_keyword']	= 'Edit Portfolio';

        $data['page_heading']	    = 'Edit Portfolio';        
        return view($this->viewDirectory . '\portfolio_edit_view', $data);
    }   

    public function add(){
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
               "title" => [
                    "label" => "Portfolio title", 
                    "rules" => "required|min_length[3]|max_length[200]"
                ],
                "tags" => [
                    "label" => "Portfolio tags", 
                    "rules" => "required|min_length[3]|max_length[200]"
                ],
                "country" => [
                    "label" => "Portfolio country", 
                    "rules" => "required|min_length[3]|max_length[200]"
                ],
                "portfolio_image" => [
                    "label" => "Portfolio image", 
                    "rules" => "uploaded[portfolio_image]|is_image[portfolio_image]|mime_in[portfolio_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]"
                ],                                
                "description" => [
                    "label" => "Description", 
                    "rules" => "required|min_length[3]|max_length[2000]"
                ]
            ];
            
            
           if ($this->validate($rules)) {

                /** Image Upload */                
                $img = $this->request->getFile('portfolio_image');
                $newName = '';
                if ($img->isValid() && ! $img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move(FCPATH . 'uploads/portfolio/', $newName);
                }
                /** End Image Upload */
               

               $display_order = $this->my_model->getDisplayOrder()+1; 
               $postdata = [
                    "title" => $this->request->getPost("title"),
                    "tags" => $this->request->getPost("tags"),
                    "country_name" => $this->request->getPost("country"),
                    "description" => $this->request->getPost("description"),
                    "disp_order" => $display_order,
                    "added_by" => $this->login_admin_id,
                    "portfolio_image" => $newName,
                    "status" => 1,
                    "created_at" => $this->current_date_time
                ];
                $this->my_model->addRecord($postdata);                
                $this->session->setFlashData("success", "Record has been added successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                return redirect()->to(site_url('admin/portfolio')); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['meta_title']		= 'Add Portfolio';
        $data['meta_desc']		= 'Add Portfolio';
        $data['meta_keyword']	= 'Add Portfolio';

        $data['page_heading']	    = 'Add Portfolio';        
        return view($this->viewDirectory . '\portfolio_add_view', $data);
    }

    public function delete(){
        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $this->my_model->deleteRecord($id);                
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        
        //echo $this->request->getUserAgent()->getReferrer();die;
        return redirect()->to(site_url('admin/portfolio')); 
    }

    
   
}