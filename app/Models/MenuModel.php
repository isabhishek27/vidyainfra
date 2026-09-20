<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menus';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'location', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getItemsByLocation(string $location): array
    {
        $menu = $this->where('location', $location)->where('status', 1)->first();
        if (!$menu) {
            return [];
        }
        $db = \Config\Database::connect();
        return $db->table('menu_items')
            ->where('menu_id', $menu['id'])
            ->where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->get()->getResultArray();
    }
}
