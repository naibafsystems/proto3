<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comision extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('M_comision');
    }
    
    public function index(){
    	$data['listado'] = $this->M_comision->get_todos();
    	$this->load->view('view_list_comision', $data);
    }
    
    public function agregar(){
        if($this->input->post()){
            $id_insertado = $this->M_comision->add();
            redirect('Comision');   
        }else{
            $this->load->view('view_form_comision');    
        }
	}
    
    public function editar($id = NULL){
        if($id == NULL || !is_numeric($id)){
            echo "Id Invalido";
            return;
        }else{
            $data['datos_comision'] = $this->M_comision->get_by_id($id);
            if(empty($data['datos_comision'])){
                echo "Id es Invalido";
            }else{
                if($this->input->post()){
                    $this->M_comision->edit($id);
                    redirect('Comision');
                }else{
                    $this->load->view('view_form_comision',$data);    
                }
            }
        }
    }
    
    public function eliminar($id = NULL){
        if($id == NULL || !is_numeric($id)){
            echo "Id Invalido";
            return;
        }else{
            $data['datos_comision'] = $this->M_comision->get_by_id($id);
            if(empty($data['datos_comision'])){
                echo "Id es Invalido";
            }else{
                if($this->input->post()){
                    $id_eliminar = $this->input->post('con_id');
                    $this->M_comision->delete($id);
                    redirect('Comision');
                }else{
                    $this->load->view('view_delete_comision',$data);    
                }
            }
        }
    }
}