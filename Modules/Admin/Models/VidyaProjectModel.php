<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class VidyaProjectModel extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'category_id', 'title', 'slug', 'short_description', 'full_description',
        'location', 'client', 'project_type', 'completion_date', 'featured_image',
        'seo_title', 'seo_description', 'status', 'is_featured', 'sort_order',
        'created_at', 'updated_at', 'deleted_at',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
