<?php
namespace Modules\Products\Controllers;
use App\Controllers\FrontendController;
use Modules\Products\Models\ProductsModel;
use Modules\Pages\Models\PagesModel;
use App\Libraries\MyLibrary;

class Products extends FrontendController {

    protected $viewDirectory;
    protected $my_model;
    protected $pages_model;
    protected $mylib;
    protected $helpers = ['form'];

    public function __construct(){
        $this->my_model = new ProductsModel();
        $this->pages_model = new PagesModel();
        $this->mylib = new MyLibrary();
        $this->viewDirectory = 'Modules/Products/Views';
    }

    public function index(){
        $data['meta_title'] = 'Inventory | Certified Pre-Owned Vehicles | Sirius Motorsports Inc.';
        $data['meta_desc'] = 'Browse the full inventory at Sirius Motorsports Inc. — certified pre-owned vehicles in Tillsonburg, Ontario.';
        $data['meta_keyword'] = 'Used Cars Ontario, Certified Pre-Owned Vehicles, Inventory';
        $data['page_title'] = 'Our Inventory';
        $data['products'] = $this->my_model->attachGalleries($this->my_model->getRecords('*', '', 100));
        $data['mylib'] = $this->mylib;
        $data['include'] = $this->viewDirectory . '\inventory_views';
        return view('container', $data);
    }
}
