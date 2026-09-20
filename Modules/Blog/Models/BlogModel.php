<?php

namespace Modules\Blog\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $db;
    protected $tbl_name;
    protected $post_tbl_name;

    public function __construct(){

        $this->db = \Config\Database::connect();
        $this->cat_tbl_name="`tbl_blog_category`";
        $this->post_tbl_name="`tbl_posts`";

    }
   
    public function getRecords($tbl_type='cat', $select_flds='*', $condition=''){
        $tname = ($tbl_type=='cat')?$this->cat_tbl_name:$this->post_tbl_name;
        $sql = "SELECT $select_flds FROM $tname WHERE 1 AND `status` = 1 AND `is_deleted` = 0";
        if(!empty($condition)){
            $sql .=$condition;
        }
        $sql .=" ORDER BY `id` DESC";
        
        $query = $this->db->query($sql);
        $rows = $query->getResult();
        
        return $rows;
    }

    public function getArticles($select_flds='*'){
        
        $sql = "SELECT $select_flds FROM $this->post_tbl_name AS a WHERE 1 AND a.`status` = 1 AND a.`is_deleted` = 0";
        
        $sql .=" ORDER BY a.`id` DESC";
        
        $query = $this->db->query($sql);
        $rows = $query->getResult();
        
        return $rows;
    }

    public function getSingleRecord($tbl_type='cat', $select_flds='*', $condition=''){
        $tname = ($tbl_type=='cat')?$this->cat_tbl_name:$this->post_tbl_name;
        $sql = "SELECT $select_flds FROM $tname WHERE 1 AND `is_deleted` = 0 AND `status` = 1 ";
        if(!empty($condition)){
            $sql .=$condition;
        }
        
        $query = $this->db->query($sql);
        $rows = $query->getRow();
        return $rows;
    }

}