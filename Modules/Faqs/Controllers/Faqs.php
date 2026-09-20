<?php
namespace Modules\Faqs\Controllers;
use App\Controllers\FrontendController;

use Config\Services;

use Modules\Faqs\Models\FaqsModel;

class Faqs extends FrontendController {

    protected $viewDirectory;
    protected $my_model;
    protected $helpers = ['form'];

    public function __construct(){

        $this->my_model = new FaqsModel();

        // $uri = current_url(true);               
        // $module_name = ucfirst($uri->getSegment(1));
        // if(empty($module_name)){
        //     $module_name = 'Pages';
        // }
        $module_name = 'Faqs';

        $this->viewDirectory = 'Modules/'. $module_name.'/Views';
    }
    
    public function index() {
        
        $data['meta_title'] = 'Faqs';
        $data['meta_desc'] = '';
        $data['meta_keyword'] = '';

        $cond = ['status'=>1];
        $select_fld = '`id`, `question`, `answer`';
        $records = $this->my_model->getRecords($select_fld);
        //echo '<pre>';print_r($records);die;
        $data['records'] = $records;
        $data['include']        = $this->viewDirectory . '\faqs_views';

		return view('container', $data);
        
    }
       
}