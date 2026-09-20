<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use App\Models\PageModel;
use App\Models\PageSectionModel;
use Modules\Admin\Libraries\Adminauth;
use Config\Services;

class Pagesadmin extends BackendController
{
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->session = Services::session();
        (new Adminauth())->isAdminLoggedIn();
    }

    public function index()
    {
        return view('Modules\Admin\Views\Pagesadmin\list_view', [
            'meta_title' => 'Pages',
            'page_heading' => 'Pages',
            'result' => (new PageModel())->orderBy('sort_order')->findAll(),
        ]);
    }

    public function edit($id = null)
    {
        $pageModel = new PageModel();
        $sectionModel = new PageSectionModel();
        $row = $pageModel->find($id);
        if (!$row) {
            return redirect()->to(site_url('admin/pagesadmin'));
        }

        if ($this->request->is('post')) {
            $pageModel->update($id, [
                'title' => $this->request->getPost('title'),
                'subtitle' => $this->request->getPost('subtitle'),
                'breadcrumb' => $this->request->getPost('breadcrumb'),
                'seo_title' => $this->request->getPost('seo_title'),
                'seo_description' => $this->request->getPost('seo_description'),
                'seo_keywords' => $this->request->getPost('seo_keywords'),
                'status' => (int) $this->request->getPost('status'),
            ]);

            $sectionIds = $this->request->getPost('section_id') ?? [];
            $titles = $this->request->getPost('section_title') ?? [];
            $eyebrows = $this->request->getPost('section_eyebrow') ?? [];
            $contents = $this->request->getPost('section_content') ?? [];
            $contents2 = $this->request->getPost('section_content_2') ?? [];
            $buttons = $this->request->getPost('section_button_text') ?? [];
            $links = $this->request->getPost('section_button_link') ?? [];
            $statuses = $this->request->getPost('section_status') ?? [];

            foreach ($sectionIds as $i => $sid) {
                $sectionModel->update((int) $sid, [
                    'title' => $titles[$i] ?? null,
                    'eyebrow' => $eyebrows[$i] ?? null,
                    'content' => $contents[$i] ?? null,
                    'content_2' => $contents2[$i] ?? null,
                    'button_text' => $buttons[$i] ?? null,
                    'button_link' => $links[$i] ?? null,
                    'status' => (int) ($statuses[$i] ?? 1),
                ]);
            }

            $this->session->setFlashdata('success', 'Page updated.');
            return redirect()->to(site_url('admin/pagesadmin/edit/' . $id));
        }

        return view('Modules\Admin\Views\Pagesadmin\edit_view', [
            'meta_title' => 'Edit Page',
            'page_heading' => 'Edit Page: ' . $row['title'],
            'row' => $row,
            'sections' => $sectionModel->where('page_id', $id)->orderBy('sort_order')->findAll(),
        ]);
    }
}
