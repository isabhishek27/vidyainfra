<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class VidyaServiceModel extends Model
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

    public function getPaged(array $cond = [], string $keyword = '', int $perPage = 25): array
    {
        $builder = $this->builder();
        $builder->where('deleted_at', null);
        foreach ($cond as $k => $v) {
            $builder->where($k, $v);
        }
        if ($keyword !== '') {
            $builder->like('title', $keyword);
        }
        $builder->orderBy('sort_order', 'ASC')->orderBy('id', 'DESC');

        return [
            'data'  => $this->paginate($perPage),
            'pager' => $this->pager,
            'links' => $this->pager->links('default', 'admin_paging_template'),
        ];
    }
}
