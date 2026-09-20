<?php 
namespace Modules\Admin\Libraries;

class Adminauth
{

    public function isAdminLoggedIn()
    {
        
        if( session()->get('admin_logged_in') == NULL){            
           //return redirect()->to('admin');
           
           header("Location:".site_url('admin'));exit;
        }
    
    }

} 