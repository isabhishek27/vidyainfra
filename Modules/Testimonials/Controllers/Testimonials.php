<?php
namespace Modules\Testimonials\Controllers;
use App\Controllers\FrontendController;

use Config\Services;

use Modules\Testimonials\Models\TestimonialsModel;

class Testimonials extends FrontendController {

    protected $viewDirectory;
    protected $my_model;
    protected $helpers = ['form'];

    public function __construct(){

        $this->my_model = new TestimonialsModel();

        // $uri = current_url(true);               
        // $module_name = ucfirst($uri->getSegment(1));
        // if(empty($module_name)){
        //     $module_name = 'Pages';
        // }
        $module_name = 'Testimonials';

        $this->viewDirectory = 'Modules/'. $module_name.'/Views';
    }
    
    public function index() {
        
        $data['meta_title'] = 'Testimonials';
        $data['meta_desc'] = '';
        $data['meta_keyword'] = '';
        
        $select_fld = '`id`, `name`, `email`, `contact_number`, `testimonial`, `testimonial_rating`';
        $records = $this->my_model->getRecords($select_fld);
        //echo '<pre>';print_r($records);die;
        $data['records'] = $records;
        $data['include']        = $this->viewDirectory . '\testimonials_views';

		return view('container', $data);
        
    }

    public function post_testimonials(){
        if ($this->request->isAJAX()) {

            $t_name = $this->request->getPost('t_name');                        
            $email = $this->request->getPost('email');
            $testimonial = $this->request->getPost('testimonial');
            
            //echo '<pre>';print_r( $this->request->getPost());  die;
            $return_data=['status'=>0,'msg'=>'Errors! Something went wrong.'];

            $insert_data = ['name'=>$t_name, 'email'=>$email, 'testimonial'=>$testimonial,'testimonial_by'=>'0', 'created_at'=>date('Y-m-d H:i:s')];
           
            $insert_id = $this->my_model->addTesimonial($insert_data);
            
            if($insert_id){
                $return_data=['status'=>1,'msg'=>'Testimonial added.'];   
            }

            
            $return_data = json_encode($return_data);
            echo $return_data;
            
        }
    }
       
}