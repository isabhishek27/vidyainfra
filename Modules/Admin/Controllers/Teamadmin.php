<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use App\Libraries\MediaUpload;
use Modules\Admin\Libraries\Adminauth;
use Config\Services;

class Teamadmin extends BackendController
{
    protected $helpers = ['form'];
    protected $db;
    protected $base = 'admin/team';

    public function __construct()
    {
        $this->session = Services::session();
        (new Adminauth())->isAdminLoggedIn();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('Modules\Admin\Views\Teamadmin\list_view', [
            'meta_title' => 'Team',
            'page_heading' => 'Team Members',
            'result' => $this->db->table('team_members')->where('deleted_at', null)->orderBy('sort_order')->get()->getResultArray(),
            'base' => $this->base,
        ]);
    }

    public function create()
    {
        if ($this->request->is('post')) {
            return $this->save(null);
        }
        return view('Modules\Admin\Views\Teamadmin\form_view', [
            'meta_title' => 'Add', 'page_heading' => 'Add Team Member', 'row' => null, 'base' => $this->base,
        ]);
    }

    public function edit($id = null)
    {
        $row = $this->db->table('team_members')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();
        if (!$row) {
            return redirect()->to(site_url($this->base));
        }
        if ($this->request->is('post')) {
            return $this->save((int) $id);
        }
        return view('Modules\Admin\Views\Teamadmin\form_view', [
            'meta_title' => 'Edit', 'page_heading' => 'Edit Team Member', 'row' => $row, 'base' => $this->base,
        ]);
    }

    protected function save(?int $id)
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'designation' => $this->request->getPost('designation'),
            'bio' => $this->request->getPost('bio'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'status' => (int) $this->request->getPost('status'),
            'sort_order' => (int) $this->request->getPost('sort_order'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $file = $this->request->getFile('image');
        if ($file && $file->isValid()) {
            $up = (new MediaUpload())->upload($file, 'team', ['module' => 'team']);
            if ($up['success']) {
                $data['image'] = $up['path'];
            }
        }
        if ($id) {
            $this->db->table('team_members')->where('id', $id)->update($data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->table('team_members')->insert($data);
        }
        $this->session->setFlashdata('success', 'Saved.');
        return redirect()->to(site_url($this->base));
    }

    public function delete($id = null)
    {
        if ($id) {
            $this->db->table('team_members')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        }
        return redirect()->to(site_url($this->base));
    }
}
