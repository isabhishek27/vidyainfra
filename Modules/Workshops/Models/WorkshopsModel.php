<?php

namespace Modules\Workshops\Models;

use CodeIgniter\Model;

class WorkshopsModel extends Model
{
    protected $db;
    protected $tbl_name;

    public function __construct(){

        $this->db = \Config\Database::connect();
        $this->tbl_name="`tbl_workshop`";

    }
   
    public function getRecords($select_flds='*', $condition='',$limit=''){
        
        $sql = "SELECT $select_flds FROM $this->tbl_name WHERE 1 AND `status` = 1 ";
        if(!empty($condition)){
            $sql .=$condition;
        }
        $sql .=" ORDER BY `name` ASC";

				if((int)$limit>0){
            $sql .=" LIMIT $limit";
        }
        
        $query = $this->db->query($sql);
        $rows = $query->getResult();

        // $query = $this->db->getLastQuery();
        //echo (string) $query;  die;   
        
        return $rows;
    }
    
    /*
     public function getSingleRecord($url_slug){
       
         return $this->db
                        ->table($this->tbl_name)->join("tbl_photographar","tbl_photographar.id=tbl_workshop.photographar_id")
												->select("tbl_workshop.*, tbl_photographar.name as photographar_name,tbl_photographar.photo as photographar_photo,tbl_photographar.about")
                        ->where(["tbl_workshop.url_slug" => $url_slug,"tbl_workshop.status"=>1])
                        ->get()
                        ->getRow();
    }*/

    public function getSingleRecord($url_slug)
    {
        // Get the workshop
        $row = $this->db
            ->table($this->tbl_name)
            ->select("tbl_workshop.*")
            ->where([
                "tbl_workshop.url_slug" => $url_slug,
                "tbl_workshop.status"   => 1
            ])
            ->get()
            ->getRow();

        if ($row && !empty($row->photographar_id)) {
            $ids = explode(',', $row->photographar_id);

            $photographers = $this->db->table("tbl_photographar")
                ->whereIn("id", $ids)
                ->select("id, name, photo as photographar_photo, about")
                ->get()
                ->getResult();

            $row->photographers = $photographers;
        } else {
            $row->photographers = [];
        }

        return $row;
    }
                    

		public function getRecordById($id,$select='*'){
       
         return $this->db
                        ->table($this->tbl_name)
												->select($select)
                        ->where(["tbl_workshop.id" => $id,"tbl_workshop.status"=>1])
                        ->get()
                        ->getRow();
    }

		 public function getGallery($select_flds='*', $condition=''){
        
        $sql = "SELECT $select_flds FROM `tbl_workshop_gallery` WHERE 1 AND `status` = 1 ";
        if(!empty($condition)){
            $sql .=$condition;
        }
        $sql .=" ORDER BY `id` DESC";
        
        $query = $this->db->query($sql);
        $rows = $query->getResult();
        
        return $rows;
    }

		public function getTokens($token,$select='*'){
       
         return $this->db
                        ->table("tbl_orders")
												->select($select)
                        ->where(["tbl_orders.token_no" => $token])
                        ->get()
                        ->getRow();
    }

		public function getOrderData($tbl_name,$cond, $select='*'){
       
         return $this->db
                        ->table($tbl_name)
												->select($select)
                        ->where($cond)
                        ->get()
                        ->getRow();
    }

		public function getCountries(){

        $builder = $this->db->table('tbl_country');
        $condition = "status=1";
        $data = $builder
            ->where($condition)            
            ->select('id,country_name')
            ->orderBy('country_name', 'ASC')
            ->get()
            ->getResult();

        return $data;    
    }

		public function addRecord($data, $tbl_name){
        
        $this->db->table($tbl_name)->insert($data);
        $insertedId = $this->db->insertID();                
        return $insertedId;

    }

    public function updateRecord($data, $tbl_name, $id){
        
         return $this->db
                        ->table($tbl_name)
                        ->where(["id" => $id])
                        ->set($data)
                        ->update();

    }

    public function reduceWorkshopSpots($tbl_name,$order_id){

      $workshop_id = $this->db
                        ->table('tbl_orders_dtl')
												->select('product_id')
                        ->where(["tbl_orders_dtl.order_id" => $order_id])
                        ->get()
                        ->getRow()->product_id;

      $builder = $this->db->table($tbl_name); 
      $builder->set('total_booked_seat', 'total_booked_seat + 1', FALSE);      
      $builder->where('id', $workshop_id);
      $builder->update(); 

      $builder = $this->db->table($tbl_name); 
      $builder->set('total_available_seat', 'total_seat - total_booked_seat', FALSE);      
      $builder->where('id', $workshop_id);
      $builder->update(); 

    }

    public function updateCouponUsage($tbl_name,$order_id){
      
       $coupon_id = $this->db
                        ->table('tbl_orders')
												->select('coupon_id')
                        ->where(["tbl_orders.id" => $order_id])
                        ->get()
                        ->getRow()->coupon_id;

      $builder = $this->db->table($tbl_name); 
      $builder->set('usage_count', 'usage_count + 1', FALSE);      
      $builder->where('id', $coupon_id);
      $builder->update(); 

    }

    public function getCouponInfo($coupon_code){
      
      $curr_date = date('Y-m-d');

      $builder = $this->db->table('tbl_coupons');
      $condition = "tbl_coupons.status='1' AND tbl_coupons.coupon_code='".$coupon_code."' AND tbl_coupons.start_date <='".$curr_date."' AND tbl_coupons.end_date >='".$curr_date."'";
      $data = $builder
            ->where($condition)            
            ->select('*')
            ->get()
            ->getRow();
        //$query = $this->db->getLastQuery();
        //echo (string) $query;  die;   
        return $data;                      
    }

    public function addNotify($data){       
        return $this->db
                        ->table('tbl_notify')                        
                        ->insert($data);
    }

    public function getNotify($where,$select='*'){
       
         return $this->db
                        ->table("tbl_notify")
												->select($select)
                        ->where($where)
                        ->get()
                        ->getRow();
    }
}