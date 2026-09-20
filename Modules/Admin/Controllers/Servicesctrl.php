<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use App\Libraries\MediaUpload;
use Modules\Admin\Libraries\Adminauth;
use Modules\Admin\Models\VidyaServiceModel;
use Config\Services;

class Servicesctrl extends BackendController
{
    protected $helpers = ['form'];
    protected $model;

    public function __construct()
    {
        $this->session = Services::session();
        (new Adminauth())->isAdminLoggedIn();
        $this->model = new VidyaServiceModel();
    }

    public function index()
    {
        $keyword = (string) ($this->request->getGet('keyword') ?? '');
        $status = $this->request->getGet('status');
        $builder = $this->model;
        if ($keyword !== '') {
            $builder = $builder->like('title', $keyword);
        }
        if ($status !== null && $status !== '') {
            $builder = $builder->where('status', (int) $status);
        }

        $action = $this->request->getPost('action_type');
        $ids = $this->request->getPost('arr_ids');
        if ($action && is_array($ids)) {
            if ($action === 'delete') {
                $this->model->delete($ids);
            } elseif ($action === 'enable') {
                $this->model->update($ids, ['status' => 1]);
            } elseif ($action === 'disable') {
                $this->model->update($ids, ['status' => 0]);
            }
            $this->session->setFlashdata('success', 'Services updated.');
            return redirect()->to(site_url('admin/services'));
        }

        return view('Modules\Admin\Views\Servicesctrl\list_view', [
            'meta_title' => 'Services',
            'page_heading' => 'All Services',
            'result' => $builder->orderBy('sort_order', 'ASC')->paginate(25),
            'pager' => $this->model->pager,
            'keyword' => $keyword,
            'status' => $status,
        ]);
    }

    public function create()
    {
        if ($this->request->is('post')) {
            return $this->save(null);
        }
        return view('Modules\Admin\Views\Servicesctrl\form_view', [
            'meta_title' => 'Add Service',
            'page_heading' => 'Add Service',
            'row' => null,
            'validation' => [],
        ]);
    }

    public function edit($id = null)
    {
        $row = $this->model->find($id);
        if (!$row) {
            $this->session->setFlashdata('error', 'Service not found.');
            return redirect()->to(site_url('admin/services'));
        }
        if ($this->request->is('post')) {
            return $this->save((int) $id);
        }
        return view('Modules\Admin\Views\Servicesctrl\form_view', [
            'meta_title' => 'Edit Service',
            'page_heading' => 'Edit Service',
            'row' => $row,
            'validation' => [],
        ]);
    }

    protected function save(?int $id)
    {
        $rules = [
            'title' => 'required|min_length[2]|max_length[255]',
            'status' => 'required|in_list[0,1]',
            'sort_order' => 'permit_empty|integer',
        ];
        if (!$this->validate($rules)) {
            $this->session->setFlashdata('error', 'Validation failed.');
            return redirect()->back()->withInput();
        }

        $title = $this->request->getPost('title');
        $payload = [
            'title' => $title,
            'slug' => url_title($title, '-', true),
            'parent_id' => null,
            'short_description' => $this->request->getPost('short_description'),
            'full_description' => $this->request->getPost('full_description'),
            'seo_title' => $this->request->getPost('seo_title'),
            'seo_description' => $this->request->getPost('seo_description'),
            'status' => (int) $this->request->getPost('status'),
            'sort_order' => (int) $this->request->getPost('sort_order'),
            'show_in_footer' => (int) $this->request->getPost('show_in_footer'),
        ];

        $file = $this->request->getFile('featured_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $up = (new MediaUpload())->upload($file, 'services', ['module' => 'services', 'title' => $title]);
            if ($up['success']) {
                $payload['featured_image'] = $up['path'];
            }
        }

        if ($id) {
            $this->model->update($id, $payload);
            $this->session->setFlashdata('success', 'Service updated.');
        } else {
            $this->model->insert($payload);
            $this->session->setFlashdata('success', 'Service created.');
        }
        return redirect()->to(site_url('admin/services'));
    }

    public function delete($id = null)
    {
        if ($id) {
            $this->model->delete($id);
            $this->session->setFlashdata('success', 'Service deleted.');
        }
        return redirect()->to(site_url('admin/services'));
    }
}
