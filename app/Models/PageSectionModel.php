<?php

namespace App\Models;

use CodeIgniter\Model;

class PageSectionModel extends Model
{
    protected $table = 'page_sections';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'page_id', 'section_key', 'title', 'subtitle', 'eyebrow', 'content', 'content_2',
        'image', 'button_text', 'button_link', 'extra_json', 'status', 'sort_order',
        'created_at', 'updated_at', 'deleted_at',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getByPageKey(?int $pageId, string $key)
    {
        $builder = $this->where('section_key', $key)->where('status', 1);
        if ($pageId) {
            $builder->where('page_id', $pageId);
        }
        return $builder->orderBy('sort_order', 'ASC')->first();
    }

    public function getPageSections(int $pageId): array
    {
        $rows = $this->where('page_id', $pageId)->where('status', 1)
            ->orderBy('sort_order', 'ASC')->findAll();
        $out = [];
        foreach ($rows as $row) {
            $out[$row['section_key']] = $row;
        }
        return $out;
    }
}
