<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use App\Models\ServiceEnquiryModel;
use Modules\Admin\Libraries\Adminauth;
use Config\Services;

class Serviceenquiries extends BackendController
{
    protected $helpers = ['form'];
    protected $model;

    public function __construct()
    {
        $this->session = Services::session();
        (new Adminauth())->isAdminLoggedIn();
        $this->model = new ServiceEnquiryModel();
    }

    public function index()
    {
        $keyword = (string) ($this->request->getGet('keyword') ?? '');
        $status = (string) ($this->request->getGet('status') ?? '');
        $builder = $this->model;
        if ($keyword !== '') {
            $builder = $builder->groupStart()->like('name', $keyword)->orLike('email', $keyword)->orLike('service_name', $keyword)->groupEnd();
        }
        if ($status !== '') {
            $builder = $builder->where('status', $status);
        }
        return view('Modules\Admin\Views\Serviceenquiries\list_view', [
            'meta_title' => 'Service Enquiries',
            'page_heading' => 'Service Enquiries',
            'result' => $builder->orderBy('id', 'DESC')->paginate(25),
            'pager' => $this->model->pager,
            'keyword' => $keyword,
            'status' => $status,
        ]);
    }

    public function view($id = null)
    {
        $row = $this->model->find($id);
        if (!$row) {
            return redirect()->to(site_url('admin/service-enquiries'));
        }
        if ($this->request->is('post')) {
            $this->model->update($id, [
                'status' => $this->request->getPost('status'),
                'admin_notes' => $this->request->getPost('admin_notes'),
            ]);
            $this->session->setFlashdata('success', 'Enquiry updated.');
            return redirect()->to(site_url('admin/service-enquiries/view/' . $id));
        }
        if (($row['status'] ?? '') === 'new') {
            $this->model->update($id, ['status' => 'read']);
            $row['status'] = 'read';
        }
        return view('Modules\Admin\Views\Serviceenquiries\detail_view', [
            'meta_title' => 'Service Enquiry',
            'page_heading' => 'Service Enquiry Detail',
            'row' => $row,
        ]);
    }

    public function delete($id = null)
    {
        if ($id) {
            $this->model->delete($id);
            $this->session->setFlashdata('success', 'Deleted.');
        }
        return redirect()->to(site_url('admin/service-enquiries'));
    }
}
