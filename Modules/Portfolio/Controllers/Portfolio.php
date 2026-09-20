<?php
namespace Modules\Portfolio\Controllers;
use App\Controllers\FrontendController;

use Config\Services;

use Modules\Portfolio\Models\PortfolioModel;

class Portfolio extends FrontendController {

    protected $viewDirectory;
    protected $my_model;
    protected $helpers = ['form'];

    public function __construct(){

        $this->my_model = new PortfolioModel();       

        $module_name = 'Portfolio';

        $this->viewDirectory = 'Modules/'. $module_name.'/Views';
    }
    
    public function index() {
        
        $data['meta_title'] = 'Portfolio';
        $data['meta_desc'] = '';
        $data['meta_keyword'] = '';

        $cond = ['status'=>1];
        $select_fld = '`id`, `title`, `portfolio_image`, `tags`, `country_name`, `description`';
        $data['records'] = $this->my_model->getRecords($select_fld);

        $data['include']        = $this->viewDirectory . '\portfolio_views';

		return view('container', $data);
        
    }
       
}