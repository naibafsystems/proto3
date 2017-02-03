<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->model('M_admin');
        $this->load->model('M_perfil');
        $this->load->model('Usuario');
        $this->template->set_layout('layout_gen_tbl.php');
        date_default_timezone_set('America/Bogota');
    }

    public function index() {
        
    }

    public function noejecutadas() {
        
        $data = "";
        $data['listado'] = $this->M_admin->get_no_ejecutadas();

        $this->template->title('Comisiones no ejecutadas');
        $this->template->append_metadata("<script type='text/javascript' src='" . base_url() . "public/js/datatables.min.js'></script>
        <script type='text/javascript' src='" . base_url() . "public/js/comisiones_list.js'></script></script><script type='text/javascript' src='" . base_url() . "public/js/estilos.js'></script>");
        $this->template->build('admin/view_list_no_ejecutadas', $data);
    }
    
    public function update_ejecutadas($id) {
        
        //$id = $this->input->post("id");
        if ($id == NULL || !is_numeric($id)) {
            echo "Id Invalido";
        } else {
            $this->M_admin->update_no_ejecutadas($id);
            redirect('Admin/noejecutadas');
        }
    }
    
    public function usuarios() {
        $data = "";
        $data['usuarios'] = $this->M_admin->users();
        
        foreach ($data['usuarios'] as $Usuario){
            $Respuesta = $this->Usuario->get_user_crm($Usuario->usuario);
            $Usuario->nombrefull = "";
            $Usuario->Grupo = "";
            $Usuario->Dependencia = "";
            $Usuario->Despacho = "";
            if(is_array($Respuesta)){
                if($Respuesta != null){
                    $ident = $Respuesta[0]->NUM_IDENT;
                    if($ident != null){
                                
                        $Nombres = $Respuesta[0]->NOM_USUARIO." ".$Respuesta[0]->APE_USUARIO;
                        if($Nombres != NULL){
                            $Usuario->nombrefull = $Nombres;
                        }
                        $data['datos_perfil'] = $this->M_perfil->get_document_crm($ident);
                        
                        $DepUsuario = $data['datos_perfil'][0]->DEP_USUARIO;
                        
                        if($DepUsuario != null){
                            $data['grupo'] = $this->M_perfil->get_adicionales_crm($DepUsuario);
                            if($data['grupo'][0]->DESCRIPCION != NULL){
                                $Usuario->Grupo = $data['grupo'][0]->DESCRIPCION;
                            }

                            $DependenciaUsuario = $data['grupo'][0]->ANTECESOR;
                            $data['dependencia'] = $this->M_perfil->get_adicionales_crm($DependenciaUsuario);
                            if($data['dependencia'][0]->DESCRIPCION != NULL){
                                $Usuario->Dependencia = $data['dependencia'][0]->DESCRIPCION;
                            }

                            $Despacho = $data['dependencia'][0]->ANTECESOR;
                            $data['despacho'] = $this->M_perfil->get_adicionales_crm($Despacho);
                            if($data['despacho'][0]->DESCRIPCION != NULL){
                                $Usuario->Despacho = $data['despacho'][0]->DESCRIPCION;
                            }
                        }
                    }
                }
            }
        }
        
        $this->template->build('admin/view_list_usuarios', $data);
    }
}
