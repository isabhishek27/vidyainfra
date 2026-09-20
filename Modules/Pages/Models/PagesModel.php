<?php

namespace Modules\Pages\Models;

use CodeIgniter\Model;

class PagesModel extends Model
{
    protected $db;
    protected $tbl_name;

    public function __construct(){

        $this->db = \Config\Database::connect();
        $this->tbl_name="`tbl_pages`";

    }
   
    public function getSingleRecord($select_flds='*', $condition=''){
        
        $sql = "SELECT $select_flds FROM $this->tbl_name WHERE 1 ";
        if(!empty($condition)){
            $sql .=$condition;
        }
        
        $query = $this->db->query($sql);
        $rows = $query->getRow();
        return $rows;
    }

    public function getBanners($select_flds='*', $condition=''){
        
        $sql = "SELECT $select_flds FROM `tbl_banners` WHERE 1 ";
        if(!empty($condition)){
            $sql .=$condition;
        }
        
        $query = $this->db->query($sql);
        $rows = $query->getRow();
        return $rows;
    }

    public function getCmsPageContent($select_flds='*', $condition=''){
        
        $sql = "SELECT $select_flds FROM $this->tbl_name as p LEFT JOIN `tbl_page_category` AS c ON c.`id` = p.`page_category` WHERE 1 ";
        if(!empty($condition)){
            $sql .=$condition;
        }
        
        $query = $this->db->query($sql);
        $rows = $query->getRow();
        return $rows;
    }

    public function isNewsletterExists($email){
        if(!empty($email)){
            $sql = "SELECT `id` FROM `tbl_newsletter` WHERE 1 AND `email` = '".$email."' limit 1";
        
            $query = $this->db->query($sql);
            $row = $query->getRow();
            if(is_object($row)){
                return true;
            }else{
                return false;
            }
        }
    }

    public function updateNewsletter($email, $data){
        /*
        $sql = "UPDATE `tbl_newsletter` SET `name` = '".$name."', `is_subscribed` = 1 WHERE `email` = '".$email."' ";
        $this->db->query($sql);*/

        return $this->db
                        ->table('tbl_newsletter')
                        ->where(["email" => $email])
                        ->set($data)
                        ->update();
    }

    public function addNewsletter($data){
        
        return $this->db
                        ->table('tbl_newsletter')                        
                        ->insert($data);
    }

    public function addRequestQuote($data){       
        return $this->db
                        ->table('tbl_request_quote')                        
                        ->insert($data);
    }

    public function addContact($data){       
        return $this->db
                        ->table('tbl_contact_us')                        
                        ->insert($data);
    }

    

}