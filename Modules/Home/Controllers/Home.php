<?php
namespace Modules\Home\Controllers;

use App\Controllers\FrontendController;
use App\Models\PageModel;
use App\Models\PageSectionModel;

class Home extends FrontendController
{
    protected $viewDirectory = 'Modules/Home/Views';

    public function index()
    {
        $pageModel = new PageModel();
        $sectionModel = new PageSectionModel();

        $page = $pageModel->findBySlug('home');
        $sections = $page ? $sectionModel->getPageSections((int) $page['id']) : [];

        $data = [
            'meta_title'    => $page['seo_title'] ?? setting('seo_title'),
            'meta_desc'     => $page['seo_description'] ?? setting('seo_description'),
            'meta_keyword'  => $page['seo_keywords'] ?? setting('seo_keywords'),
            'hero'          => $sections['hero'] ?? [],
            'about'         => $sections['about_preview'] ?? [],
            'cta'           => $sections['cta'] ?? [],
            'include'       => 'Modules\\Home\\Views\\home_views',
        ];

        return view('container', $data);
    }
}
