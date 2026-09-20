<?php

namespace Modules\Products\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    protected $db;
    protected $tbl_name;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tbl_name = 'tbl_products';
    }

    public function getRecords($select_flds='*', $condition='', $limit=''){
        $sql = "SELECT $select_flds FROM `$this->tbl_name` WHERE 1 AND `status` = 1 ";
        if(!empty($condition)){
            $sql .= $condition;
        }
        $sql .= " ORDER BY `disp_order` ASC, `id` DESC";
        if((int)$limit > 0){
            $sql .= " LIMIT ".(int)$limit;
        }
        return $this->db->query($sql)->getResult();
    }

    public function getSingleRecord($url_slug){
        return $this->db
            ->table($this->tbl_name)
            ->where(['url_slug' => $url_slug, 'status' => 1])
            ->get()
            ->getRow();
    }

    public function getGallery($product_id){
        return $this->db
            ->table('tbl_products_gallery')
            ->where(['product_id' => $product_id, 'status' => 1])
            ->orderBy('disp_order', 'ASC')
            ->get()
            ->getResult();
    }

    public function attachGalleries($products){
        if(empty($products) || !is_array($products)){
            return $products;
        }

        $ids = [];
        foreach($products as $p){
            if(isset($p->id)){
                $ids[] = (int)$p->id;
            }
        }
        $ids = array_values(array_unique(array_filter($ids)));

        $gallery_map = [];
        if(count($ids) > 0){
            $rows = $this->db
                ->table('tbl_products_gallery')
                ->whereIn('product_id', $ids)
                ->where('status', 1)
                ->orderBy('disp_order', 'ASC')
                ->orderBy('id', 'ASC')
                ->get()
                ->getResult();
            foreach($rows as $row){
                $gallery_map[(int)$row->product_id][] = $row;
            }
        }

        foreach($products as $p){
            $images = [];
            if(!empty($p->photo) && is_file(FCPATH . 'uploads/products/' . $p->photo)){
                $images[] = site_url('public/uploads/products/' . $p->photo);
            }
            $gid = isset($p->id) ? (int)$p->id : 0;
            if(!empty($gallery_map[$gid])){
                foreach($gallery_map[$gid] as $g){
                    if(!empty($g->photo) && is_file(FCPATH . 'uploads/productsgallery/' . $g->photo)){
                        $images[] = site_url('public/uploads/productsgallery/' . $g->photo);
                    }
                }
            }
            if(empty($images)){
                $images[] = 'https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=900&q=80';
            }
            $p->images = $images;
        }

        return $products;
    }
}
