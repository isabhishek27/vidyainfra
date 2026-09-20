<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceEnquiryModel extends Model
{
    protected $table = 'service_enquiries';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'service_id', 'service_name', 'name', 'phone', 'email', 'message',
        'status', 'admin_notes', 'ip_address', 'created_at', 'updated_at', 'deleted_at',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
