<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;
use Config\Services;
use Modules\Admin\Models\ProductgalleryModel;

class Productgallery extends BackendController {

    protected $viewDirectory;
    protected $my_model;
    protected $helpers = ['form'];
    protected $login_admin_id;
    protected $current_date_time;

    public function __construct(){
        $this->session = Services::session();
        $admin_auth = new Adminauth();
        $admin_auth->isAdminLoggedIn();
        $this->login_admin_id = session()->get('admin_id');
        $this->current_date_time = date('Y-m-d H:i:s');
        $this->my_model = new ProductgalleryModel();

        $uri = current_url(true);
        $module_name = ucfirst($uri->getSegment(1));
        $module_view_folder = ucfirst($uri->getSegment(2));
        $this->viewDirectory = 'Modules/'. $module_name.'/Views/'.$module_view_folder;
    }

    public function index() {
        $data['pager'] = $this->my_model->pager;
        $data['curr_paging'] = $this->request->getVar('page');
        $data['meta_title'] = 'Product Gallery';
        $data['meta_desc'] = 'Product Gallery';
        $data['meta_keyword'] = 'Product Gallery';

        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){
            $this->my_model->updateStatus($action_type,$arr_ids);
            $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            return redirect()->to(site_url('admin/productgallery'));
        }

        $keyword = '';
        $status = '';
        $product_id = '';
        $like_cond =[];
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['tbl_products_gallery.name'] = $keyword = $this->request->getVar('keyword');
        }
        if($this->request->getVar('product_id')!=NULL){
            $like_cond['tbl_products_gallery.product_id'] = $product_id = $this->request->getVar('product_id');
        }

        $cond['tbl_products_gallery.status !='] = 2;
        if($this->request->getVar('status')!=NULL){
            $cond['tbl_products_gallery.status'] = $status = $this->request->getVar('status');
        }

        $data['keyword'] = $keyword;
        $data['product_id'] = $product_id;
        $data['status'] = $status;

        $per_page = config('MyApplication')->admin_per_page;
        $results = $this->my_model->getRecord($cond,$like_cond,$per_page);
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];
        $data['page_heading'] = 'Product Gallery';

        return view($this->viewDirectory . '\list_view', $data);
    }

    public function edit($id = null){
        $uri = current_url(true);
        $id = (int)($id !== null ? $id : $uri->getSegment(4));
        $row = $this->my_model->getSingleRecord($id);
        $data['row'] = $row;
        $data['curr_page'] = ($this->request->getVar('page')!=NULL)?$this->request->getVar('page'):'';
        $data['validation'] = [];

        if(!is_object($row)){
            $this->session->setFlashData("error", "Invalid Id.");
            return redirect()->to(site_url('admin/productgallery'));
        }

        if ($this->request->is('post')) {
            $validation = service('validation');
            $rules = [
                "id" => ["label" => "Id", "rules" => "max_length[19]|is_natural_no_zero"],
                "name" => ["label" => "name", "rules" => "required|min_length[3]|max_length[200]"],
                "product_id" => ["label" => "product", "rules" => "required"],
            ];

            $photo = $this->request->getFile('photo');
            if ($photo && $photo->isValid() && $photo->getError() === UPLOAD_ERR_OK) {
                $rules['photo'] = ["label" => "Photo", "rules" => "uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/gif,image/png,image/webp]"];
            }

            if ($this->validate($rules)) {
                $postdata = [
                    "name" => $this->request->getPost("name"),
                    "product_id" => $this->request->getPost("product_id"),
                ];

                $img = $this->request->getFile('photo');
                if ($img && $img->isValid() && ! $img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move(FCPATH . 'uploads/productsgallery/', $newName);
                    $postdata['photo'] = $newName;
                    $old_img_path = FCPATH . 'uploads/productsgallery/'.$row->photo;
                    if(!empty($row->photo) && is_file($old_img_path)){
                        unlink($old_img_path);
                    }
                }

                $this->my_model->updateRecord($postdata,$row->id);
                $this->session->setFlashData("success", "Record has been updated successfully.");
                $redirect_url = site_url('admin/productgallery');
                if($this->request->getPost('page')!=NULL){
                    $redirect_url .='?page='.$this->request->getPost('page');
                }
                return redirect()->to($redirect_url);
            }else{
                $data["validation"] = $validation->getErrors();
            }
        }

        $data['product_list'] = $this->my_model->getProducts();
        $data['meta_title'] = 'Edit Product Gallery';
        $data['meta_desc'] = 'Edit Product Gallery';
        $data['meta_keyword'] = 'Edit Product Gallery';
        $data['page_heading'] = 'Edit Product Gallery';
        return view($this->viewDirectory . '\edit_view', $data);
    }

    public function add(){
        if ($this->request->is('post')) {
            $validation = service('validation');
            $rules = [
                "name" => ["label" => "name", "rules" => "required|min_length[3]|max_length[200]"],
                "product_id" => ["label" => "product", "rules" => "required"],
                "photo" => ["label" => "Photo", "rules" => "uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/gif,image/png,image/webp]"],
            ];

            if ($this->validate($rules)) {
                $newName = '';
                $img = $this->request->getFile('photo');
                if ($img && $img->isValid() && ! $img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move(FCPATH . 'uploads/productsgallery/', $newName);
                }

                $display_order = $this->my_model->getDisplayOrder()+1;
                $postdata = [
                    "name" => $this->request->getPost("name"),
                    "product_id" => $this->request->getPost("product_id"),
                    "disp_order" => $display_order,
                    "photo" => $newName,
                    "status" => 1,
                    "created_at" => $this->current_date_time
                ];
                $this->my_model->addRecord($postdata);
                $this->session->setFlashData("success", "Record has been added successfully.");
                return redirect()->to(site_url('admin/productgallery'));
            }else{
                $data["validation"] = $validation->getErrors();
            }
        }

        $data['product_list'] = $this->my_model->getProducts();
        $data['meta_title'] = 'Add Product Gallery';
        $data['meta_desc'] = 'Add Product Gallery';
        $data['meta_keyword'] = 'Add Product Gallery';
        $data['page_heading'] = 'Add Product Gallery';
        return view($this->viewDirectory . '\add_view', $data);
    }

    public function delete($id = null){
        $uri = current_url(true);
        $id = (int)($id !== null ? $id : $uri->getSegment(4));
        $this->my_model->deleteRecord($id);
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        return redirect()->to(site_url('admin/productgallery'));
    }
}
