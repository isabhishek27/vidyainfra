<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectImageModel extends Model
{
    protected $table = 'project_images';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'project_id', 'media_id', 'image_path', 'caption', 'alt_text', 'lg_size',
        'is_primary', 'sort_order', 'status', 'created_at', 'updated_at', 'deleted_at',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getGalleryItems(): array
    {
        return $this->select('project_images.*, projects.title as project_title, projects.client, projects.location, project_categories.name as category_name, project_categories.slug as category_slug, project_categories.filter_class')
            ->join('projects', 'projects.id = project_images.project_id')
            ->join('project_categories', 'project_categories.id = projects.category_id', 'left')
            ->where('project_images.status', 1)
            ->where('projects.status', 1)
            ->orderBy('project_categories.sort_order', 'ASC')
            ->orderBy('project_images.sort_order', 'ASC')
            ->findAll();
    }

    public function getByProject(int $projectId): array
    {
        return $this->where('project_id', $projectId)->where('status', 1)
            ->orderBy('sort_order', 'ASC')->findAll();
    }
}
