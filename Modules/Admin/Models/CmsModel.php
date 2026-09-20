<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class CmsModel extends Model
{
    protected $db;
    protected $tbl_name;
    protected $tbl_cms_category;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tbl_name = 'tbl_pages';
        $this->tbl_cms_category = 'tbl_page_category';       

    }
    
    public function getCMSRecords($condition=[], $like_con_arr=[], $perPage=2){
       
        //print_r($condition);die;
        $pager = service('pager');
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        
        $offset = ($page-1) * $perPage;

        $builder = $this->db->table($this->tbl_name);
        $data = $builder
            ->where($condition)
            ->join('tbl_page_category','tbl_page_category.id=tbl_pages.page_category','left')
            ->like($like_con_arr)
            ->select('tbl_pages.*,tbl_page_category.cat_name')
            ->orderBy('tbl_pages.page_id', 'DESC')
            ->get($perPage,$offset)
            ->getResult();
       // $query = $this->db->getLastQuery();
        //echo (string) $query;  die;    

        $total = $builder->where($condition)->like($like_con_arr)->join('tbl_page_category','tbl_page_category.id=tbl_pages.page_category','left')->countAllResults();
        
        //$query = $this->db->getLastQuery();
        //echo (string) $query;  die;

        return [
            'data'=>$data,
            'links' => $pager->makeLinks($page,$perPage,$total,'admin_full')
        ];
    }

    public function getCMSSingleRecord($condition=''){
        
        $sql = "SELECT * FROM $this->tbl_name WHERE 1";
        if(!empty($condition)){
            $sql .=$condition;
        }
        
        $query = $this->db->query($sql);
        $rows = $query->getRow();
        return $rows;
    }

    public function updatePage($data,$id){
        
         return $this->db
                        ->table('tbl_pages')
                        ->where(["page_id" => $id])
                        ->set($data)
                        ->update();
    }
    
    /** for category */
    public function getCmsCategories($condition=[], $like_con_arr=[], $perPage=2){
       
        
        $pager = service('pager');
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        
        $offset = ($page-1) * $perPage;

        $builder = $this->db->table($this->tbl_cms_category);
        $data = $builder
            ->where($condition)
            ->like($like_con_arr)
            ->select('id,parent_id,cat_name,status,created_by_id,created_at')
            ->orderBy('id', 'DESC')
            ->get($perPage,$offset)
            ->getResult();
        //$query = $this->db->getLastQuery();
        //echo (string) $query;  die;    

        $total = $builder->where($condition)->like($like_con_arr)->countAllResults();
        
        //$query = $this->db->getLastQuery();
        //echo (string) $query;  die;

        return [
            'data'=>$data,
            'links' => $pager->makeLinks($page,$perPage,$total,'admin_full')
        ];
    }

    public function getCmsCategoriesForDropdown($condition=[]){
       
        $builder = $this->db->table($this->tbl_cms_category);
        $data = $builder
            ->where($condition)
            ->select('id,parent_id,cat_name')
            ->orderBy('cat_name', 'ASC')
            ->get()
            ->getResult();
        return $data;    

    }

    public function addPageCategory($data){
        
         return $this->db
                        ->table('tbl_page_category')
                        ->insert($data);

    }

    public function updatePageCategory($data,$id){
        
         return $this->db
                        ->table('tbl_page_category')
                        ->where(["id" => $id])
                        ->set($data)
                        ->update();

    }

    public function updatePageCategoryStatus($section,$arr_ids){
        $status_id = '';
        if($section=='enable'){
            $status_id=1;
        }elseif($section=='disable'){
            $status_id=0;
        }elseif($section=='delete'){
            $status_id=2;
        }
        
        if($status_id !='' && is_array($arr_ids) && count($arr_ids)>0){
        
            foreach($arr_ids as $k=>$v){
                $data=['status'=>$status_id];
                
                $this->db
                        ->table('tbl_page_category')
                        ->where(["id" => $v])
                        ->set($data)
                        ->update();
            }
        }
    }

    public function getPageCategory($id){
       
         return $this->db
                        ->table('tbl_page_category')
                        ->where(["id" => $id])
                        ->get()
                        ->getRow();
    }

    public function deletePageCategory($cat_id){
        return $this->db
                    ->table('tbl_page_category')
                    ->where('id',$cat_id)
                    ->delete();
    }



   

}