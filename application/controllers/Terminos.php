<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Terminos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->model('M_perfil');
        date_default_timezone_set('America/Bogota');
    }

    public function index() {
        if ($this->session->userdata('terminos') == false) {
            $this->template->set_layout('layout_terminos.php');
            
            $data['error'] = "";

            $this->template->title('Terminos y condiciones');
            $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
            <script src='" . base_url() . "public/js/terminos.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
            $this->template->build('Terminos/view_terminos_condiciones', $data);
        }else{
            redirect(base_url('index.php/perfil/validateident'));
        } 
    }
    
    public function aceptar_terminos(){
        if ($this->session->userdata('logueado')) {
            
            $IdUser = $this->session->userdata('id_user');
            $Estado = 1;
            $this->M_perfil->update_terminos($IdUser,$Estado);
            
            $usuario_data = array(
                'terminos' => true
            );
            
            $this->session->set_userdata($usuario_data);
            
            redirect(base_url('index.php/perfil/validateident'));
        }     
    }
    
    public function resetear_terminos(){
        if ($this->session->userdata('logueado')) {
            
            $IdUser = $this->session->userdata('id_user');
            $Estado = 2;
            $this->M_perfil->update_terminos($IdUser,$Estado);
            
            $usuario_data = array(
                'terminos' => true
            );
            
            $this->session->set_userdata($usuario_data);
            
            redirect('http://somos.dane.gov.co/user/logout');
        }     
    }
}
