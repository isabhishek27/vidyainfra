<?php
namespace Modules\Admin\Controllers;

use App\Controllers\BackendController;
use Modules\Admin\Libraries\Adminauth;
use Config\Services;
use Modules\Admin\Models\ProductModel;

class Product extends BackendController {

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
        $this->my_model = new ProductModel();

        $uri = current_url(true);
        $module_name = ucfirst($uri->getSegment(1));
        $module_view_folder = ucfirst($uri->getSegment(2));
        $this->viewDirectory = 'Modules/'. $module_name.'/Views/'.$module_view_folder;
    }

    public function index() {
        $data['pager'] = $this->my_model->pager;
        $data['curr_paging'] = $this->request->getVar('page');
        $data['meta_title'] = 'Inventory / Products';
        $data['meta_desc'] = 'Inventory / Products';
        $data['meta_keyword'] = 'Inventory / Products';

        $arr_ids = $this->request->getPost('arr_ids');
        $action_type = $this->request->getPost('action_type');
        if($action_type === 'update_order'){
            $orders = $this->request->getPost('disp_order');
            if(is_array($orders) && count($orders) > 0){
                $this->my_model->updateDisplayOrder($orders);
                $this->session->setFlashData("success", "Display order has been updated successfully.");
            }
            return redirect()->to(site_url('admin/product'));
        }
        if($action_type !=NULL && $arr_ids !=NULL && is_array($arr_ids) && count($arr_ids)>0){
            if(in_array($action_type, ['set_featured', 'unset_featured'], true)){
                $this->my_model->updateFeatured($action_type, $arr_ids);
                $msg = ($action_type === 'set_featured')
                    ? 'Selected record(s) have been set as featured successfully.'
                    : 'Selected record(s) have been unset from featured successfully.';
                $this->session->setFlashData("success", $msg);
            }else{
                $this->my_model->updateStatus($action_type,$arr_ids);
                $this->session->setFlashData("success", "Record has been ".$action_type."d successfully.");
            }
            return redirect()->to(site_url('admin/product'));
        }

        $keyword = '';
        $status = '';
        $stock_status = '';
        $like_cond =[];
        if($this->request->getVar('keyword')!=NULL){
            $like_cond['tbl_products.name'] = $keyword = $this->request->getVar('keyword');
        }
        $cond['tbl_products.status !='] = 2;

        if($this->request->getVar('status')!=NULL){
            $cond['tbl_products.status'] = $status = $this->request->getVar('status');
        }
        if($this->request->getVar('stock_status')!=NULL){
            $cond['tbl_products.stock_status'] = $stock_status = $this->request->getVar('stock_status');
        }

        $data['keyword'] = $keyword;
        $data['status'] = $status;
        $data['stock_status'] = $stock_status;

        $per_page = config('MyApplication')->admin_per_page;
        $results = $this->my_model->getRecord($cond,$like_cond,$per_page);
        $data['result'] = $results['data'];
        $data['links'] = $results['links'];
        $data['page_heading'] = 'Inventory / Products';

        return view($this->viewDirectory . '\list_view', $data);
    }

    public function edit($id = null){
        $uri = current_url(true);
        $id = (int)($id !== null ? $id : $uri->getSegment(4));
        $row = $this->my_model->getSingleRecord($id);
        $data['row'] = $row;
        $data['curr_page'] = ($this->request->getVar('page')!=NULL)?$this->request->getVar('page'):'';
        $data['validation'] = [];
        $data['gallery'] = $this->my_model->getGalleryByProduct($id);

        if(!is_object($row)){
            $this->session->setFlashData("error", "Invalid Id.");
            return redirect()->to(site_url('admin/product'));
        }

        if ($this->request->is('post')) {
            $validation = service('validation');
            $rules = [
                "id" => ["label" => "Id", "rules" => "max_length[19]|is_natural_no_zero"],
                "name" => ["label" => "Vehicle title", "rules" => "required|min_length[3]|max_length[200]|is_unique[tbl_products.name,tbl_products.id,{id}]"],
                "price" => ["label" => "Price", "rules" => "required|decimal|greater_than_equal_to[0]"],
                "stock_status" => ["label" => "Stock status", "rules" => "required|in_list[available,sold]"],
                "transmission" => ["label" => "Transmission", "rules" => "permit_empty|max_length[50]"],
                "mileage" => ["label" => "Mileage", "rules" => "permit_empty|max_length[50]"],
                "meta_title" => ["label" => "Meta title", "rules" => "max_length[200]"],
                "meta_desc" => ["label" => "Meta description", "rules" => "max_length[250]"],
                "meta_keyword" => ["label" => "Meta keyword", "rules" => "max_length[200]"],
            ];

            $remove_primary = (int)$this->request->getPost('remove_primary') === 1;
            $remove_gallery = $this->request->getPost('remove_gallery');
            if(!is_array($remove_gallery)){
                $remove_gallery = [];
            }
            $new_photos = $this->collectValidPhotos('photos');
            $photo_error = $this->validatePhotoUpload($new_photos, false);

            $existing_count = (!empty($row->photo) && !$remove_primary) ? 1 : 0;
            foreach($data['gallery'] as $g){
                if(!in_array((string)$g->id, array_map('strval', $remove_gallery), true)){
                    $existing_count++;
                }
            }
            if(($existing_count + count($new_photos)) > 8){
                $photo_error = 'Maximum 8 photos allowed per vehicle.';
            }
            if(($existing_count + count($new_photos)) < 1){
                $photo_error = 'At least one photo is required.';
            }

            if ($this->validate($rules) && $photo_error === '') {
                $postdata = [
                    "name" => $this->request->getPost("name"),
                    "url_slug" => url_title($this->request->getPost("name"),'-',true),
                    "subtitle" => $this->request->getPost("subtitle"),
                    "price" => $this->request->getPost("price"),
                    "price_note" => $this->request->getPost("price_note"),
                    "mileage" => $this->request->getPost("mileage"),
                    "exterior_color" => $this->request->getPost("exterior_color"),
                    "interior_color" => $this->request->getPost("interior_color"),
                    "transmission" => $this->request->getPost("transmission"),
                    "stock_status" => $this->request->getPost("stock_status"),
                    "is_featured" => (int)$this->request->getPost("is_featured"),
                    "is_certified" => (int)$this->request->getPost("is_certified"),
                    "year" => $this->request->getPost("year"),
                    "make" => $this->request->getPost("make"),
                    "model" => $this->request->getPost("model"),
                    "product_desc" => $this->request->getPost("product_desc"),
                    "meta_title" => $this->request->getPost("meta_title"),
                    "meta_desc" => $this->request->getPost("meta_desc"),
                    "meta_keyword" => $this->request->getPost("meta_keyword"),
                ];

                if($remove_primary && !empty($row->photo)){
                    $old_img_path = FCPATH . 'uploads/products/'.$row->photo;
                    if(is_file($old_img_path)){
                        unlink($old_img_path);
                    }
                    $postdata['photo'] = '';
                    $row->photo = '';
                }

                foreach($remove_gallery as $gid){
                    $this->my_model->deleteGalleryImage((int)$gid, $row->id);
                }

                $this->my_model->updateRecord($postdata, $row->id);
                $this->saveProductPhotos($row->id, $new_photos, true);

                $this->session->setFlashData("success", "Record has been updated successfully.");
                $redirect_url = site_url('admin/product');
                if($this->request->getPost('page')!=NULL){
                    $redirect_url .='?page='.$this->request->getPost('page');
                }
                return redirect()->to($redirect_url);
            }else{
                $data["validation"] = $validation->getErrors();
                if($photo_error !== ''){
                    $data["validation"]['photos'] = $photo_error;
                }
            }
        }

        $data['gallery'] = $this->my_model->getGalleryByProduct($id);
        $data['meta_title'] = 'Edit Product';
        $data['meta_desc'] = 'Edit Product';
        $data['meta_keyword'] = 'Edit Product';
        $data['page_heading'] = 'Edit Product';
        return view($this->viewDirectory . '\edit_view', $data);
    }

    public function add(){
        $data['validation'] = [];
        if ($this->request->is('post')) {
            $validation = service('validation');
            $rules = [
                "name" => ["label" => "Vehicle title", "rules" => "required|min_length[3]|max_length[200]|is_unique[tbl_products.name]"],
                "price" => ["label" => "Price", "rules" => "required|decimal|greater_than_equal_to[0]"],
                "stock_status" => ["label" => "Stock status", "rules" => "required|in_list[available,sold]"],
                "meta_title" => ["label" => "Meta title", "rules" => "max_length[200]"],
                "meta_desc" => ["label" => "Meta description", "rules" => "max_length[250]"],
                "meta_keyword" => ["label" => "Meta keyword", "rules" => "max_length[200]"],
            ];

            $new_photos = $this->collectValidPhotos('photos');
            $photo_error = $this->validatePhotoUpload($new_photos, true);

            if ($this->validate($rules) && $photo_error === '') {
                $display_order = $this->my_model->getDisplayOrder()+1;
                $postdata = [
                    "name" => $this->request->getPost("name"),
                    "url_slug" => url_title($this->request->getPost("name"),'-',true),
                    "subtitle" => $this->request->getPost("subtitle"),
                    "photo" => '',
                    "price" => $this->request->getPost("price"),
                    "price_note" => $this->request->getPost("price_note"),
                    "mileage" => $this->request->getPost("mileage"),
                    "exterior_color" => $this->request->getPost("exterior_color"),
                    "interior_color" => $this->request->getPost("interior_color"),
                    "transmission" => $this->request->getPost("transmission"),
                    "stock_status" => $this->request->getPost("stock_status"),
                    "is_featured" => (int)$this->request->getPost("is_featured"),
                    "is_certified" => (int)$this->request->getPost("is_certified"),
                    "year" => $this->request->getPost("year"),
                    "make" => $this->request->getPost("make"),
                    "model" => $this->request->getPost("model"),
                    "product_desc" => $this->request->getPost("product_desc"),
                    "disp_order" => $display_order,
                    "status" => 1,
                    "created_at" => $this->current_date_time,
                    "meta_title" => $this->request->getPost("meta_title"),
                    "meta_desc" => $this->request->getPost("meta_desc"),
                    "meta_keyword" => $this->request->getPost("meta_keyword"),
                ];
                $product_id = $this->my_model->addRecord($postdata);
                $this->saveProductPhotos($product_id, $new_photos, false);
                $this->session->setFlashData("success", "Record has been added successfully.");
                return redirect()->to(site_url('admin/product'));
            }else{
                $data["validation"] = $validation->getErrors();
                if($photo_error !== ''){
                    $data["validation"]['photos'] = $photo_error;
                }
            }
        }

        $data['meta_title'] = 'Add Product';
        $data['meta_desc'] = 'Add Product';
        $data['meta_keyword'] = 'Add Product';
        $data['page_heading'] = 'Add Product';
        return view($this->viewDirectory . '\add_view', $data);
    }

    public function delete($id = null){
        $uri = current_url(true);
        $id = (int)($id !== null ? $id : $uri->getSegment(4));
        $this->my_model->deleteRecord($id);
        $this->session->setFlashData("success", "Record has been deleted successfully.");
        return redirect()->to(site_url('admin/product'));
    }

    private function collectValidPhotos(string $field): array
    {
        $files = $this->request->getFileMultiple($field);
        $valid = [];
        if(!is_array($files)){
            return $valid;
        }
        foreach($files as $file){
            if($file && $file->isValid() && !$file->hasMoved() && $file->getError() === UPLOAD_ERR_OK){
                $valid[] = $file;
            }
        }
        return $valid;
    }

    private function validatePhotoUpload(array $files, bool $required): string
    {
        if($required && count($files) === 0){
            return 'Please upload at least one photo.';
        }
        if(count($files) > 8){
            return 'Maximum 8 photos allowed.';
        }
        $allowed = ['image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'image/webp'];
        foreach($files as $file){
            $mime = $file->getMimeType();
            if(!in_array($mime, $allowed, true) && !$file->isValid()){
                return 'Only JPG, JPEG, PNG, GIF or WEBP images are allowed.';
            }
            if(!in_array($mime, $allowed, true)){
                // fallback: trust is_image when mime sniffing varies
                $ext = strtolower($file->getExtension());
                if(!in_array($ext, ['jpg','jpeg','png','gif','webp'], true)){
                    return 'Only JPG, JPEG, PNG, GIF or WEBP images are allowed.';
                }
            }
        }
        return '';
    }

    private function saveProductPhotos(int $product_id, array $files, bool $is_edit): void
    {
        if($product_id <= 0 || count($files) === 0){
            if($is_edit){
                $this->ensurePrimaryPhoto($product_id);
            }
            return;
        }

        $row = $this->my_model->getSingleRecord($product_id);
        $has_primary = is_object($row) && !empty($row->photo);
        $order = $this->my_model->getNextGalleryOrder($product_id);

        foreach($files as $file){
            if(!$file->isValid() || $file->hasMoved()){
                continue;
            }
            if(!$has_primary){
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/products/', $newName);
                $this->my_model->updateRecord(['photo' => $newName], $product_id);
                $has_primary = true;
            }else{
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/productsgallery/', $newName);
                $this->my_model->addGalleryImage([
                    'product_id' => $product_id,
                    'name' => 'Gallery',
                    'photo' => $newName,
                    'disp_order' => $order++,
                    'status' => 1,
                    'created_at' => $this->current_date_time,
                ]);
            }
        }

        if($is_edit){
            $this->ensurePrimaryPhoto($product_id);
        }
    }

    private function ensurePrimaryPhoto(int $product_id): void
    {
        $row = $this->my_model->getSingleRecord($product_id);
        if(!is_object($row) || !empty($row->photo)){
            return;
        }
        $gallery = $this->my_model->getGalleryByProduct($product_id);
        if(empty($gallery)){
            return;
        }
        $first = $gallery[0];
        $src = FCPATH . 'uploads/productsgallery/'.$first->photo;
        $dest_name = $first->photo;
        $dest = FCPATH . 'uploads/products/'.$dest_name;
        if(is_file($src)){
            @rename($src, $dest);
        }
        $this->my_model->updateRecord(['photo' => $dest_name], $product_id);
        $this->my_model->deleteGalleryImage((int)$first->id, $product_id);
    }
}
