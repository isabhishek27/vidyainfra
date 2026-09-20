<?php

namespace Modules\Testimonials\Models;

use CodeIgniter\Model;

class TestimonialsModel extends Model
{
    protected $db;
    protected $tbl_name;

    public function __construct(){

        $this->db = \Config\Database::connect();
        $this->tbl_name="`tbl_testimonials`";

    }
   
    public function getRecords($select_flds='*', $condition='', $limit=''){
        
        $sql = "SELECT $select_flds FROM $this->tbl_name WHERE 1 AND `status` = 1 ";
        if(!empty($condition)){
            $sql .=$condition;
        }
        $sql .=" ORDER BY `id` DESC";
        if((int)$limit>0){
            $sql .=" LIMIT $limit";
        }
        
        $query = $this->db->query($sql);
        $rows = $query->getResult();
        
        return $rows;
    }

    public function getData($flds="*", $cond=[]){

        $builder = $this->db->table($this->tbl_name);
        $builder->select($flds);
        $query = $builder->getWhere($cond);
        return $query;
        //$query = $builder->getWhere(['id' => $id], $limit, $offset);
        //$query   = $builder->get();
        //$query = $builder->get(10, 20);
        //$sql = $builder->getCompiledSelect();
        //echo $sql;
    }
    
    public function addTesimonial($data){       
        return $this->db
                        ->table($this->tbl_name)                        
                        ->insert($data);
    }
    
}