<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use App\Libraries\MediaUpload;
use App\Models\SiteSettingsModel;
use Modules\Admin\Libraries\Adminauth;
use Config\Services;

class Sitesettings extends BackendController
{
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->session = Services::session();
        (new Adminauth())->isAdminLoggedIn();
    }

    public function index()
    {
        $model = new SiteSettingsModel();
        $settings = $model->getAllAsArray();
        $keys = [
            'website_name','company_name','logo','logo_alt','favicon','phone','email','address',
            'google_map_url','whatsapp','facebook_url','instagram_url','linkedin_url','youtube_url',
            'footer_description','copyright_text','seo_title','seo_description','seo_keywords','og_image',
        ];

        if ($this->request->is('post')) {
            $uploader = new MediaUpload();
            foreach ($keys as $key) {
                if (in_array($key, ['logo','logo_alt','favicon','og_image'], true)) {
                    $file = $this->request->getFile($key);
                    if ($file && $file->isValid() && !$file->hasMoved()) {
                        $subdir = ($key === 'favicon') ? 'favicon' : (($key === 'og_image') ? 'settings' : 'logo');
                        $result = $uploader->upload($file, $subdir, ['module' => 'settings', 'title' => $key]);
                        if ($result['success']) {
                            $model->setSetting($key, $result['path'], 'branding');
                        }
                    }
                } else {
                    $model->setSetting($key, (string) $this->request->getPost($key), 'general');
                }
            }
            $db = \Config\Database::connect();
            $db->table('tbl_users')->where('id', 1)->update([
                'comp_name' => $this->request->getPost('company_name'),
                'user_email' => $this->request->getPost('email'),
                'phone1' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
                'fb_link' => $this->request->getPost('facebook_url'),
                'instagram_link' => $this->request->getPost('instagram_url'),
                'linkedin_link' => $this->request->getPost('linkedin_url'),
            ]);
            $this->session->setFlashdata('success', 'Site settings updated successfully.');
            return redirect()->to(site_url('admin/sitesettings'));
        }

        return view('Modules\Admin\Views\Sitesettings\edit_view', [
            'meta_title' => 'Site Settings',
            'page_heading' => 'Site Settings',
            'settings' => $settings,
        ]);
    }
}
