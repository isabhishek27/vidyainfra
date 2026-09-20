<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;

use Config\Services;
use Modules\Admin\Models\OrdersModel;

class Orders extends BackendController {

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

        $this->my_model = new OrdersModel();
        
        $uri = current_url(true); 
        $module_name = ucfirst($uri->getSegment(1));
        $module_view_folder = ucfirst($uri->getSegment(2));

        $this->viewDirectory = 'Modules/'. $module_name.'/Views/'.$module_view_folder;
       
    }    
    
    public function index() {

        $pager = Services::pager();
        $data['pager'] =  $this->my_model->pager;
        
        $data['curr_paging'] = $this->request->getVar('page');

        $data['meta_title']		= 'Orders';
        $data['meta_desc']		= 'Orders';
        $data['meta_keyword']	= 'Orders';        

        

        $keyword = '';
        $order_status = '';
        $from_date = '';
        $to_date = '';        
        $like_cond =[];
        $cond =[];
        
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['tbl_orders.id'] =  $keyword = $this->request->getVar('keyword');           
        }
        
        $cond['tbl_orders.id !='] = 0;

        if($this->request->getVar('order_status')!=NULL){
            $cond['tbl_orders.order_status'] =  $order_status = $this->request->getVar('order_status');
        }
        if($this->request->getVar('from_date')!=NULL){
            $cond['tbl_orders.created_at >='] =  $from_date = $this->request->getVar('from_date');
        }
        if($this->request->getVar('to_date')!=NULL){
            $cond['tbl_orders.created_at <='] =  $to_date = $this->request->getVar('to_date');
        }
        $data['keyword'] = $keyword;
        $data['order_status'] = $order_status;
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        
        $data['keyword'] = $keyword; 
        $per_page = config('MyApplication')->admin_per_page;
        
        
        $results = $this->my_model->getRecords($cond,$like_cond,$per_page); 
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];
        
        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){

            $this->my_model->deleteRecord($arr_ids);
            $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            return redirect()->to(site_url('admin/orders')); 
            
        }

        $data['page_heading']	    = 'All Orders';        
        return view($this->viewDirectory . '\list_views', $data);
        
    }   

    public function details(){
        
        if ($this->request->isAJAX()) {
            $id = (int) $this->request->getPost('id');
            

            $return_data=['status'=>0,'data'=>'','msg'=>'Errors! Something went wrong.'];
            $cond = " AND tbl_orders.id='".$id."'";
            $data = $this->my_model->getSingleRecord($cond);
           
            if(!empty($data)){
                $return_data=['status'=>1,'data'=>$data,'msg'=>'record fetched.'];   
            }

            
            $return_data = json_encode($return_data);
            echo $return_data;

            
        }
    }
    public function order_delete(){
        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $this->my_model->deleteRecord($id);                
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        
        //echo $this->request->getUserAgent()->getReferrer();die;
        return redirect()->to(site_url('admin/orders')); 
    }
    
    public function order_cancle(){
        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $this->my_model->cancleOrder($id);                
        $this->session->setFlashData("success", "Order has been cancled successfully.");
        
        //echo $this->request->getUserAgent()->getReferrer();die;
        return redirect()->to(site_url('admin/orders')); 
    }

    
   
}