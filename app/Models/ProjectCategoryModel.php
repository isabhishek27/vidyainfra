<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectCategoryModel extends Model
{
    protected $table = 'project_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'slug', 'filter_class', 'description', 'status', 'sort_order',
        'created_at', 'updated_at', 'deleted_at',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getActive(): array
    {
        return $this->where('status', 1)->orderBy('sort_order', 'ASC')->findAll();
    }
}
