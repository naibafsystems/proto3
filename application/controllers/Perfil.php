<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->model('M_perfil');
        $this->template->set_layout('layout_perfil.php');
        date_default_timezone_set('America/Bogota');
    }

    public function index() {
        if ($this->session->userdata('logueado')) {
            $Documento = $this->session->identificacion;

            if ($Documento != null) {
                $data['datos_perfil'] = $this->M_perfil->get_document_crm($Documento);
                //$data['datos_idiomas'] = $this->M_perfil->get_idiomas_crm($data['datos_perfil'][0]->ID_USUARIO);
                //$data['datos_estudios'] = $this->M_perfil->get_estudios_crm($data['datos_perfil'][0]->ID_USUARIO);
                $data['categorias'] = $this->M_perfil->get_categorias_cono($this->session->id_user);
                $data['sofware'] = $this->M_perfil->get_software($this->session->id_user);
                $data['aporte'] = $this->M_perfil->get_adicional($this->session->id_user);

                if ($data['datos_perfil'] != null) {

                    $data['datos_idiomas'] = $this->M_perfil->get_idiomas_crm($data['datos_perfil'][0]->ID_USUARIO);
                    $data['datos_estudios'] = $this->M_perfil->get_estudios_crm($data['datos_perfil'][0]->ID_USUARIO);
                    $DepUsuario = $data['datos_perfil'][0]->DEP_USUARIO;
                    $data['grupo'] = $this->M_perfil->get_adicionales_crm($DepUsuario);
                    $data['grupo'][0]->DESCRIPCION = $this->quitar_tildes($data['grupo'][0]->DESCRIPCION);

                    $DependenciaUsuario = $data['grupo'][0]->ANTECESOR;
                    $data['dependencia'] = $this->M_perfil->get_adicionales_crm($DependenciaUsuario);
                    $data['dependencia'][0]->DESCRIPCION = $this->quitar_tildes($data['dependencia'][0]->DESCRIPCION);

                    $Despacho = $data['dependencia'][0]->ANTECESOR;
                    $data['despacho'] = $this->M_perfil->get_adicionales_crm($Despacho);
                    $data['despacho'][0]->DESCRIPCION = $this->quitar_tildes($data['despacho'][0]->DESCRIPCION);

                    $data['error'] = "";

                    $this->template->title('Perfil de usuario');
                    $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
                <script src='" . base_url() . "public/js/comisiones_list.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
                    $this->template->build('perfil/view_ver_perfil', $data);
                } else {
                    $data['datos_perfil'] = "";
                    $data['datos_idiomas'] = "";
                    $data['datos_estudios'] = "";
                    $data['grupo'] = "";
                    $data['dependencia'] = "";
                    $data['despacho'] = "";

                    $data['error'] = "Usuario no existe en CRM";

                    $this->template->title('Perfil de usuario');
                    $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
                <script src='" . base_url() . "public/js/comisiones_list.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
                    $this->template->build('perfil/view_ver_perfil', $data);
                }
            } else {
                $data['datos_perfil'] = "";
                $data['datos_idiomas'] = "";
                $data['datos_estudios'] = "";
                $data['grupo'] = "";
                $data['dependencia'] = "";
                $data['despacho'] = "";

                $data['error'] = "Usuario no existe en CRM";

                $this->template->title('Perfil de usuario');
                $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
                <script src='" . base_url() . "public/js/comisiones_list.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
                $this->template->build('perfil/view_ver_perfil', $data);
            }
        } else {
            redirect(base_url("index.php/login/iniciar_sesion"));
        }
    }

    public function quitar_tildes($cadena) {
        //$cadena = utf8_decode($cadena);
        $no_permitidas = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "Ñ", "¿", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹");
        $permitidas = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&ntilde;", "&Ntilde;", "&#191;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "c", "C", "&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&oacute;", "&oacute;", "&Iacute;", "&iacute;", "&aacute;", "&eacute;", "&Uacute;", "&Iacute;", "&Aacute;", "&Eacute;");

        return str_replace($no_permitidas, $permitidas, $cadena);
    }

    public function edit() {
        if ($this->session->userdata('terminos') == false) {
            $this->template->set_layout('layout_terminos.php');
            
            $data['error'] = "";

            $this->template->title('Terminos y condiciones');
            $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
            <script src='" . base_url() . "public/js/terminos.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
            $this->template->build('Terminos/view_terminos_condiciones', $data);
        } else {
            if ($this->session->userdata('logueado')) {
                if ($this->input->post()) {

                    $datos_insertar = "";
                    $CategoriasConocimiento = $this->input->post('categorias');
                    $SubcategoriasConocimiento = $this->input->post('subcategorias');

                    if ($SubcategoriasConocimiento != null) {
                        foreach ($SubcategoriasConocimiento as $Valor) {
                            $datos_insertar['com_administradores_id'] = $this->session->userdata('id_user');
                            $datos_insertar['id_subcategoria'] = $Valor;
                            $datos_insertar['tipo'] = 1;

                            $id = $this->M_perfil->add_subcategorias($datos_insertar);
                        }
                    }

                    $datos_insertar = "";
                    $Software = $this->input->post('Sw');

                    foreach ($Software as $Valor) {
                        if ($Valor != null) {
                            $datos_insertar['software'] = $Valor;
                            $datos_insertar['com_administradores_id'] = $this->session->userdata('id_user');

                            $id = $this->M_perfil->add_software($datos_insertar);
                        }
                    }

                    $datos_insertar = "";
                    $datos_insertar['id_administrador'] = $this->session->userdata('id_user');
                    $datos_insertar['posible_aporte'] = $this->input->post('aporte');

                    $this->M_perfil->add_datos_ad($datos_insertar);

                    redirect(base_url("index.php/perfil"));
                } else {
                    $Documento = $this->session->identificacion;

                    if ($Documento != null) {
                        $data['datos_perfil'] = $this->M_perfil->get_document_crm($Documento);
                        if ($data['datos_perfil'] != null) {
                            $data['datos_idiomas'] = $this->M_perfil->get_idiomas_crm($data['datos_perfil'][0]->ID_USUARIO);
                            $data['datos_estudios'] = $this->M_perfil->get_estudios_crm($data['datos_perfil'][0]->ID_USUARIO);

                            $DepUsuario = $data['datos_perfil'][0]->DEP_USUARIO;
                            $data['grupo'] = $this->M_perfil->get_adicionales_crm($DepUsuario);
                            $data['grupo'][0]->DESCRIPCION = $this->quitar_tildes($data['grupo'][0]->DESCRIPCION);

                            $DependenciaUsuario = $data['grupo'][0]->ANTECESOR;
                            $data['dependencia'] = $this->M_perfil->get_adicionales_crm($DependenciaUsuario);
                            $data['dependencia'][0]->DESCRIPCION = $this->quitar_tildes($data['dependencia'][0]->DESCRIPCION);

                            $Despacho = $data['dependencia'][0]->ANTECESOR;
                            $data['despacho'] = $this->M_perfil->get_adicionales_crm($Despacho);
                            $data['despacho'][0]->DESCRIPCION = $this->quitar_tildes($data['despacho'][0]->DESCRIPCION);

                            $data['categorias'] = $this->M_perfil->get_categorias();

                            $data['error'] = "";

                            $this->template->title('Perfil de usuario - editar');
                            $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
						<script src='" . base_url() . "public/js/edit_perfil.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
                            $this->template->build('perfil/view_edit_perfil', $data);
                        } else {
                            redirect(base_url("index.php/perfil"));
                        }
                    } else {
                        $data['datos_perfil'] = "";
                        $data['datos_idiomas'] = "";
                        $data['datos_estudios'] = "";
                        $data['grupo'] = "";
                        $data['dependencia'] = "";
                        $data['despacho'] = "";

                        $data['error'] = "Usuario no existe en CRM";

                        $this->template->title('Perfil de usuario');
                        $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
                <script src='" . base_url() . "public/js/comisiones_list.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
                        $this->template->build('perfil/view_ver_perfil', $data);
                    }
                }
            } else {
                redirect(base_url("index.php/login/iniciar_sesion"));
            }
        }
    }

    public function subcategorias() {
        $Categoria = $this->input->post("id");
        if ($Categoria == null) {
            echo "<div class='checkbox'>";
        } else {
            foreach ($Categoria as $IdCategoria) {
                $data = $this->M_perfil->get_subcategorias($IdCategoria);
                foreach ($data as $Subcategoria) {
                    echo "<div class='checkbox'>";
                    echo "<label>";
                    echo "<input type='checkbox' class='input-subcategoria' id='" . $Subcategoria->id_subcategoria . "' name='subcategorias[]' value='" . $Subcategoria->id_subcategoria . "'>" . $Subcategoria->subcategoria;
                    echo "</label>";
                    echo "</div>";
                }
            }
        }
    }

    public function validateident() {
        if ($this->session->userdata('logueado')) {
            $ident = $this->session->userdata('identificacion');

            if ($ident != null) {
                redirect("http://somos.dane.gov.co/user");
            } else {
                $data['datos_perfil'] = "";
                $data['datos_idiomas'] = "";
                $data['datos_estudios'] = "";
                $data['grupo'] = "";
                $data['dependencia'] = "";
                $data['despacho'] = "";

                $data['error'] = "Usuario no existe en CRM";

                $this->template->title('Perfil de usuario');
                $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
                <script src='" . base_url() . "public/js/comisiones_list.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
                $this->template->build('perfil/view_ver_perfil', $data);
            }
        } else {
            redirect(base_url("index.php/login/iniciar_sesion"));
        }
    }

}
