<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
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

    public function findBySlug(string $slug)
    {
        return $this->where('slug', $slug)->where('status', 1)->first();
    }

    public function getActiveWithCategory(): array
    {
        return $this->select('projects.*, project_categories.name as category_name, project_categories.slug as category_slug, project_categories.filter_class')
            ->join('project_categories', 'project_categories.id = projects.category_id', 'left')
            ->where('projects.status', 1)
            ->orderBy('projects.sort_order', 'ASC')
            ->findAll();
    }
}
