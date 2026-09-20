<?php
namespace Modules\Admin\Controllers;

use CodeIgniter\Files\File;
use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;

use Config\Services;
use Modules\Admin\Models\NewsletterModel;

class Newsletter extends BackendController {

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

        $this->my_model = new NewsletterModel();
        
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

        $data['meta_title']		= 'Newsletter';
        $data['meta_desc']		= 'Newsletter';
        $data['meta_keyword']	= 'Newsletter';        

        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){

            $this->my_model->updateStatus($action_type,$arr_ids);
            $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            return redirect()->to(site_url('admin/newsletter')); 
            
        }

        $keyword = '';
        $is_subscribed = '';
        $like_cond =[];
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['tbl_newsletter.name'] =  $keyword = $this->request->getVar('keyword');
            //$like_cond['tbl_newsletter.email'] =  $keyword = $this->request->getVar('keyword');           
        }
        $cond['id !='] = 0;

        if($this->request->getVar('is_subscribed')!=NULL){
            $cond['is_subscribed'] =  $is_subscribed = $this->request->getVar('is_subscribed');
        }
        $data['keyword'] = $keyword;
        $data['status'] = $is_subscribed;

        $per_page = config('MyApplication')->admin_per_page;
        
        
        $results = $this->my_model->getRecord($cond,$like_cond,$per_page); 
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];
        

        $data['page_heading']	    = 'Newsletter';        
        return view($this->viewDirectory . '\newsletter_view', $data);
        
    }    

    public function delete(){
        $uri = current_url(true); 
        $id = (int)($uri->getSegment(4));
        
        $this->my_model->deleteRecord($id);                
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        
        //echo $this->request->getUserAgent()->getReferrer();die;
        return redirect()->to(site_url('admin/newsletter')); 
    }

    
   
}