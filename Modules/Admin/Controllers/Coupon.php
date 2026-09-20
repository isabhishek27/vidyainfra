<?php
namespace Modules\Admin\Controllers;

use CodeIgniter\Files\File;
use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;

use Config\Services;
use Modules\Admin\Models\CouponModel;

class Coupon extends BackendController {

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

        $this->my_model = new CouponModel();
        
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

        $data['meta_title']		= 'Coupons';
        $data['meta_desc']		= 'Coupons';
        $data['meta_keyword']	= 'Coupons';        

        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){

            $this->my_model->updateStatus($action_type,$arr_ids);
            $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            return redirect()->to(site_url('admin/coupon')); 
            
        }

        $keyword = '';
        $status = '';

        $like_cond =[];
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['tbl_coupons.coupon_code'] =  $keyword = $this->request->getVar('keyword');            
            //$like_cond['tbl_coupons.coupon_title'] =  $keyword;
        }
        $cond['tbl_coupons.status !='] = 3;

        if($this->request->getVar('status')!=NULL){
            $cond['tbl_coupons.status'] =  $status = $this->request->getVar('status');
        }        
        $data['keyword'] = $keyword;
        $data['status']  = $status;
        
        $per_page = config('MyApplication')->admin_per_page;
        
        
        $results = $this->my_model->getRecord($cond,$like_cond,$per_page); 
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];
        

        $data['page_heading']	    = 'Coupons';        
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
            return redirect()->to(site_url('admin/coupon')); 
         }

        
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
                 
                "id" => [
                    "label" => "Id", 
                    "rules" => "max_length[19]|is_natural_no_zero"
                ], 
                "coupon_title" => [
                   "label" => "coupon name", 
                   "rules" => "required|min_length[3]|max_length[100]"
                ],
                "coupon_code" => [
                    "label" => "coupon code", 
                    "rules" => "required|min_length[3]|max_length[20]|is_unique[tbl_coupons.coupon_code,tbl_coupons.id,{id} ]"
                ],
                "coupon_type" => [
                    "label" => "coupon type", 
                   "rules" => "required|numeric|greater_than[0]"
                ],                                
                "coupon_discount" => [
                    "label" => "coupon discount", 
                    "rules" => "required|numeric|decimal|greater_than[0]"
                ],
                "start_date" => [
                    "label" => "start date", 
                    "rules" => "required"
                ],
                "end_date" => [
                    "label" => "end date", 
                    "rules" => "required"
                ]
            ];
            
           // echo '-----'.$this->validate($rules);die;
           if ($this->validate($rules)) {

                $postdata = [                   
                    "coupon_title" => $this->request->getPost("coupon_title"),
                    "coupon_code" => url_title($this->request->getPost("coupon_code"),'-',true),
                    "coupon_type" => $this->request->getPost("coupon_type"),
                    "coupon_discount" => $this->request->getPost("coupon_discount"),
                    "start_date" => $this->request->getPost("start_date"),
                    "end_date" => $this->request->getPost("end_date")
                ];							
							

                $this->my_model->updateRecord($postdata,$row->id);                
                $this->session->setFlashData("success", "Record has been updated successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                $redirect_url = site_url('admin/coupon');
                if($this->request->getPost('page')!=NULL){
                    $redirect_url .='?page='.$this->request->getPost('page');
                }
                return redirect()->to($redirect_url); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }        

        $data['meta_title']		= 'Edit Coupon';
        $data['meta_desc']		= 'Edit Coupon';
        $data['meta_keyword']	= 'Edit Coupon';

        $data['page_heading']	    = 'Edit Coupon';        
        return view($this->viewDirectory . '\edit_view', $data);
    }   

    public function add(){
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [      
								"coupon_title" => [
                   "label" => "coupon name", 
                   "rules" => "required|min_length[3]|max_length[100]"
                ],
                "coupon_code" => [
                    "label" => "coupon code", 
                    "rules" => "required|min_length[3]|max_length[20]|is_unique[tbl_coupons.coupon_code]"
                ],
                "coupon_type" => [
                    "label" => "coupon type", 
                   "rules" => "required|numeric|greater_than[0]"
                ],                                
                "coupon_discount" => [
                    "label" => "coupon discount", 
                    "rules" => "required|numeric|decimal|greater_than[0]"
                ],
                "start_date" => [
                    "label" => "start date", 
                    "rules" => "required"
                ],
                "end_date" => [
                    "label" => "end date", 
                    "rules" => "required"
                ]								
            ];
            
            
           if ($this->validate($rules)) {               
              
							$postdata = [                   
									"coupon_title" => $this->request->getPost("coupon_title"),
									"coupon_code" => $this->request->getPost("coupon_code"),
									"coupon_type" => $this->request->getPost("coupon_type"),
									"coupon_discount" => $this->request->getPost("coupon_discount"),
									"start_date" => $this->request->getPost("start_date"),
									"end_date" => $this->request->getPost("end_date"),
									"status" => 1,
									"created_at" => $this->current_date_time
							];	
							$this->my_model->addRecord($postdata);                
							$this->session->setFlashData("success", "Record has been added successfully.");
							
							//echo $this->request->getUserAgent()->getReferrer();die;
							return redirect()->to(site_url('admin/coupon')); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['meta_title']		= 'Add Coupon';
        $data['meta_desc']		= 'Add Coupon';
        $data['meta_keyword']	= 'Add Coupon';        

        $data['page_heading']	    = 'Add Coupon';        
        return view($this->viewDirectory . '\add_view', $data);
    }

    public function delete(){
        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $this->my_model->deleteRecord($id);                
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        
        //echo $this->request->getUserAgent()->getReferrer();die;
        return redirect()->to(site_url('admin/coupon')); 
    }

    
   
}