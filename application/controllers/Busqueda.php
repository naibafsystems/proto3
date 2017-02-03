<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Busqueda extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->model('M_comisiones');
        $this->load->model('M_tema');
        $this->load->model('M_criterio');
        $this->load->model('M_aspectos');
        $this->load->model('M_estado');
        $this->template->set_layout('layout_gen_tbl.php');
        date_default_timezone_set('America/Bogota');
    }

    public function index() {
        
        $data = array();
        
        $this->template->title('Comisiones');
        $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
            <script src='" . base_url() . "public/js/comisiones_list.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
        $this->template->build('comisiones/view_search_perfil', $data);
    }
}