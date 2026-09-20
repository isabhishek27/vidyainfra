<?php

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'slug', 'subtitle', 'breadcrumb', 'hero_image', 'content',
        'seo_title', 'seo_description', 'seo_keywords', 'og_image', 'canonical_url',
        'robots', 'status', 'sort_order', 'created_at', 'updated_at', 'deleted_at',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function findBySlug(string $slug)
    {
        return $this->where('slug', $slug)->where('status', 1)->first();
    }
}
