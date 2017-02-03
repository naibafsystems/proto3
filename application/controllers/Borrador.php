<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Borrador extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->model('M_comisiones');
        $this->load->model('M_tema');
        $this->load->model('M_criterio');
        $this->load->model('M_aspectos');
        $this->load->model('M_estado');
        $this->load->model('M_borrador');
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

    public function borrador() {
        $Formulario = $this->input->post();

        $Interno_gen = $this->input->post('interno_gen');
        $Interno_enc = $this->input->post('interno_enc');
        $Vigencia = $this->input->post('vigencia');
        $Cod_unidad = $this->input->post('cod_unidad');
        $IdUser = $this->session->userdata('id_user');
        
        //header('Content-type: application/json; charset=utf-8');
        $FileJson = json_encode($Formulario, JSON_FORCE_OBJECT);
        $filename = $Interno_gen . $Interno_enc . $Vigencia . $Cod_unidad . $IdUser . ".json";
        $mode = "w+";

        $Ruta = dirname(FCPATH);
        $RutaFull = $Ruta . "/comisiones/uploads/borrador/" . $filename;
        
        //$Rutanwe = file_get_contents(base_url());

        $fp = fopen($RutaFull, $mode);

        if ($fp) {
            fwrite($fp, $FileJson);
        } else {
            throw new Exception("La pagina no fue posible abrirla");
        }

        echo $FileJson;
        //header('Content-type: application/json; charset=utf-8');
        //echo json_encode($fp, JSON_FORCE_OBJECT);
    }

}
