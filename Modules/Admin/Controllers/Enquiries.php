<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;

use Config\Services;
use Modules\Admin\Models\EnquiriesModel;

class Enquiries extends BackendController {

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

        $this->my_model = new EnquiriesModel();
        
        $uri = current_url(true); 
        $module_name = ucfirst($uri->getSegment(1));
        $module_view_folder = ucfirst($uri->getSegment(2));

        $this->viewDirectory = 'Modules/'. $module_name.'/Views/'.$module_view_folder;
       
    }    
    
    public function index() {
        return $this->listEnquiries('contact');
    }

    public function interest() {
        return $this->listEnquiries('interest');
    }

    private function listEnquiries($enquiry_type = 'contact') {

        $pager = Services::pager();
        $data['pager'] =  $this->my_model->pager;
        
        $data['curr_paging'] = $this->request->getVar('page');

        $is_interest = ($enquiry_type === 'interest');
        $page_heading = $is_interest ? 'Interested Enquire' : 'Contact Us Enquiry';
        $list_url = $is_interest ? 'admin/enquiries/interest' : 'admin/enquiries';

        $data['meta_title']		= $page_heading;
        $data['meta_desc']		= $page_heading;
        $data['meta_keyword']	= $page_heading;
        $data['enquiry_type']   = $enquiry_type;
        $data['list_url']       = $list_url;
        $data['show_vehicle']   = $is_interest;

        $keyword = '';
        $like_cond =[];
        $cond =[];
        $reply_status = '';
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['first_name'] =  $keyword = $this->request->getVar('keyword');           
        }
        
        $cond['enquiry_type'] = $enquiry_type;

        if($this->request->getVar('reply_status')!=NULL){
            $cond['reply_status'] =  $reply_status = $this->request->getVar('reply_status');
        }
        $data['keyword'] = $keyword;
        $data['reply_status'] = $reply_status;
        
        $per_page = config('MyApplication')->admin_per_page;
        
        
        $results = $this->my_model->getRecords($cond,$like_cond,$per_page); 
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];
        
        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){

            $this->my_model->deleteEnquiries($arr_ids);
            $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            return redirect()->to(site_url($list_url)); 
            
        }

        $data['page_heading']	    = $page_heading;        
        return view($this->viewDirectory . '\enquiries_views', $data);
        
    }   

    public function enquiries_details(){
        
        if ($this->request->isAJAX()) {
            $id = (int) $this->request->getPost('id');
            

            $return_data=['status'=>0,'data'=>'','msg'=>'Errors! Something went wrong.'];
            $cond = " AND id='".$id."'";
            $data = $this->my_model->getSingleRecord($cond);
           
            if(!empty($data)){
                $return_data=['status'=>1,'data'=>$data,'msg'=>'record fetched.'];   
            }

            
            $return_data = json_encode($return_data);
            echo $return_data;

            
        }
    }
    public function enquiries_delete($id = null){
        $uri = current_url(true); 
        $id = (int)($id !== null ? $id : $uri->getSegment(4));
        
        $row = $this->my_model->getSingleRecord(" AND id='".$id."'");
        $redirect = site_url('admin/enquiries');
        if (is_object($row) && isset($row->enquiry_type) && $row->enquiry_type === 'interest') {
            $redirect = site_url('admin/enquiries/interest');
        }

        $this->my_model->deleteRecord($id);                
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        
        return redirect()->to($redirect); 
    }

    /** Request a quote */
    public function requestquote() {

        $pager = Services::pager();
        $data['pager'] =  $this->my_model->pager;
        
        $data['curr_paging'] = $this->request->getVar('page');

        $data['meta_title']		= 'Request a Quote';
        $data['meta_desc']		= 'Request a Quote';
        $data['meta_keyword']	= 'Request a Quote';

        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){

            $this->my_model->deleteRequestQuotes($arr_ids);
            $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            return redirect()->to(site_url('admin/enquiries/requestquote')); 
            
        }

        $cond['id !='] = 2;

        $keyword = '';
        $status = '';
        $like_cond =[];
        $cond =[];
        $reply_status = '';
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['first_name'] =  $keyword = $this->request->getVar('keyword');           
        }
        
        $cond['id !='] = 0;

        if($this->request->getVar('reply_status')!=NULL){
            $cond['reply_status'] =  $reply_status = $this->request->getVar('reply_status');
        }
        $data['keyword'] = $keyword;
        $data['reply_status'] = $reply_status;
        
        
        $per_page = config('MyApplication')->admin_per_page;
       
        $per_page = config('MyApplication')->admin_per_page;
        
        $results = $this->my_model->getRequestQuote($cond,$like_cond,$per_page); 
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];

        $data['page_heading']	    = 'Request a Quote Enquiries';        
        return view($this->viewDirectory . '\request_quote_views', $data);
        
    }
    
    public function requestquote_details(){
        
        if ($this->request->isAJAX()) {
            $id = (int) $this->request->getPost('id');
            

            $return_data=['status'=>0,'data'=>'','msg'=>'Errors! Something went wrong.'];
            $cond = " AND id='".$id."'";
            $data = $this->my_model->getRequestQuoteSingleRecord($cond);
           
            if(!empty($data)){
                $return_data=['status'=>1,'data'=>$data,'msg'=>'record fetched.'];   
            }

            
            $return_data = json_encode($return_data);
            echo $return_data;

            
        }
    }

    public function requestquote_delete(){
        $uri = current_url(true); 
        $cat_id = (int)($uri->getSegment(4));
        
        $this->my_model->deleteRequestQuote($cat_id);                
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        
        //echo $this->request->getUserAgent()->getReferrer();die;
        return redirect()->to(site_url('admin/enquiries/requestquote')); 
    }

    
   
}