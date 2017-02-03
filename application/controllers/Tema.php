<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tema extends CI_Controller {
    
        public function __construct(){
            parent::__construct();
            $this->load->helper('form');
            $this->load->model('M_tema');
            $this->template->set_layout('layout_gen_tbl.php');
        }
        
        public function index(){
            
        	$data['listado'] = $this->M_tema->get_todos();
        	//$this->load->view('view_list_tema', $data);
            
            $this->template->title('Temas Creados');
            $this->template->append_metadata("<script src='".base_url()."public/js/datatables.min.js'></script>
            <script src='".base_url()."public/js/temas_list.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
            $this->template->build('admin/view_list_tema', $data);
        }
        
        public function agregar(){
            if($this->input->post()){
                $id_insertado = $this->M_tema->add();
                redirect('tema');   
            }else{
                $this->load->view('view_form_tema');    
            }
		}
        
        public function editar(){
            $id = $this->input->post('idtema');
            
            if($id == NULL || !is_numeric($id)){
                echo "Id Invalido";
                return;
            }else{
                $data['datos_tema'] = $this->M_tema->get_by_id($id);
                if(empty($data['datos_tema'])){
                    echo "Id es Invalido";
                }else{
                    if($this->input->post()){
                        $id = $this->input->post('idtema');
                        $datos_insertar['tema'] = $this->input->post('temae');
                        $datos_insertar['detalle_tema'] = $this->input->post('detalle_temae');
                        $datos_insertar['tipo_tema'] = $this->input->post('tipo_temae');
                        
                        $this->M_tema->edit($datos_insertar, $id);
                        redirect('tema');
                    }else{
                        $this->load->view('view_form_tema',$data);    
                    }
                }
            }
        }
        
        public function eliminar(){
            $id = $this->input->post('idtemab');
            
            if($id == NULL || !is_numeric($id)){
                echo "Id Invalido";
                return;
            }else{
                $data['datos_tema'] = $this->M_tema->get_by_id($id);
                if(empty($data['datos_tema'])){
                    echo "Id es Invalido";
                }else{
                    if($this->input->post()){
                        $id_eliminar = $this->input->post('con_id');
                        $this->M_tema->delete($id);
                        redirect('tema');
                    }else{
                        $this->load->view('view_delete_tema',$data);    
                    }
                }
            }
        }
}
