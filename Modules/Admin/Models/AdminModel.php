<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $db;
    protected $table_name;
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->table_name = 'tbl_users'

    }
    public function getUserRecord($fields='*', $cond=''){

        $query = $this->db->query("SELECT $fields FROM $this->table_name WHERE `status`=1 ". $cond);
        $rows = $query->getResult();
        return $rows;
    }

    

}