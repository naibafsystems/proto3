<?php
require(APPPATH.'libraries/REST_Controller.php');
 
class Services_rest extends REST_Controller {
 
    function user_get()
    {
        $this->load->model('M_services');
        $id = $this->get('id');
        
        $data = $this->M_services->get_user_crm($id);
        
        if($data){
            $this->response($data, 200);
        }else{
            $this->response(NULL, 404);
        }
    }
     
    function users_get()
    {
        $this->load->model('M_services');
        $data = $this->M_services->get_todos_crm();
        if($data){
            $this->response($data, 200);
        }else{
            $this->response(NULL, 404);
        }
        //$data = array('returned: '. $this->get('id'));
    }
}
