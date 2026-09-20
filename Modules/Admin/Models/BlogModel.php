<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $db;
    protected $tbl_name;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->post_tbl_name = 'tbl_posts';
        $this->post_cat_tbl_name = 'tbl_blog_category';

    }        
    
    public function getCatRecord($condition=[], $like_con_arr=[], $perPage=2){
       
        
        $pager = service('pager');
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        
        $offset = ($page-1) * $perPage;

        $builder = $this->db->table($this->post_cat_tbl_name);
        $data = $builder
            ->where($condition)
            ->like($like_con_arr)
            ->select('*')
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

    public function addCatRecord($data){
        
         return $this->db
                        ->table($this->post_cat_tbl_name)
                        ->insert($data);

    }

    public function updateCatRecord($data,$id){
        
         return $this->db
                        ->table($this->post_cat_tbl_name)
                        ->where(["id" => $id])
                        ->set($data)
                        ->update();

    }

    public function updateCatStatus($section,$arr_ids){
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
                if($status_id==2){
                    $data=['is_deleted'=>$status_id];
                }
                
                $this->db
                        ->table($this->post_cat_tbl_name)
                        ->where(["id" => $v])
                        ->set($data)
                        ->update();
            }
        }
    }

    public function getCatSingleRecord($id){
       
         return $this->db
                        ->table($this->post_cat_tbl_name)
                        ->where(["id" => $id])
                        ->get()
                        ->getRow();
    }

    public function deleteCatRecord($id){
        return $this->db
                    ->table($this->post_cat_tbl_name)
                    ->where('id',$id)
                    ->delete();
    }

   /** Article related functions */

    public function getPostRecord($condition=[], $like_con_arr=[], $perPage=2){
       
        
        $pager = service('pager');
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        
        $offset = ($page-1) * $perPage;

        $builder = $this->db->table($this->post_tbl_name);
        $data = $builder
            ->where($condition)
            ->join('tbl_blog_category','tbl_blog_category.id=tbl_posts.b_cat_id','left')
            ->like($like_con_arr)
            ->select('tbl_posts.*,tbl_blog_category.b_title as cat_name')
            ->orderBy('tbl_posts.id', 'DESC')
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

    public function addPostRecord($data){
        
         return $this->db
                        ->table($this->post_tbl_name)
                        ->insert($data);

    }

    public function updatePostRecord($data,$id){
        
         return $this->db
                        ->table($this->post_tbl_name)
                        ->where(["id" => $id])
                        ->set($data)
                        ->update();

    }

    public function updatePostStatus($section,$arr_ids){
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

                if($status_id==2){

                     return $this->db
                        ->table($this->post_tbl_name)
                        ->where('id',$v)
                        ->delete();
                        
                }else{
                
                    $this->db
                            ->table($this->post_tbl_name)
                            ->where(["id" => $v])
                            ->set($data)
                            ->update();
                }
            }
        }
    }

    public function getPostSingleRecord($id){
       
         return $this->db
                        ->table($this->post_tbl_name)
                        ->where(["id" => $id])
                        ->get()
                        ->getRow();
    }

    public function deletePostRecord($id){
        return $this->db
                    ->table($this->post_tbl_name)
                    ->where('id',$id)
                    ->delete();
    }

    public function getBlogCategoriesForDropdown($condition=[]){
       
        $builder = $this->db->table($this->post_cat_tbl_name);
        $data = $builder
            ->where($condition)
            ->select('id,b_title')
            ->orderBy('b_title', 'ASC')
            ->get()
            ->getResult();
        return $data;    

    }
   

}