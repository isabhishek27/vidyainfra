<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use App\Libraries\MediaUpload;
use Modules\Admin\Libraries\Adminauth;
use Config\Services;

class Medialibrary extends BackendController
{
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->session = Services::session();
        (new Adminauth())->isAdminLoggedIn();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        if ($this->request->is('post')) {
            $file = $this->request->getFile('file');
            $module = $this->request->getPost('module') ?: 'gallery';
            if ($file && $file->isValid()) {
                $up = (new MediaUpload())->upload($file, $module, ['module' => $module]);
                $this->session->setFlashdata($up['success'] ? 'success' : 'error', $up['success'] ? 'Uploaded.' : ($up['error'] ?? 'Upload failed'));
            }
            return redirect()->to(site_url('admin/media'));
        }

        return view('Modules\Admin\Views\Medialibrary\list_view', [
            'meta_title' => 'Media Library',
            'page_heading' => 'Media Library',
            'result' => $db->table('media')->where('deleted_at', null)->orderBy('id', 'DESC')->get(200)->getResultArray(),
        ]);
    }

    public function delete($id = null)
    {
        $db = \Config\Database::connect();
        $row = $db->table('media')->where('id', $id)->get()->getRowArray();
        if ($row) {
            (new MediaUpload())->deleteByPath($row['file_path'], true);
            $db->table('media')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
            $this->session->setFlashdata('success', 'Deleted.');
        }
        return redirect()->to(site_url('admin/media'));
    }
}
