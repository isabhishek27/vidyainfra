<?php
namespace Modules\Projects\Controllers;

use App\Controllers\FrontendController;
use App\Models\PageModel;
use App\Models\ProjectCategoryModel;
use App\Models\ProjectImageModel;
use App\Models\ProjectModel;

class Projects extends FrontendController
{
    public function index()
    {
        $page = (new PageModel())->findBySlug('projects');
        $categories = (new ProjectCategoryModel())->getActive();
        $gallery = (new ProjectImageModel())->getGalleryItems();

        $extraCss = '
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lightgallery.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lg-zoom.css">
<link rel="stylesheet" href="' . assets_url('css/gallery-css/justifiedGallery.css') . '">
<link rel="stylesheet" href="' . assets_url('css/gallery-css/lg-thumbnail.css') . '">
<link rel="stylesheet" href="' . assets_url('css/gallery-css/jquery.fancybox-thumbs.css') . '">
<style>
  .filters{display:flex;flex-wrap:wrap;gap:10px;justify-content:center;margin-bottom:40px}
  .filters button{padding:10px 20px;border-radius:999px;border:1px solid var(--line);background:#fff;font-family:var(--font-head);font-size:.88rem;cursor:pointer;transition:.25s;color:var(--navy)}
  .filters button.active,.filters button:hover{background:var(--navy);color:#fff;border-color:var(--navy)}
  .lg-backdrop{background-color:#1F2D3D}
  .lg-toolbar .lg-icon{color:#fff}
  .lg-toolbar .lg-icon:hover{color:#F28C38}
  .lg-next,.lg-prev{background-color:#F28C38;color:#1F2D3D}
  .justified-gallery>a>.jg-caption,.justified-gallery>div>.jg-caption,.justified-gallery>figure>.jg-caption{padding:10px}
</style>';

        $extraJs = '
<script src="' . assets_url('js/jquery.js') . '"></script>
<script src="' . assets_url('js/lightgallery.umd.js') . '"></script>
<script src="' . assets_url('js/lg-zoom.umd.js') . '"></script>
<script src="' . assets_url('js/jquery.justifiedGallery.js') . '"></script>
<script src="' . assets_url('js/lg-thumbnail.umd.js') . '"></script>
<script>
(function(){
  var lgInstance = null;
  var $jg = jQuery("#animated-thumbnails-gallery");
  if(!$jg.length) return;
  function initLightGallery() {
    if (lgInstance) { lgInstance.refresh(); return; }
    lgInstance = window.lightGallery(
      document.getElementById("animated-thumbnails-gallery"),
      {
        selector: ".gallery-item:not(.jg-filtered)",
        autoplayFirstVideo: false,
        pager: false,
        plugins: [lgZoom, lgThumbnail],
        mobileSettings: { controls: false, showCloseIcon: false, download: false, rotate: false }
      }
    );
  }
  $jg.justifiedGallery({
      captions: false,
      lastRow: "nojustify",
      rowHeight: 260,
      margins: 10
    })
    .on("jg.complete", initLightGallery);
  jQuery("#projectFilters button").on("click", function () {
    var f = jQuery(this).data("filter") || "";
    jQuery("#projectFilters button").removeClass("active");
    jQuery(this).addClass("active");
    $jg.justifiedGallery({ filter: f === "" ? false : f });
    setTimeout(function(){
      var visible = f === "" ? $jg.find(".gallery-item").length : $jg.find(".gallery-item" + f + ":not(.jg-filtered)").length;
      jQuery("#project-empty").toggle(visible === 0);
      if (lgInstance) { lgInstance.refresh(); } else { initLightGallery(); }
    }, 500);
  });
})();
</script>';

        $data = [
            'meta_title'   => $page['seo_title'] ?? 'Projects — Vidya Infra Construction',
            'meta_desc'    => $page['seo_description'] ?? '',
            'meta_keyword' => $page['seo_keywords'] ?? '',
            'page'         => $page,
            'categories'   => $categories,
            'gallery'      => $gallery,
            'extra_css'    => $extraCss,
            'extra_js'     => $extraJs,
            'include'      => 'Modules\\Projects\\Views\\projects_views',
        ];

        return view('container', $data);
    }

    public function detail(string $slug)
    {
        $project = (new ProjectModel())->findBySlug($slug);
        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $images = (new ProjectImageModel())->getByProject((int) $project['id']);

        $data = [
            'meta_title'   => $project['seo_title'] ?: ($project['title'] . ' — Vidya Infra Construction'),
            'meta_desc'    => $project['seo_description'] ?? '',
            'meta_keyword' => '',
            'project'      => $project,
            'images'       => $images,
            'include'      => 'Modules\\Projects\\Views\\project_detail_views',
        ];

        return view('container', $data);
    }
}
