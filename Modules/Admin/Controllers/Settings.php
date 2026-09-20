<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;

use Config\Services;
use Modules\Admin\Models\SettingsModel;

class Settings extends BackendController {

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

        $this->my_model = new SettingsModel();
        
        $uri = current_url(true); 
        $module_name = ucfirst($uri->getSegment(1));
        $module_view_folder = ucfirst($uri->getSegment(2));

        $this->viewDirectory = 'Modules/'. $module_name.'/Views/'.$module_view_folder;
       
    }    
    
    public function index(){

        $uri = current_url(true); 
        $user_id =1;

        $row = $this->my_model->getSingleRecord(" AND id='".$user_id."'");        
        $data['row'] = $row;       

         if(!is_object($row)){

            $this->session->setFlashData("error", "Invalid Id.");
            return redirect()->to(site_url('admin/settings')); 
         }

        
        
         if ($this->request->is('post')) {

            $validation = service('validation');
            $request    = service('request');


            $rules = [
                 
                "id" => [
                    "label" => "Id", 
                    "rules" => "max_length[19]|is_natural_no_zero"
                ],                           
                "comp_name" => [
                    "label" => "Company name", 
                    "rules" => "required|max_length[200]"
                ],                
                "user_email" => [
                    "label" => "Email address", 
                    "rules" => "required|min_length[3]|max_length[200]"
                ],
                "user_email2" => [
                    "label" => "Email address2", 
                    "rules" => "max_length[200]"
                ],
                "user_email3" => [
                    "label" => "Email address3", 
                    "rules" => "max_length[200]"
                ],
                "phone1" => [
                    "label" => "Phone1", 
                    "rules" => "max_length[20]"
                ],
                "phone2" => [
                    "label" => "Phone2", 
                    "rules" => "max_length[20]"
                ],
                "address" => [
                    "label" => "Address", 
                    "rules" => "max_length[500]"
                ],
                "twitter_link" => [
                    "label" => "X url", 
                    "rules" => "max_length[200]"
                ],
                "fb_link" => [
                    "label" => "Facebook url", 
                    "rules" => "max_length[200]"
                ],
                "linkedin_link" => [
                    "label" => "Linkedin url", 
                    "rules" => "max_length[200]"
                ],
                "gplus_link" => [
                    "label" => "Google plus url", 
                    "rules" => "max_length[200]"
                ],
                "instagram_link" => [
                    "label" => "Instagram url", 
                    "rules" => "max_length[200]"
                ]
            ];
            
           // echo '-----'.$this->validate($rules);die;
           if ($this->validate($rules)) {

                $postdata = [
                    "comp_name" => $this->request->getPost("comp_name"),
                    "user_email" => $this->request->getPost("user_email"),
                    "user_email2" => $this->request->getPost("user_email2"),
                    "user_email3" => $this->request->getPost("user_email3"),
                    "phone1" => $this->request->getPost("phone1"),
                    "phone2" => $this->request->getPost("phone2"),
                    "address" => $this->request->getPost("address"),
                    "twitter_link" => $this->request->getPost("twitter_link"),
                    "fb_link" => $this->request->getPost("fb_link"),
                    "linkedin_link" => $this->request->getPost("linkedin_link"),
                    "gplus_link" => $this->request->getPost("gplus_link"),
                    "instagram_link" => $this->request->getPost("instagram_link")
                ];
                $this->my_model->updateData($postdata,$row->id);                
                $this->session->setFlashData("success", "Records has been updated successfully.");
                
                //echo $this->request->getUserAgent()->getReferrer();die;
                $redirect_url = site_url('admin/settings');
                return redirect()->to($redirect_url); 
            }else{

                $data["validation"] = $validation->getErrors();
                //echo '<pre>'; print_r( $validation->getErrors());die;

            }
    
         }

        $data['meta_title']		= 'Edit Settings';
        $data['meta_desc']		= 'Edit Settings';
        $data['meta_keyword']	= 'Edit Settings';

        $data['page_heading']	    = 'Edit Profile Settings';        
        return view($this->viewDirectory . '\edit_settings_views', $data);
    }
    
   
}