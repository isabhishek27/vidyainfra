<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;
use Config\Services;

class Servicecategories extends BackendController
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
        $rows = $this->db->table('service_categories')->where('deleted_at', null)->orderBy('sort_order')->get()->getResultArray();
        return view('Modules\Admin\Views\Servicecategories\list_view', [
            'meta_title' => 'Service Categories',
            'page_heading' => 'Service Categories',
            'result' => $rows,
        ]);
    }

    public function create()
    {
        if ($this->request->is('post')) {
            return $this->save(null);
        }
        return view('Modules\Admin\Views\Servicecategories\form_view', [
            'meta_title' => 'Add Category',
            'page_heading' => 'Add Service Category',
            'row' => null,
        ]);
    }

    public function edit($id = null)
    {
        $row = $this->db->table('service_categories')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();
        if (!$row) {
            return redirect()->to(site_url('admin/servicecategories'));
        }
        if ($this->request->is('post')) {
            return $this->save((int) $id);
        }
        return view('Modules\Admin\Views\Servicecategories\form_view', [
            'meta_title' => 'Edit Category',
            'page_heading' => 'Edit Service Category',
            'row' => $row,
        ]);
    }

    protected function save(?int $id)
    {
        $name = $this->request->getPost('name');
        $data = [
            'name' => $name,
            'slug' => url_title($name, '-', true),
            'description' => $this->request->getPost('description'),
            'status' => (int) $this->request->getPost('status'),
            'sort_order' => (int) $this->request->getPost('sort_order'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        if ($id) {
            $this->db->table('service_categories')->where('id', $id)->update($data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->table('service_categories')->insert($data);
        }
        $this->session->setFlashdata('success', 'Saved.');
        return redirect()->to(site_url('admin/servicecategories'));
    }

    public function delete($id = null)
    {
        if ($id) {
            $this->db->table('service_categories')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
            $this->session->setFlashdata('success', 'Deleted.');
        }
        return redirect()->to(site_url('admin/servicecategories'));
    }
}
