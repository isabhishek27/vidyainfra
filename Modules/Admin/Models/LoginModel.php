<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $db;
    public function __construct(){
        $this->db = \Config\Database::connect();

    }
    public function getUserRecord($username='',$pass=''){

        $query = $this->db->query("SELECT * FROM `tbl_users` WHERE 1");
        $rows = $query->getResult();
        return $rows;
    }

    public function getSingleRecord($condition=''){
        
        $sql = "SELECT * FROM `tbl_users` WHERE `user_status`=1";
        if(!empty($condition)){
            $sql .=$condition;
        }
        
        $query = $this->db->query($sql);
        $rows = $query->getRow();
        return $rows;
    }

    public function check_admin_login($condition='')
    {
        $sql = "SELECT * FROM `tbl_users` WHERE 1";
        if(!empty($condition)){
            $sql .=$condition;
        }
        
        $query = $this->db->query($sql);
        $row = $query->getRow();

        if (is_object($row))
        {
                        
            $sess_arr = array(
                            'user_name' => $row->user_name,
                            'user_role' => $row->user_role,
                            'admin_id' 	=> $row->id,
                            'admin_name'=> $row->firstname,
                            'admin_logged_in' => TRUE
                        );
    
            session()->set($sess_arr);
        }
        else
        {
            session()->setFlashdata('error', 'Invalid username/password');
            
            return redirect()->withCookies('admin');
        }
    
    }

}