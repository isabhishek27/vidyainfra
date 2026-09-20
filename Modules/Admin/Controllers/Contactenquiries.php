<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use App\Models\ContactSubmissionModel;
use Modules\Admin\Libraries\Adminauth;
use Config\Services;

class Contactenquiries extends BackendController
{
    protected $helpers = ['form'];
    protected $model;

    public function __construct()
    {
        $this->session = Services::session();
        (new Adminauth())->isAdminLoggedIn();
        $this->model = new ContactSubmissionModel();
    }

    public function index()
    {
        $keyword = (string) ($this->request->getGet('keyword') ?? '');
        $status = (string) ($this->request->getGet('status') ?? '');
        $builder = $this->model;
        if ($keyword !== '') {
            $builder = $builder->groupStart()->like('name', $keyword)->orLike('email', $keyword)->orLike('phone', $keyword)->groupEnd();
        }
        if ($status !== '') {
            $builder = $builder->where('status', $status);
        }
        return view('Modules\Admin\Views\Contactenquiries\list_view', [
            'meta_title' => 'Contact Enquiries',
            'page_heading' => 'Contact Enquiries',
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
            return redirect()->to(site_url('admin/contact-enquiries'));
        }
        if ($this->request->is('post')) {
            $this->model->update($id, [
                'status' => $this->request->getPost('status'),
                'admin_notes' => $this->request->getPost('admin_notes'),
            ]);
            $this->session->setFlashdata('success', 'Enquiry updated.');
            return redirect()->to(site_url('admin/contact-enquiries/view/' . $id));
        }
        if (($row['status'] ?? '') === 'new') {
            $this->model->update($id, ['status' => 'read']);
            $row['status'] = 'read';
        }
        return view('Modules\Admin\Views\Contactenquiries\detail_view', [
            'meta_title' => 'Enquiry Detail',
            'page_heading' => 'Enquiry Detail',
            'row' => $row,
        ]);
    }

    public function delete($id = null)
    {
        if ($id) {
            $this->model->delete($id);
            $this->session->setFlashdata('success', 'Deleted.');
        }
        return redirect()->to(site_url('admin/contact-enquiries'));
    }
}
