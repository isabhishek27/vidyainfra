<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'category_id', 'parent_id', 'title', 'slug', 'short_description', 'full_description',
        'featured_image', 'icon', 'seo_title', 'seo_description', 'status', 'sort_order',
        'show_in_footer', 'created_at', 'updated_at', 'deleted_at',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getActiveParents(): array
    {
        return $this->where('status', 1)
            ->groupStart()
                ->where('parent_id', null)
                ->orWhere('parent_id', 0)
            ->groupEnd()
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    public function getChildren(int $parentId): array
    {
        return $this->where('parent_id', $parentId)->where('status', 1)
            ->orderBy('sort_order', 'ASC')->findAll();
    }

    public function getFooterServices(): array
    {
        $parents = $this->where('status', 1)->where('show_in_footer', 1)
            ->groupStart()
                ->where('parent_id', null)
                ->orWhere('parent_id', 0)
            ->groupEnd()
            ->orderBy('sort_order', 'ASC')->findAll();

        foreach ($parents as &$p) {
            $p['children'] = $this->getChildren((int) $p['id']);
        }
        return $parents;
    }

    public function findBySlug(string $slug)
    {
        return $this->where('slug', $slug)->where('status', 1)->first();
    }
}
