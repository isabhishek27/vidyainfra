<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use App\Libraries\MediaUpload;
use Modules\Admin\Libraries\Adminauth;
use Modules\Admin\Models\VidyaProjectModel;
use Config\Services;

class Projectsctrl extends BackendController
{
    protected $helpers = ['form'];
    protected $model;

    public function __construct()
    {
        $this->session = Services::session();
        (new Adminauth())->isAdminLoggedIn();
        $this->model = new VidyaProjectModel();
    }

    public function index()
    {
        $keyword = (string) ($this->request->getGet('keyword') ?? '');
        $builder = $this->model->select('projects.*, project_categories.name as category_name')
            ->join('project_categories', 'project_categories.id = projects.category_id', 'left');
        if ($keyword !== '') {
            $builder->like('projects.title', $keyword);
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
            $this->session->setFlashdata('success', 'Projects updated.');
            return redirect()->to(site_url('admin/projects'));
        }

        return view('Modules\Admin\Views\Projectsctrl\list_view', [
            'meta_title' => 'Projects',
            'page_heading' => 'All Projects',
            'result' => $builder->orderBy('projects.sort_order', 'ASC')->paginate(25),
            'pager' => $this->model->pager,
            'keyword' => $keyword,
        ]);
    }

    public function create()
    {
        if ($this->request->is('post')) {
            return $this->save(null);
        }
        return view('Modules\Admin\Views\Projectsctrl\form_view', $this->formData(null));
    }

    public function edit($id = null)
    {
        $row = $this->model->find($id);
        if (!$row) {
            $this->session->setFlashdata('error', 'Project not found.');
            return redirect()->to(site_url('admin/projects'));
        }
        if ($this->request->is('post')) {
            return $this->save((int) $id);
        }
        return view('Modules\Admin\Views\Projectsctrl\form_view', $this->formData($row));
    }

    protected function formData($row): array
    {
        $db = \Config\Database::connect();
        $categories = $db->table('project_categories')->where('deleted_at', null)->where('status', 1)->orderBy('sort_order')->get()->getResultArray();
        $images = [];
        if ($row) {
            $images = $db->table('project_images')->where('project_id', $row['id'])->where('deleted_at', null)->orderBy('sort_order')->get()->getResultArray();
        }
        return [
            'meta_title' => $row ? 'Edit Project' : 'Add Project',
            'page_heading' => $row ? 'Edit Project' : 'Add Project',
            'row' => $row,
            'categories' => $categories,
            'images' => $images,
        ];
    }

    protected function save(?int $id)
    {
        $rules = [
            'title' => 'required|min_length[2]|max_length[255]',
            'category_id' => 'required|is_natural_no_zero',
            'status' => 'required|in_list[0,1]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validation failed.');
        }

        $title = $this->request->getPost('title');
        $payload = [
            'title' => $title,
            'slug' => url_title($title, '-', true),
            'category_id' => (int) $this->request->getPost('category_id'),
            'short_description' => $this->request->getPost('short_description'),
            'full_description' => $this->request->getPost('full_description'),
            'location' => $this->request->getPost('location'),
            'client' => $this->request->getPost('client'),
            'project_type' => $this->request->getPost('project_type'),
            'completion_date' => $this->request->getPost('completion_date') ?: null,
            'seo_title' => $this->request->getPost('seo_title'),
            'seo_description' => $this->request->getPost('seo_description'),
            'status' => (int) $this->request->getPost('status'),
            'is_featured' => (int) $this->request->getPost('is_featured'),
            'sort_order' => (int) $this->request->getPost('sort_order'),
        ];

        $uploadErrors = [];
        $uploader = new MediaUpload();

        $file = $this->request->getFile('featured_image');
        if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            $up = $uploader->upload($file, 'projects', ['module' => 'projects', 'title' => $title]);
            if (!empty($up['success'])) {
                $payload['featured_image'] = $up['path'];
            } else {
                $uploadErrors[] = 'Featured image: ' . ($up['error'] ?? 'upload failed');
            }
        }

        if ($id) {
            $this->model->update($id, $payload);
            $projectId = $id;
        } else {
            $projectId = (int) $this->model->insert($payload);
            if (!$projectId) {
                return redirect()->back()->withInput()->with('error', 'Could not save project.');
            }
        }

        $files = $this->request->getFileMultiple('gallery');
        if ($files === null) {
            // Fallback if browser posts as gallery / gallery.0
            $single = $this->request->getFile('gallery');
            $files = ($single && $single->getError() !== UPLOAD_ERR_NO_FILE) ? [$single] : [];
        }

        if (is_array($files) && $files !== []) {
            $db = \Config\Database::connect();
            $existingCount = (int) $db->table('project_images')
                ->where('project_id', $projectId)
                ->where('deleted_at', null)
                ->countAllResults();
            $sort = $existingCount + 1;
            $isFirstUpload = ($existingCount === 0);
            $firstNewId = null;

            foreach ($files as $gf) {
                if (!$gf || $gf->getError() === UPLOAD_ERR_NO_FILE) {
                    continue;
                }
                $up = $uploader->upload($gf, 'project_gallery', [
                    'module' => 'projects',
                    'module_id' => $projectId,
                    'title' => $title,
                ]);
                if (!empty($up['success'])) {
                    $makePrimary = $isFirstUpload && $firstNewId === null ? 1 : 0;
                    $db->table('project_images')->insert([
                        'project_id' => $projectId,
                        'media_id' => $up['media_id'],
                        'image_path' => $up['path'],
                        'caption' => $title,
                        'alt_text' => $title,
                        'is_primary' => $makePrimary,
                        'sort_order' => $sort++,
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                    $newId = (int) $db->insertID();
                    if ($makePrimary) {
                        $firstNewId = $newId;
                        if (empty($payload['featured_image'])) {
                            $this->model->update($projectId, ['featured_image' => $up['path']]);
                        }
                    }
                } else {
                    $uploadErrors[] = 'Gallery image: ' . ($up['error'] ?? 'upload failed');
                }
            }
        }

        $remove = $this->request->getPost('remove_images');
        if (is_array($remove) && $remove) {
            $db = \Config\Database::connect();
            foreach ($remove as $imgId) {
                $img = $db->table('project_images')->where('id', (int) $imgId)->get()->getRowArray();
                if ($img) {
                    $db->table('project_images')->where('id', (int) $imgId)->update(['deleted_at' => date('Y-m-d H:i:s')]);
                    $uploader->deleteByPath($img['image_path']);
                }
            }
        }

        $db = \Config\Database::connect();
        $primary = (int) $this->request->getPost('primary_image');
        $activeImages = $db->table('project_images')
            ->where('project_id', $projectId)
            ->where('deleted_at', null)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        if ($primary <= 0 && $activeImages) {
            // Default: first gallery image is primary
            $primary = (int) $activeImages[0]['id'];
        }

        if ($primary > 0 && $activeImages) {
            $db->table('project_images')->where('project_id', $projectId)->update(['is_primary' => 0]);
            $db->table('project_images')->where('id', $primary)->where('project_id', $projectId)->update(['is_primary' => 1]);
            $img = $db->table('project_images')->where('id', $primary)->get()->getRowArray();
            if ($img) {
                $this->model->update($projectId, ['featured_image' => $img['image_path']]);
            }
        }

        if ($uploadErrors) {
            $this->session->setFlashdata('error', implode(' ', $uploadErrors));
        } else {
            $this->session->setFlashdata('success', $id ? 'Project updated.' : 'Project created.');
        }

        return redirect()->to(site_url('admin/projects/edit/' . $projectId));
    }

    public function delete($id = null)
    {
        if ($id) {
            $this->model->delete($id);
            $this->session->setFlashdata('success', 'Project deleted.');
        }
        return redirect()->to(site_url('admin/projects'));
    }
}
