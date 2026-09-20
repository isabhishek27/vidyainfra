<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class OrdersModel extends Model
{
    protected $db;
    protected $tbl_name;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tbl_name = 'tbl_orders';

    }
    
    public function getRecords($condition=[], $like_con_arr=[], $perPage=2){
       
        //print_r($condition);die;
        $pager = service('pager');
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        
        $offset = ($page-1) * $perPage;

        $builder = $this->db->table($this->tbl_name)->join('tbl_orders_dtl','tbl_orders_dtl.order_id=tbl_orders.id')->join('tbl_workshop','tbl_workshop.id=tbl_orders_dtl.product_id')->join('tbl_country','tbl_orders.bill_country=tbl_country.id');
        $data = $builder
            ->where($condition)            
            ->like($like_con_arr)
            ->select('tbl_orders.*, tbl_orders_dtl.workshop_location, tbl_orders_dtl.workshop_date,tbl_workshop.name as workshop_name, tbl_country.country_name')
            ->orderBy('tbl_orders.id', 'DESC')
            ->groupBy('tbl_orders.id')
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

    public function getSingleRecord($condition=''){
        
        $sql = "SELECT tbl_orders.*, tbl_orders_dtl.workshop_location, tbl_orders_dtl.workshop_date,tbl_workshop.name as workshop_name, tbl_country.country_name FROM $this->tbl_name INNER JOIN tbl_orders_dtl ON tbl_orders.id=tbl_orders_dtl.order_id INNER JOIN tbl_workshop ON tbl_workshop.id= tbl_orders_dtl.product_id INNER JOIN tbl_country ON tbl_orders.bill_country=tbl_country.id WHERE 1";
        if(!empty($condition)){
            $sql .=$condition;
        }
        
        $query = $this->db->query($sql);
        $rows = $query->getRow();
        return $rows;
    }
    public function deleteRecord($id){
        if(is_array($id) && count($id)>0){
            foreach($id as $k=>$v){
               $this->db
                    ->table($this->tbl_name)
                    ->where('id',$v)
                    ->delete(); 
            }
            return true;

        }else{
        return $this->db
                    ->table($this->tbl_name)
                    ->where('id',$id)
                    ->delete();
        }
    }

    public function cancleOrder($id){
        $data=['order_status'=>3];
                    
        $this->db
                ->table($this->tbl_name)
                ->where(["id" => $id])
                ->set($data)
                ->update();

        $order_info = $this->db
                ->table('tbl_orders_dtl')
                ->where(["order_id" => $id])
                ->get()
                ->getRow();  

        $workshop_id = $order_info->product_id; 
        
        $builder = $this->db->table("tbl_workshop"); 
        $builder->set('total_booked_seat', 'total_booked_seat - 1', FALSE);      
        $builder->where('id', $workshop_id);
        $builder->update(); 

        $builder = $this->db->table("tbl_workshop"); 
        $builder->set('total_available_seat', 'total_seat - total_booked_seat', FALSE);      
        $builder->where('id', $workshop_id);
        $builder->update();
    }
   

}