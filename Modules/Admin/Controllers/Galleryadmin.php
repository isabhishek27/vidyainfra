<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use App\Libraries\MediaUpload;
use Modules\Admin\Libraries\Adminauth;
use Config\Services;

class Galleryadmin extends BackendController
{
    protected $helpers = ['form'];
    protected $db;

    public function __construct()
    {
        $this->session = Services::session();
        (new Adminauth())->isAdminLoggedIn();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        if ($this->request->is('post')) {
            $files = $this->request->getFileMultiple('images');
            $uploader = new MediaUpload();
            $sort = (int) $this->db->table('gallery')->countAllResults() + 1;
            if (is_array($files)) {
                foreach ($files as $file) {
                    if (!$file->isValid()) {
                        continue;
                    }
                    $up = $uploader->upload($file, 'gallery', ['module' => 'gallery']);
                    if ($up['success']) {
                        $this->db->table('gallery')->insert([
                            'title' => $this->request->getPost('title') ?: $file->getClientName(),
                            'image_path' => $up['path'],
                            'alt_text' => $this->request->getPost('title'),
                            'status' => 1,
                            'sort_order' => $sort++,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                    }
                }
            }
            $this->session->setFlashdata('success', 'Uploaded.');
            return redirect()->to(site_url('admin/gallery'));
        }

        return view('Modules\Admin\Views\Galleryadmin\list_view', [
            'meta_title' => 'Gallery',
            'page_heading' => 'Gallery',
            'result' => $this->db->table('gallery')->where('deleted_at', null)->orderBy('sort_order')->get()->getResultArray(),
        ]);
    }

    public function create()
    {
        return redirect()->to(site_url('admin/gallery'));
    }

    public function delete($id = null)
    {
        if ($id) {
            $row = $this->db->table('gallery')->where('id', $id)->get()->getRowArray();
            if ($row) {
                (new MediaUpload())->deleteByPath($row['image_path']);
                $this->db->table('gallery')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
            }
        }
        return redirect()->to(site_url('admin/gallery'));
    }
}
