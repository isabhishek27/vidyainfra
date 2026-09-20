<?php
namespace Modules\Blog\Controllers;
use App\Controllers\FrontendController;

use Config\Services;

use Modules\Blog\Models\BlogModel;
use Modules\Pages\Models\PagesModel;
use App\Libraries\MyLibrary; 

class Blog extends FrontendController {

    protected $viewDirectory;
    protected $my_model;
    protected $pages_model;
    protected $helpers = ['form'];
    protected $mylib;

    public function __construct(){

        $this->my_model = new BlogModel();
        $this->pages_model = new PagesModel();
        $this->mylib = new MyLibrary();  

        // $uri = current_url(true);               
        // $module_name = ucfirst($uri->getSegment(1));
        // if(empty($module_name)){
        //     $module_name = 'Pages';
        // }
        $module_name = 'Blog';

        $this->viewDirectory = 'Modules/'. $module_name.'/Views';
    }    

    public function index() {
        
        $cond = "`slug`='blog' AND `status` = 1 ";
		$args = ['tbl_name'=>'tbl_seo','select_fld'=>'meta_title,meta_keyword,meta_desc','where'=>$cond];
		$meta_info = $this->mylib->getRecords($args);
		if(is_array($meta_info) && count($meta_info)>0){
			$meta_info = $meta_info[0];
		}
        
        $data['meta_title'] = (isset($meta_info->meta_title) && !empty($meta_info->meta_title))?$meta_info->meta_title:'Blog';
        $data['meta_desc'] = (isset($meta_info->meta_desc) && !empty($meta_info->meta_desc))?$meta_info->meta_desc:'Blog';
        $data['meta_keyword'] = (isset($meta_info->meta_keyword) && !empty($meta_info->meta_keyword))?$meta_info->meta_keyword:'';
        
        
        $select_fld = 'a.`id`, a.`b_title`, a.`b_image`,a.`b_slug`, a.`b_content`, a.`created_at`';
        $records = $this->my_model->getArticles($select_fld);
        
        //echo '<pre>';print_r($records);die;
        $data['records'] = $records;

        $cond =" AND `banner_section` =  3";
        $banners = $this->pages_model->getBanners('banner_image',$cond);
        $data['banners'] = $banners;

        $data['include']        = $this->viewDirectory . '\article_list_views';

		return view('container', $data);
        
    }

    public function article_details() {        

        $current_url = current_url(true);               
        $slug = $current_url->getSegment(3);

        $cond = " AND `b_slug` = '".$slug."'";
        $select_fld = '`id`, `b_title`, `b_slug`, `b_image`, `b_content`, `created_at`, `b_cat_id`,`meta_title`,`meta_keyword`,`meta_desc`';
        $records = $this->my_model->getSingleRecord('post',$select_fld,$cond);
        if(!is_object($records)){
            return redirect()->to('blog')->withCookies();
        }       
        

        $data['meta_title'] = (isset($records->meta_title))?$records->meta_title:$records->b_title;
        $data['meta_desc'] = (isset($records->meta_desc))?$records->meta_desc:$records->b_title;
        $data['meta_keyword'] = (isset($records->meta_keyword))?$records->meta_keyword:'';
        
        //echo '<pre>';print_r($records);die;
        $cond =" AND `banner_section` = 4 ";
        $banners = $this->pages_model->getBanners('banner_image',$cond);
        $data['banners'] = $banners;

        $data['records'] = $records;
        $data['include'] = $this->viewDirectory . '\article_detail_views';
		return view('container', $data);        
    }

       
}