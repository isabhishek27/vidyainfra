<?php

namespace App\Models;

use CodeIgniter\Model;

class SiteSettingsModel extends Model
{
    protected $table = 'site_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['setting_key', 'setting_value', 'setting_group', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getAllAsArray(): array
    {
        $rows = $this->findAll();
        $out = [];
        foreach ($rows as $row) {
            $out[$row['setting_key']] = $row['setting_value'];
        }
        return $out;
    }

    public function getSetting(string $key, $default = '')
    {
        $row = $this->where('setting_key', $key)->first();
        return $row['setting_value'] ?? $default;
    }

    public function setSetting(string $key, $value, string $group = 'general'): void
    {
        $existing = $this->where('setting_key', $key)->first();
        if ($existing) {
            $this->update($existing['id'], [
                'setting_value' => $value,
                'setting_group' => $group,
            ]);
        } else {
            $this->insert([
                'setting_key' => $key,
                'setting_value' => $value,
                'setting_group' => $group,
            ]);
        }
    }
}
