<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $db;
    protected $tbl_name;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tbl_name = 'tbl_products';
    }

    public function getRecord($condition=[], $like_con_arr=[], $perPage=2){

        $pager = service('pager');
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page-1) * $perPage;

        $builder = $this->db->table($this->tbl_name);
        $data = $builder
            ->where($condition)
            ->like($like_con_arr)
            ->select('tbl_products.*')
            ->orderBy('tbl_products.disp_order', 'ASC')
            ->orderBy('tbl_products.id', 'DESC')
            ->get($perPage,$offset)
            ->getResult();

        $total = $builder->where($condition)->like($like_con_arr)->countAllResults();

        return [
            'data'=>$data,
            'links' => $pager->makeLinks($page,$perPage,$total,'admin_full')
        ];
    }

    public function addRecord($data){
         $this->db->table($this->tbl_name)->insert($data);
         return $this->db->insertID();
    }

    public function updateRecord($data,$id){
         return $this->db->table($this->tbl_name)->where(["id" => $id])->set($data)->update();
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

        if($status_id !=='' && is_array($arr_ids) && count($arr_ids)>0){
            foreach($arr_ids as $v){
                $this->db->table($this->tbl_name)->where(["id" => $v])->set(['status'=>$status_id])->update();
            }
        }
    }

    public function updateFeatured($section, $arr_ids){
        $featured = null;
        if($section === 'set_featured'){
            $featured = 1;
        }elseif($section === 'unset_featured'){
            $featured = 0;
        }

        if($featured !== null && is_array($arr_ids) && count($arr_ids) > 0){
            foreach($arr_ids as $v){
                $this->db->table($this->tbl_name)->where(["id" => $v])->set(['is_featured' => $featured])->update();
            }
        }
    }

    public function getSingleRecord($id){
         return $this->db->table($this->tbl_name)->where(["id" => $id])->get()->getRow();
    }

    public function deleteRecord($id){
        $gallery = $this->getGalleryByProduct($id);
        foreach($gallery as $g){
            $this->deleteGalleryImage((int)$g->id, (int)$id);
        }
        $row = $this->getSingleRecord($id);
        if(is_object($row) && !empty($row->photo)){
            $path = FCPATH . 'uploads/products/'.$row->photo;
            if(is_file($path)){
                unlink($path);
            }
        }
        return $this->db->table($this->tbl_name)->where('id',$id)->delete();
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

    public function updateDisplayOrder($orders = []){
        if(!is_array($orders) || count($orders) === 0){
            return false;
        }
        foreach($orders as $id => $order){
            $id = (int)$id;
            $order = (int)$order;
            if($id > 0){
                $this->db->table($this->tbl_name)->where(['id' => $id])->set(['disp_order' => $order])->update();
            }
        }
        return true;
    }

    public function getGalleryByProduct($product_id){
        return $this->db
            ->table('tbl_products_gallery')
            ->where(['product_id' => (int)$product_id, 'status' => 1])
            ->orderBy('disp_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResult();
    }

    public function countProductPhotos($product_id){
        $row = $this->getSingleRecord($product_id);
        $count = (is_object($row) && !empty($row->photo)) ? 1 : 0;
        $count += $this->db
            ->table('tbl_products_gallery')
            ->where(['product_id' => (int)$product_id, 'status' => 1])
            ->countAllResults();
        return $count;
    }

    public function addGalleryImage($data){
        return $this->db->table('tbl_products_gallery')->insert($data);
    }

    public function deleteGalleryImage($id, $product_id = null){
        $builder = $this->db->table('tbl_products_gallery')->where(['id' => (int)$id]);
        if($product_id !== null){
            $builder->where(['product_id' => (int)$product_id]);
        }
        $row = $builder->get()->getRow();
        if(!is_object($row)){
            return false;
        }
        if(!empty($row->photo)){
            $path = FCPATH . 'uploads/productsgallery/'.$row->photo;
            if(is_file($path)){
                unlink($path);
            }
        }
        return $this->db->table('tbl_products_gallery')->where(['id' => (int)$id])->delete();
    }

    public function getNextGalleryOrder($product_id){
        $row = $this->db
            ->table('tbl_products_gallery')
            ->selectMax('disp_order', 'max_disp_order')
            ->where(['product_id' => (int)$product_id, 'status' => 1])
            ->get()
            ->getRow();
        return (!empty($row) && $row->max_disp_order !== null) ? ((int)$row->max_disp_order + 1) : 1;
    }
}
