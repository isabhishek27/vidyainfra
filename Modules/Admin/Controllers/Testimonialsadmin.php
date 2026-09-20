<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use App\Libraries\MediaUpload;
use Modules\Admin\Libraries\Adminauth;
use Config\Services;

class Testimonialsadmin extends BackendController
{
    protected $helpers = ['form'];
    protected $db;
    protected $base = 'admin/testimonials';

    public function __construct()
    {
        $this->session = Services::session();
        (new Adminauth())->isAdminLoggedIn();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('Modules\Admin\Views\Testimonialsadmin\list_view', [
            'meta_title' => 'Testimonials',
            'page_heading' => 'Testimonials',
            'result' => $this->db->table('testimonials')->where('deleted_at', null)->orderBy('sort_order')->get()->getResultArray(),
            'base' => $this->base,
        ]);
    }

    public function create()
    {
        if ($this->request->is('post')) {
            return $this->save(null);
        }
        return view('Modules\Admin\Views\Testimonialsadmin\form_view', [
            'meta_title' => 'Add', 'page_heading' => 'Add Testimonial', 'row' => null, 'base' => $this->base,
        ]);
    }

    public function edit($id = null)
    {
        $row = $this->db->table('testimonials')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();
        if (!$row) {
            return redirect()->to(site_url($this->base));
        }
        if ($this->request->is('post')) {
            return $this->save((int) $id);
        }
        return view('Modules\Admin\Views\Testimonialsadmin\form_view', [
            'meta_title' => 'Edit', 'page_heading' => 'Edit Testimonial', 'row' => $row, 'base' => $this->base,
        ]);
    }

    protected function save(?int $id)
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'designation' => $this->request->getPost('designation'),
            'company' => $this->request->getPost('company'),
            'content' => $this->request->getPost('content'),
            'rating' => (int) $this->request->getPost('rating'),
            'status' => (int) $this->request->getPost('status'),
            'sort_order' => (int) $this->request->getPost('sort_order'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $file = $this->request->getFile('image');
        if ($file && $file->isValid()) {
            $up = (new MediaUpload())->upload($file, 'testimonials', ['module' => 'testimonials']);
            if ($up['success']) {
                $data['image'] = $up['path'];
            }
        }
        if ($id) {
            $this->db->table('testimonials')->where('id', $id)->update($data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->table('testimonials')->insert($data);
        }
        $this->session->setFlashdata('success', 'Saved.');
        return redirect()->to(site_url($this->base));
    }

    public function delete($id = null)
    {
        if ($id) {
            $this->db->table('testimonials')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        }
        return redirect()->to(site_url($this->base));
    }
}
