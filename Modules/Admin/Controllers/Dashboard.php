<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;
use Config\Services;

class Dashboard extends BackendController
{
    protected $viewDirectory;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->session = Services::session();
        (new Adminauth())->isAdminLoggedIn();
        $this->viewDirectory = 'Modules\Admin\Views';
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $count = function (string $table) use ($db) {
            if (!$db->tableExists($table)) {
                return 0;
            }
            $builder = $db->table($table);
            if ($db->fieldExists('deleted_at', $table)) {
                $builder->where('deleted_at', null);
            }
            return $builder->countAllResults();
        };

        $data = [
            'meta_title' => 'Dashboard',
            'stats' => [
                'projects' => $count('projects'),
                'services' => $count('services'),
                'project_categories' => $count('project_categories'),
                'contact_enquiries' => $count('contact_submissions'),
                'service_enquiries' => $count('service_enquiries'),
                'gallery' => $count('gallery') + $count('project_images'),
                'media' => $count('media'),
            ],
            'recent_contacts' => $db->tableExists('contact_submissions')
                ? $db->table('contact_submissions')->where('deleted_at', null)->orderBy('id', 'DESC')->limit(5)->get()->getResultArray()
                : [],
            'recent_projects' => $db->tableExists('projects')
                ? $db->table('projects')->where('deleted_at', null)->orderBy('id', 'DESC')->limit(5)->get()->getResultArray()
                : [],
        ];

        return view('Modules\Admin\Views\dashboard\dashboard_view', $data);
    }
}
