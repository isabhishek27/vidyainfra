<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactSubmissionModel extends Model
{
    protected $table = 'contact_submissions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'phone', 'email', 'project_type', 'message', 'status',
        'admin_notes', 'ip_address', 'created_at', 'updated_at', 'deleted_at',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
