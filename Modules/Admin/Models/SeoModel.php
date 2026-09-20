<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class SeoModel extends Model
{
    protected $db;
    protected $tbl_name;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tbl_name = 'tbl_seo';

    }        
    
    public function getRecord($condition=[], $like_con_arr=[], $perPage=2){
       
        
        $pager = service('pager');
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        
        $offset = ($page-1) * $perPage;

        $builder = $this->db->table($this->tbl_name);
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

    public function addRecord($data){
        
         return $this->db
                        ->table($this->tbl_name)
                        ->insert($data);

    }

    public function updateRecord($data,$id){
        
         return $this->db
                        ->table($this->tbl_name)
                        ->where(["id" => $id])
                        ->set($data)
                        ->update();

    }

    public function updateStatus($section,$arr_ids){
        $status_id = '';
        if($section=='approve'){
            $status_id=1;
        }elseif($section=='disapprove'){
            $status_id=2;
        }elseif($section=='delete'){
            $status_id=3;
        }
        
        if($status_id !='' && is_array($arr_ids) && count($arr_ids)>0){
        
            foreach($arr_ids as $k=>$v){

                if($status_id == 3){
                     return $this->db
                    ->table($this->tbl_name)
                    ->where('id',$v)
                    ->delete();
                }else{

                    $data=['status'=>$status_id];
                    
                    $this->db
                            ->table($this->tbl_name)
                            ->where(["id" => $v])
                            ->set($data)
                            ->update();
                }
            }
        }
    }

    public function getSingleRecord($id){
       
         return $this->db
                        ->table($this->tbl_name)
                        ->where(["id" => $id])
                        ->get()
                        ->getRow();
    }

    public function deleteRecord($id){
        return $this->db
                    ->table($this->tbl_name)
                    ->where('id',$id)
                    ->delete();
    }   

}