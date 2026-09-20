<?php
namespace Modules\Services\Controllers;

use App\Controllers\FrontendController;
use App\Models\PageModel;
use App\Models\PageSectionModel;
use App\Models\ServiceModel;
use App\Models\ServiceEnquiryModel;

class Services extends FrontendController
{
    protected $helpers = ['form'];

    public function index()
    {
        $pageModel = new PageModel();
        $sectionModel = new PageSectionModel();
        $serviceModel = new ServiceModel();

        $page = $pageModel->findBySlug('services');
        $sections = $page ? $sectionModel->getPageSections((int) $page['id']) : [];
        $services = $serviceModel->getActiveParents();

        $data = [
            'meta_title'   => $page['seo_title'] ?? 'Services — Vidya Infra Construction',
            'meta_desc'    => $page['seo_description'] ?? '',
            'meta_keyword' => $page['seo_keywords'] ?? '',
            'page'         => $page,
            'intro'        => $sections['intro'] ?? [],
            'services'     => $services,
            'success'      => session()->getFlashdata('success'),
            'error'        => session()->getFlashdata('error'),
            'include'      => 'Modules\\Services\\Views\\services_views',
        ];

        return view('container', $data);
    }

    public function detail(string $slug)
    {
        $serviceModel = new ServiceModel();
        $service = $serviceModel->findBySlug($slug);
        if (!$service) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $children = $serviceModel->getChildren((int) $service['id']);

        $data = [
            'meta_title'   => $service['seo_title'] ?: ($service['title'] . ' — Vidya Infra Construction'),
            'meta_desc'    => $service['seo_description'] ?? '',
            'meta_keyword' => '',
            'service'      => $service,
            'children'     => $children,
            'include'      => 'Modules\\Services\\Views\\service_detail_views',
        ];

        return view('container', $data);
    }

    public function enquire()
    {
        $rules = [
            'service_id' => 'permit_empty|is_natural',
            'service'    => 'required|max_length[255]',
            'name'       => 'required|min_length[2]|max_length[200]',
            'phone'      => 'required|min_length[7]|max_length[50]',
            'email'      => 'required|valid_email|max_length[200]',
            'message'    => 'permit_empty|max_length[5000]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url('services'))->with('error', 'Please check the form and try again.');
        }

        $serviceId = (int) $this->request->getPost('service_id');
        $serviceName = $this->request->getPost('service');

        if ($serviceId > 0) {
            $svc = (new ServiceModel())->find($serviceId);
            if ($svc) {
                $serviceName = $svc['title'];
            }
        }

        (new ServiceEnquiryModel())->insert([
            'service_id'   => $serviceId ?: null,
            'service_name' => $serviceName,
            'name'         => $this->request->getPost('name'),
            'phone'        => $this->request->getPost('phone'),
            'email'        => $this->request->getPost('email'),
            'message'      => $this->request->getPost('message'),
            'status'       => 'new',
            'ip_address'   => $this->request->getIPAddress(),
        ]);

        return redirect()->to(site_url('services'))->with('success', "Thank you! We'll be in touch shortly.");
    }
}
