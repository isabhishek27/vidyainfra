<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BaseController;
use Modules\Admin\Models\LoginModel;

// use Config\Email;
use Config\Services;

class Admin extends BaseController {
    
    protected $viewDirectory;
    protected $my_model;

    protected $helpers = ['form'];

    public function __construct(){

        // start session
		$this->session = Services::session();
        
        $uri = current_url(true); 
        $module_name = ucfirst($uri->getSegment(1));

        $this->viewDirectory = 'Modules/'. $module_name.'/Views';
        $this->my_model = new LoginModel();
    }

    public function login() {
         
        //return redirect()->to('');
        if (session()->get('admin_logged_in')){
			return redirect()->to('admin/dashboard');
		}        
        $cookies = ['user_name'=>((cookies()->has('user_name'))?cookies()->get('user_name')->getValue():''), 'user_password'=>((cookies()->has('user_password'))?cookies()->get('user_password')->getValue():'')];
        
        $data['meta_title']		= 'Login';
        $data['remember'] = $cookies;        

        if($this->request->is('post')){
            
            // validate request
            $rules = [
                'user_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Please enter username'
                    ]
                ],
                'user_password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Please enter password'
                    ]
                ]
            ];

            $data = $this->request->getPost();
            $data['meta_title']		= 'Login';
            $data['remember'] = $cookies;

            if (! $this->validateData($data, $rules)) {

                return view($this->viewDirectory . '\dashboard\login', $data);
            }

            $cond =" AND `user_status` = 1 AND `user_role`!=3 AND `user_name`='".$this->request->getpost('user_name')."' AND `user_password`='".md5($this->request->getpost('user_password'))."' " ;
            
            $this->my_model->check_admin_login( $cond );
            
            if (session()->get('admin_logged_in')) 
            {
                
                if($this->request->getpost('remember')){
                    Services::response()->setCookie('user_name', $this->request->getpost('user_name'), 100800, site_url()); //7 days
                    Services::response()->setCookie('user_password', $this->request->getpost('user_name'), 100800, site_url()); //7 days
                }else{
                    Services::response()->deleteCookie('user_name');
                    Services::response()->deleteCookie('user_password');
                }                
                
                return redirect()->to('admin/dashboard')->withCookies();
            }else{
                return redirect()->to('admin')->withCookies();
            }
            
        }

        
		return view($this->viewDirectory . '\dashboard\login', $data);
    }

    public function logout(){

        if( session()->get('admin_logged_in') ){
            $sess_arr = array(
                'user_name' => 0,
                'user_role' => 0,
                'admin_id' 	=> 0,
                'admin_name'=> 0,
                'admin_logged_in' => 0
            );

            session()->set($sess_arr);
            session()->destroy();
        }
        return redirect()->to('admin')->withCookies();
    }

}