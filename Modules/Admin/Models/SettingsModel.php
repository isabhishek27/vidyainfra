<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $db;
    protected $tbl_name;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tbl_name = 'tbl_users';

    }
    
    public function getSingleRecord($condition=''){
        
        $sql = "SELECT * FROM $this->tbl_name WHERE 1";
        if(!empty($condition)){
            $sql .=$condition;
        }
        
        $query = $this->db->query($sql);
        $rows = $query->getRow();
        //print_r($rows);die;
        return $rows;
    }

    public function updateData($data,$id){
        
         return $this->db
                        ->table($this->tbl_name)
                        ->where(["id" => $id])
                        ->set($data)
                        ->update();
    }

}