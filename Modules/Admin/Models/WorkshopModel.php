<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class WorkshopModel extends Model
{
    protected $db;
    protected $tbl_name;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tbl_name = 'tbl_workshop';

    }        
    
    public function getRecord($condition=[], $like_con_arr=[], $perPage=2){
       
        
        $pager = service('pager');
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        
        $offset = ($page-1) * $perPage;

        $builder = $this->db->table($this->tbl_name);
        $data = $builder
            ->where($condition)
            ->like($like_con_arr)
            ->select('tbl_workshop.*')
            ->orderBy('tbl_workshop.id', 'DESC')
            ->get($perPage,$offset)
            ->getResult();
        //$query = $this->db->getLastQuery();
        //echo (string) $query;  die;    

        $total = $builder->where($condition)->like($like_con_arr)->countAllResults();
        
        //$query = $this->db->getLastQuery();
        //echo (string) $query;  die;

        // Attach photographer names manually
        if(is_array($data) && count($data) > 0){
            foreach ($data as &$row) {
                if (!empty($row->photographar_id)) {
                    $ids = explode(',', $row->photographar_id);
                    $photographers = $this->db->table('tbl_photographar')
                        ->whereIn('id', $ids)
                        ->select('name')
                        ->get()
                        ->getResultArray();
                    $row->photographar_name = implode(', ', array_column($photographers, 'name'));
                } else {
                    $row->photographar_name = '';
                }
            }
        }

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
                        ->table($this->tbl_name)
                        ->where(["id" => $v])
                        ->set($data)
                        ->update();
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

    public function getDisplayOrder(){
        $disp_order = 1;
        $row = $this->db                            
                        ->table($this->tbl_name)
                        ->selectMax('disp_order','max_disp_order')
                        ->where(["status <>" => 2])
                        ->get()
                        ->getRow();
        
                        
        if(!empty($row)){
            $disp_order = $row->max_disp_order;
        }
        return $disp_order;                
    }

    public function getPhotographar(){

        $builder = $this->db->table('tbl_photographar');
        $condition = "status=1";
        $data = $builder
            ->where($condition)            
            ->select('id,name')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResult();

        return $data;    
    }

    /** Waiting List */

    public function getWaitingList($condition=[], $like_con_arr=[], $perPage=2){
       
        
        $pager = service('pager');
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        
        $offset = ($page-1) * $perPage;

        $builder = $this->db->table("tbl_notify")->join("tbl_workshop","tbl_notify.workshop_id=tbl_workshop.id");
        $data = $builder
            ->where($condition)
            ->like($like_con_arr)
            ->select('tbl_notify.*,tbl_workshop.name as workshop_name')
            ->orderBy('tbl_notify.id', 'DESC')
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

    public function deleteWaitingLists($arr_ids){
        
        
        if(is_array($arr_ids) && count($arr_ids)>0){
        
            foreach($arr_ids as $k=>$v){                
                
                return $this->db->table("tbl_notify")->where('id',$v)->delete();
                //$query = $this->db->getLastQuery();
                //echo (string) $query;  die;
            }
        }
    }
    public function deleteWaitingList($id){
        return $this->db
                    ->table("tbl_notify")
                    ->where('id',$id)
                    ->delete();
    }

    public function getNotifyUsers($condition){

        $builder = $this->db->table("tbl_notify")->join("tbl_workshop","tbl_notify.workshop_id=tbl_workshop.id");
        $data = $builder
            ->where($condition)            
            ->select('tbl_notify.name,tbl_notify.email,tbl_workshop.name as workshop_name,tbl_workshop.url_slug')
            ->get()
            ->getResult();

        return $data;   
    }

    public function updateWaitingList($data,$id){
        
         return $this->db
                        ->table("tbl_notify")
                        ->where(["id" => $id])
                        ->set($data)
                        ->update();

    }

   

}