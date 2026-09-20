<?php

namespace Modules\Portfolio\Models;

use CodeIgniter\Model;

class PortfolioModel extends Model
{
    protected $db;
    protected $tbl_name;

    public function __construct(){

        $this->db = \Config\Database::connect();
        $this->tbl_name="`tbl_portflio`";

    }

    public function getRecords($select_flds='*', $condition=''){
        
        $sql = "SELECT $select_flds FROM $this->tbl_name WHERE 1 AND `status` = 1 ";
        if(!empty($condition)){
            $sql .=$condition;
        }
        $sql .=" ORDER BY `disp_order` ASC";
        //echo $sql;die;
        
        $query = $this->db->query($sql);
        $rows = $query->getResult();
        
        return $rows;
    }
   
    public function getSingleRecord($select_flds='*', $condition=''){
        
        $sql = "SELECT $select_flds FROM $this->tbl_name WHERE 1 ";
        if(!empty($condition)){
            $sql .=$condition;
        }
        
        $query = $this->db->query($sql);
        $rows = $query->getRow();
        return $rows;
    }   
    

}