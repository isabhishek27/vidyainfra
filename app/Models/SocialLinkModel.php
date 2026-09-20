<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialLinkModel extends Model
{
    protected $table = 'social_links';
    protected $primaryKey = 'id';
    protected $allowedFields = ['platform', 'url', 'label', 'icon', 'status', 'sort_order', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getActive(): array
    {
        return $this->where('status', 1)->orderBy('sort_order', 'ASC')->findAll();
    }
}
