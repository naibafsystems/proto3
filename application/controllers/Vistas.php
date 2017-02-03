<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vistas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->model('M_comisiones');
        $this->load->model('M_tema');
        $this->template->set_layout('layout_gen_tbl.php');
        date_default_timezone_set('America/Bogota');
    }

    public function index() {
        $data['listado'] = $this->M_comisiones->get_todos();

        foreach ($data['listado'] as $valor) {
            $interno_gen = $valor->INTERNO_GEN;
            $interno_enc = $valor->INTERNO_ENC;
            $vigencia = $valor->VIGENCIA;
            $cod_unidad = $valor->CODIGO_UNIDAD_EJECUTORA;

            $Comi['listado_com'] = $this->M_comisiones->get_todos_com($interno_gen, $interno_enc, $vigencia, $cod_unidad);

            if ($Comi['listado_com'] != null) {
                $valor->id_datos = $Comi['listado_com'][0]->id_datos;
                $valor->interno_gen = $Comi['listado_com'][0]->interno_gen;
                $valor->interno_enc = $Comi['listado_com'][0]->interno_enc;
                $valor->vigencia = $Comi['listado_com'][0]->vigencia;
                $valor->codigo_unidad_ejecutora = $Comi['listado_com'][0]->codigo_unidad_ejecutora;
                $valor->id_tema = $Comi['listado_com'][0]->id_tema;
                $valor->tipo_comi = $Comi['listado_com'][0]->tipo_comi;
                $valor->resumen_comision = $Comi['listado_com'][0]->resumen_comision;
                $valor->participantes = $Comi['listado_com'][0]->participantes;
                $valor->mail_autor = $Comi['listado_com'][0]->mail_autor;
                $valor->actualizaciones = $Comi['listado_com'][0]->actualizaciones;
                $valor->fecha_creacion = $Comi['listado_com'][0]->fecha_creacion;
                $valor->fecha_actualizacion = $Comi['listado_com'][0]->fecha_actualizacion;
            } else {
                $valor->id_datos = "";
                $valor->interno_gen = "";
                $valor->interno_enc = "";
                $valor->vigencia = "";
                $valor->codigo_unidad_ejecutora = "";
                $valor->id_tema = "";
                $valor->tipo_comi = "";
                $valor->resumen_comision = "";
                $valor->participantes = "";
                $valor->mail_autor = "";
                $valor->actualizaciones = "";
                $valor->fecha_creacion = "";
                $valor->fecha_actualizacion = "";
            }

            $Mapa['listado_lugares'] = $this->M_comisiones->get_lugares($valor->LUGAR_COMISION);

            if ($Mapa['listado_lugares'] != null) {
                $valor->id_lugar = $Mapa['listado_lugares'][0]->id_lugar;
                $valor->lugar = $Mapa['listado_lugares'][0]->lugar;
                $valor->direccion = $Mapa['listado_lugares'][0]->direccion;
                $valor->mapa = $Mapa['listado_lugares'][0]->mapa;
            } else {
                $valor->id_lugar = "";
                $valor->lugar = "";
                $valor->direccion = "";
                $valor->mapa = "";
            }
        }

        $this->template->title('Comisiones');
        $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
            <script src='" . base_url() . "public/js/comisiones_list.js'></script><script src='" . base_url() . "public/js/estilos.js'></script>");
        $this->template->build('comisiones/view_list_comisiones', $data);
    }

    public function agregar($interno_gen = null, $interno_enc = null, $vigencia = null, $cod_unidad = null, $tipo_comision = null) {
        if (($interno_gen == NULL || !is_numeric($interno_gen)) || ($interno_enc == NULL || !is_numeric($interno_enc)) ||
                ($vigencia == NULL || !is_numeric($vigencia)) || ($cod_unidad == NULL ) || ($tipo_comision == NULL)) {
            echo "Parametros Invalidos";
            //return;
        } else {
            $data['datos_comisiones'] = $this->M_comisiones->get_by_id($interno_gen, $interno_enc, $vigencia, $cod_unidad);
            $data['temas'] = $this->M_tema->get_todos();
            $data['tipos'] = $this->M_tema->get_todos_tipo();
            $data['tipo_comision'] = $tipo_comision;

            if (empty($data['datos_comisiones'])) {
                echo "Parametros invalidos D";
            } else {
                if ($this->input->post()) {
                    //print_r($this->input->post());
                    //exit();
                    $datos_insertar['interno_gen'] = $interno_gen;
                    $datos_insertar['interno_enc'] = $interno_enc;
                    $datos_insertar['vigencia'] = $vigencia;
                    $datos_insertar['codigo_unidad_ejecutora'] = $cod_unidad;
                    $datos_insertar['id_tema'] = $this->input->post('tema');
                    
                    $val_tipo = $this->input->post('tipo');
                    if($val_tipo == "S"){
                        $tipo_comi = 3;
                    }else{
                        $tipo_comi = 1;
                    }
                    
                    $datos_insertar['tipo_comi'] = $tipo_comi;
                    $datos_insertar['resumen_comision'] = $this->input->post('resumen');
                    $datos_insertar['participantes'] = $this->input->post('participantes');
                    $datos_insertar['mail_autor'] = $this->session->userdata('mail');
                    $datos_insertar['actualizaciones'] = 0;
                    $datos_insertar['fecha_creacion'] = date('Y-m-d');

                    $id_datos = $this->M_comisiones->add($datos_insertar);

                    $datos_aspectos['id_asp_datos'] = $id_datos;
                    $datos_aspectos['asp_convocatoria'] = $this->input->post('asp_convocatoria');
                    $datos_aspectos['dif_convocatoria'] = $this->input->post('dif_convocatoria');
                    $datos_aspectos['asp_logistica'] = $this->input->post('asp_logistica');
                    $datos_aspectos['dif_logistica'] = $this->input->post('dif_logistica');
                    $datos_aspectos['asp_entrevista'] = $this->input->post('asp_entrevista');
                    $datos_aspectos['dif_entrevista'] = $this->input->post('dif_entrevista');
                    $datos_aspectos['asp_desarrollo'] = $this->input->post('asp_desarrollo');
                    $datos_aspectos['dif_desarrollo'] = $this->input->post('dif_desarrollo');
                    $datos_aspectos['asp_plataforma'] = $this->input->post('asp_plataforma');
                    $datos_aspectos['dif_plataforma'] = $this->input->post('dif_plataforma');

                    $datos_aspectos['temas_tra'] = $this->input->post('temas_tra');
                    $datos_aspectos['lecciones'] = $this->input->post('lecciones');
                    $datos_aspectos['oportunidades'] = $this->input->post('oportunidades');
                    $datos_aspectos['nal_actdesarro'] = $this->input->post('nal_actdesarro');
                    $datos_aspectos['nal_positivos'] = $this->input->post('nal_positivos');
                    $datos_aspectos['nal_dificultades'] = $this->input->post('nal_dificultades');
                    $datos_aspectos['conclusiones'] = $this->input->post('conclusiones');
                    $datos_aspectos['conv_aplicaciones'] = $this->input->post('conv_aplicaciones');
                    $datos_aspectos['conv_logistica'] = $this->input->post('conv_logistica');
                    $datos_aspectos['conv_entrevista'] = $this->input->post('conv_entrevista');
                    $datos_aspectos['conv_desarrollo'] = $this->input->post('conv_desarrollo');
                    $datos_aspectos['conv_plataforma'] = $this->input->post('conv_plataforma');
                    $datos_aspectos['aplicaciones'] = $this->input->post('aplicaciones');

                    print_r($datos_aspectos);
                    
                    $this->M_comisiones->add_aspectos($datos_aspectos);

                    $num_contactos = count($this->input->post('nombre_con'));
                    
                    if ($num_contactos > 0){
                        $nombre_con = $this->input->post('nombre_con');
                        $mail_con = $this->input->post('mail_con');
                        $apellido_con = $this->input->post('apellido_con');
                        $cargo_con = $this->input->post('cargo_con');
                        $telefono_con = $this->input->post('telefono_con');

                        for ($i = 0; $i < $num_contactos; $i++) {
                            $datos_contacto['id_datos_con'] = $id_datos;
                            $datos_contacto['nombre'] = $nombre_con[$i];
                            $datos_contacto['apellido'] = $apellido_con[$i];
                            $datos_contacto['cargo'] = $cargo_con[$i];
                            $datos_contacto['mail'] = $mail_con[$i];
                            $datos_contacto['telefono'] = $telefono_con[$i];

                            $this->M_comisiones->add_contactos($datos_contacto);
                        }
                    }
                    
                    $num_archivos = count($_FILES ['archivo'] ['name']);
                    
                    if ($num_archivos > 0){
                        $this->do_upload_multi($id_datos);
                    }

                    redirect('comisiones/ver/' . $id_datos . "/exito");
                } else {
                    $this->template->set_layout('layout_gen.php');

                    $this->template->title('Completar Comisi&oacute;n');
                    $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
                        <script src='" . base_url() . "public/js/comisiones.js'></script>
                        <script src='" . base_url() . "public/js/bootstrapValidator.min.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
                    $this->template->build('comisiones/view_form_comisiones', $data);
                }
            }
        }
    }
    
    public function noejecutada($interno_gen = null, $interno_enc = null, $vigencia = null, $cod_unidad = null, $tipo_comision = null) {
        if (($interno_gen == NULL || !is_numeric($interno_gen)) || ($interno_enc == NULL || !is_numeric($interno_enc)) ||
                ($vigencia == NULL || !is_numeric($vigencia)) || ($cod_unidad == NULL ) || ($tipo_comision == NULL)) {
            echo "Parametros Invalidos";
            //return;
        } else {
            $datos_insertar['interno_gen'] = $interno_gen;
            $datos_insertar['interno_enc'] = $interno_enc;
            $datos_insertar['vigencia'] = $vigencia;
            $datos_insertar['codigo_unidad_ejecutora'] = $cod_unidad;
            $datos_insertar['id_tema'] = 0;
            
            if($tipo_comision == "S"){
                $tipo_comi = 3;
            }else{
                $tipo_comi = 1;
            }
            
            $datos_insertar['tipo_comi'] = $tipo_comi;
            $datos_insertar['resumen_comision'] = "No ejecutada";
            $datos_insertar['participantes'] = "No ejecutada";
            $datos_insertar['mail_autor'] = $this->session->userdata('mail');
            $datos_insertar['actualizaciones'] = 0;
            $datos_insertar['fecha_creacion'] = date('Y-m-d');
            $datos_insertar['ejecutada'] = 1;

            $id_datos = $this->M_comisiones->add($datos_insertar);
            
            redirect('comisiones/propias/');
        }
    }
    
    public function editar($id = NULL, $tipo_comision = null) {
        if ($id == NULL || !is_numeric($id)) {
            echo "Parametros Invalidos";
            return;
        } else {
            $data['datos_comisiones'] = $this->M_comisiones->get_by_id_datos($id);

            if (empty($data['datos_comisiones'])) {
                echo "Parametros invalidos D";
            } else {
                if ($this->input->post()) {
                    
                    $act = $this->input->post('actualizaciones');
                    $act = $act + 1;
                    
                    if ($act < 4){
                        $datos_insertar['resumen_comision'] = $this->input->post('resumen');
                        $datos_insertar['participantes'] = $this->input->post('participantes');
                        $datos_insertar['actualizaciones'] = $act;

                        $this->M_comisiones->edit_datos_general($id,$datos_insertar);

                        $datos_aspectos['asp_convocatoria'] = $this->input->post('asp_convocatoria');
                        $datos_aspectos['dif_convocatoria'] = $this->input->post('dif_convocatoria');
                        $datos_aspectos['asp_logistica'] = $this->input->post('asp_logistica');
                        $datos_aspectos['dif_logistica'] = $this->input->post('dif_logistica');
                        $datos_aspectos['asp_entrevista'] = $this->input->post('asp_entrevista');
                        $datos_aspectos['dif_entrevista'] = $this->input->post('dif_entrevista');
                        $datos_aspectos['asp_desarrollo'] = $this->input->post('asp_desarrollo');
                        $datos_aspectos['dif_desarrollo'] = $this->input->post('dif_desarrollo');
                        $datos_aspectos['asp_plataforma'] = $this->input->post('asp_plataforma');
                        $datos_aspectos['dif_plataforma'] = $this->input->post('dif_plataforma');
                        $datos_aspectos['temas_tra'] = $this->input->post('temas_tra');
                        $datos_aspectos['lecciones'] = $this->input->post('lecciones');
                        $datos_aspectos['oportunidades'] = $this->input->post('oportunidades');
                        $datos_aspectos['nal_actdesarro'] = $this->input->post('nal_actdesarro');
                        $datos_aspectos['nal_positivos'] = $this->input->post('nal_positivos');
                        $datos_aspectos['nal_dificultades'] = $this->input->post('nal_dificultades');
                        $datos_aspectos['conclusiones'] = $this->input->post('conclusiones');
                        $datos_aspectos['conv_aplicaciones'] = $this->input->post('conv_aplicaciones');
                        $datos_aspectos['conv_logistica'] = $this->input->post('conv_logistica');
                        $datos_aspectos['conv_entrevista'] = $this->input->post('conv_entrevista');
                        $datos_aspectos['conv_desarrollo'] = $this->input->post('conv_desarrollo');
                        $datos_aspectos['conv_plataforma'] = $this->input->post('conv_plataforma');
                        $datos_aspectos['aplicaciones'] = $this->input->post('aplicaciones');

                        $this->M_comisiones->edit_aspectos($id,$datos_aspectos);

                        $num_contactos = count($this->input->post('nombre_con'));
                        
                        if ($num_contactos > 0){
                            $nombre_con = $this->input->post('nombre_con');
                            $mail_con = $this->input->post('mail_con');
                            $apellido_con = $this->input->post('apellido_con');
                            $cargo_con = $this->input->post('cargo_con');
                            $telefono_con = $this->input->post('telefono_con');

                            for ($i = 0; $i < $num_contactos; $i++) {
                                $datos_contacto['id_datos_con'] = $id;
                                $datos_contacto['nombre'] = $nombre_con[$i];
                                $datos_contacto['apellido'] = $apellido_con[$i];
                                $datos_contacto['cargo'] = $cargo_con[$i];
                                $datos_contacto['mail'] = $mail_con[$i];
                                $datos_contacto['telefono'] = $telefono_con[$i];

                                $this->M_comisiones->add_contactos($datos_contacto);
                            }
                        }

                        $num_archivos = count($_FILES ['archivo'] ['name']);
                        $nombre_archivo = $_FILES ['archivo'] ['name'][0];
                        echo $nombre_archivo;
                           
                        if ($num_archivos > 0 && $nombre_archivo != null){
                            $this->do_upload_multi($id);
                        }

                        redirect('comisiones/ver/' . $id . "/editar");
                    }else{
                        redirect('comisiones/ver/' . $id . "/sobrepaso");
                    }
                } else {

                    $interno_gen = $data['datos_comisiones'][0]->interno_gen;
                    $interno_enc = $data['datos_comisiones'][0]->interno_enc;
                    $vigencia = $data['datos_comisiones'][0]->vigencia;
                    $cod_unidad = $data['datos_comisiones'][0]->codigo_unidad_ejecutora;

                    $Comi['datos_com'] = $this->M_comisiones->get_by_id($interno_gen, $interno_enc, $vigencia, $cod_unidad);

                    foreach ($data['datos_comisiones'] as $valor) {
                        $valor->INTERNO_GEN = $Comi['datos_com'][0]->INTERNO_GEN;
                        $valor->INTERNO_ENC = $Comi['datos_com'][0]->INTERNO_ENC;
                        $valor->VIGENCIA = $Comi['datos_com'][0]->VIGENCIA;
                        $valor->CODIGO_UNIDAD_EJECUTORA = $Comi['datos_com'][0]->CODIGO_UNIDAD_EJECUTORA;
                        $valor->NOMBRE = $Comi['datos_com'][0]->NOMBRE;
                        $valor->NUMERO_DOCUMENTO = $Comi['datos_com'][0]->NUMERO_DOCUMENTO;
                        $valor->OBJETO = $Comi['datos_com'][0]->OBJETO;
                        $valor->FECHA_INICIO = $Comi['datos_com'][0]->FECHA_INICIAL;
                        $valor->FECHA_TERMINACION = $Comi['datos_com'][0]->FECHA_FINAL;
                        $valor->LUGAR_COMISION = $Comi['datos_com'][0]->LUGAR_COMISION;
                        $valor->correo = "Pendiente";
                    }
                       
                    $data['tipo_comision'] = $tipo_comision;
                    $data['comentarios'] = $this->M_comisiones->comentarios($id);
                    $data['archivos'] = $this->M_comisiones->get_by_archios($id);
                    $data['imagenes'] = $this->M_comisiones->get_by_imagenes($id);
                    $data['contactos'] = $this->M_comisiones->get_by_contactos($id);
                    $data['temas'] = $this->M_tema->get_todos();
                    $data['tipos'] = $this->M_tema->get_todos_tipo();

                    $this->template->set_layout('layout_gen.php');
                    $this->template->title('Detalle Comisi&oacute;n');
                    $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
                        <script src='" . base_url() . "public/js/comisiones_edit.js'></script>
                        <script src='" . base_url() . "public/js/bootstrapValidator.min.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
                    $this->template->build('comisiones/edit_form_comisiones', $data);
                }
            }
        }
    }
    
    public function edit_contacto() {
        
        $id_contacto = $this->input->post('idcontacto_edit');
        $id_datos_edit = $this->input->post('id_datos_edit');
        
        if($id_contacto == NULL || !is_numeric($id_contacto)){
            echo "El id es invalido.";
            return;
        }else{
            $data['datos_contacto'] = $this->M_comisiones->get_by_id_contacto($id_contacto);
            if(empty($data['datos_contacto'])){
                echo "El contacto es invalido o no existe";
            }else{
                $datos_insertar['id_datos_con'] = $id_datos_edit;
                $datos_insertar['nombre'] = $this->input->post('nombre_edit');
                $datos_insertar['apellido'] = $this->input->post('apellido_edit');
                $datos_insertar['cargo'] = $this->input->post('cargo_edit');
                $datos_insertar['mail'] = $this->input->post('mail_edit');
                $datos_insertar['telefono'] = $this->input->post('telefono_edit');    

                $this->M_comisiones->edit_contacto($datos_insertar, $id_contacto);
                redirect('Comisiones/editar/'.$id_datos_edit);
            }
        }
    }
    
    public function delete_contacto() {
        
        $id_contacto = $this->input->post('idcontacto_delete');
        $id_datos_edit = $this->input->post('id_datos_delete');
        
        if($id_contacto == NULL || !is_numeric($id_contacto)){
            echo "El id es invalido.";
            return;
        }else{
            $data['datos_contacto'] = $this->M_comisiones->get_by_id_contacto($id_contacto);
            if(empty($data['datos_contacto'])){
                echo "El contacto es invalido o no existe";
            }else{  

                $this->M_comisiones->delete_contacto($id_contacto);
                redirect('Comisiones/editar/'.$id_datos_edit);
            }
        }
    }

    public function ver($id = NULL, $error = null) {
        if ($id == NULL || !is_numeric($id)) {
            echo "Id Invalido";
            return;
        } else {
            $data['datos_comisiones'] = $this->M_comisiones->get_by_id_datos($id);
            if (empty($data['datos_comisiones'])) {
                echo "Id es Invalido";
            } else {

                $interno_gen = $data['datos_comisiones'][0]->interno_gen;
                $interno_enc = $data['datos_comisiones'][0]->interno_enc;
                $vigencia = $data['datos_comisiones'][0]->vigencia;
                $cod_unidad = $data['datos_comisiones'][0]->codigo_unidad_ejecutora;

                $Comi['datos_com'] = $this->M_comisiones->get_by_id($interno_gen, $interno_enc, $vigencia, $cod_unidad);

                foreach ($data['datos_comisiones'] as $valor) {
                    $valor->INTERNO_GEN = $Comi['datos_com'][0]->INTERNO_GEN;
                    $valor->INTERNO_ENC = $Comi['datos_com'][0]->INTERNO_ENC;
                    $valor->VIGENCIA = $Comi['datos_com'][0]->VIGENCIA;
                    $valor->CODIGO_UNIDAD_EJECUTORA = $Comi['datos_com'][0]->CODIGO_UNIDAD_EJECUTORA;
                    $valor->NOMBRE = $Comi['datos_com'][0]->NOMBRE;
                    $valor->NUMERO_DOCUMENTO = $Comi['datos_com'][0]->NUMERO_DOCUMENTO;
                    $valor->OBJETO = $Comi['datos_com'][0]->OBJETO;
                    $valor->FECHA_INICIAL = $Comi['datos_com'][0]->FECHA_INICIAL;
                    $valor->FECHA_TERMINACION = $Comi['datos_com'][0]->FECHA_FINAL;
                    $valor->LUGAR_COMISION = $Comi['datos_com'][0]->LUGAR_COMISION;
                    $valor->correo = "Pendiente";
                }

                $data['comentarios'] = $this->M_comisiones->comentarios($id);
                $data['votos'] = $this->M_comisiones->get_by_id_votos($id);
                $data['votos_count'] = $this->M_comisiones->get_by_id_votos_count($id);
                $data['archivos'] = $this->M_comisiones->get_by_archios($id);
                $data['imagenes'] = $this->M_comisiones->get_by_imagenes($id);
                $data['contactos'] = $this->M_comisiones->get_by_contactos($id);
                $data['error'] = $error;
                
                $fecha_hoy = date('Y-m-d');
                $vistas_user = $this->M_comisiones->get_by_visitas_user($id, $this->session->userdata('mail'), $fecha_hoy);
                $num_vistas_user = $vistas_user[0]->vistos;
                $mail_autor = $data['datos_comisiones'][0]->mail_autor;
                
                $vistas_total = $this->M_comisiones->get_by_visitas($id);
                $num_vistas = $vistas_total[0]->vistos;
                
                if ($num_vistas_user == 0 and $mail_autor != $this->session->userdata('mail')){
                    $datos_insertar['id_vista_datos'] = $id;
                    $datos_insertar['mail_visto'] = $this->session->userdata('mail');
                    $datos_insertar['fecha_visto'] = date('Y-m-d');
                    $this->M_comisiones->add_visita($datos_insertar);
                    
                    $num_vistas = $num_vistas + 1;
                }
                
                $data['visitas'] = $num_vistas;

                $this->template->set_layout('layout_gen_ver.php');
                $this->template->title('Detalle Comisi&oacute;n');
                $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
                                                  <script src='" . base_url() . "public/js/comisiones_ver.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
                $this->template->build('comisiones/view_ver_comisiones', $data);
            }
        }
    }

    public function eliminar($id = NULL) {
        if ($id == NULL || !is_numeric($id)) {
            echo "Id Invalido";
            return;
        } else {
            $data['datos_comisiones'] = $this->M_comisiones->get_by_id($id);
            if (empty($data['datos_comisiones'])) {
                echo "Id es Invalido";
            } else {
                if ($this->input->post()) {
                    $id_eliminar = $this->input->post('com_id');
                    $this->M_comisiones->delete($id);
                    redirect('comisiones');
                } else {
                    $this->layout->view('view_delete_comisiones', $data);
                }
            }
        }
    }

    public function do_upload() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|zip|rar|doc|docx|xls|xlsx|ppt|pptx|pdf|avi|mpeg|mp3|mp4|3gp';
        $config['max_size'] = 2048000;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;
        $config['remove_spaces'] = true;
        $config['overwrite'] = true;
        $config['file_name'] = convert_accented_characters($_FILES['archivo']['name']);
        $config['remove_spaces'] = true;
        //echo $config['upload_path'];
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('archivo')) {
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            return $data;
        }
    }

    public function do_upload_multi($id_datos_rev) {
        $this->load->library('upload');

        $files = $_FILES;
        $cpt = count($_FILES ['archivo'] ['name']);

        $tipo_anexo = $this->input->post('tipo_anexo');
        $resumen_archivo = $this->input->post('resumen_archivo');

        for ($i = 0; $i < $cpt; $i ++) {

            $_FILES ['archivo'] ['name'] = $files ['archivo'] ['name'] [$i];
            $_FILES ['archivo'] ['type'] = $files ['archivo'] ['type'] [$i];
            $_FILES ['archivo'] ['tmp_name'] = $files ['archivo'] ['tmp_name'] [$i];
            $_FILES ['archivo'] ['error'] = $files ['archivo'] ['error'] [$i];
            $_FILES ['archivo'] ['size'] = $files ['archivo'] ['size'] [$i];

            $nombre = convert_accented_characters($files ['archivo'] ['name'] [$i]);
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|zip|rar|doc|docx|xls|xlsx|ppt|pptx|pdf|avi|mpeg|mp3|mp4|3gp';
            $config['max_size'] = 2048000;
            $config['remove_spaces'] = true;
            $config['overwrite'] = true;
            $config['file_name'] = $nombre;
            $config['remove_spaces'] = true;
            $config['multi'] = 'all';
            //echo $config['upload_path'];

            $this->upload->initialize($config);
            //$this->upload->do_upload ('archivo');

            if (!$this->upload->do_upload('archivo')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                exit();
            } else {
                $data = array('upload_data' => $this->upload->data());
                $datos_archivo['id_arc_datos'] = $id_datos_rev;
                $datos_archivo['tipo_archivo'] = $tipo_anexo[$i];
                $datos_archivo['archivo_ruta'] = base_url('uploads/');
                $datos_archivo['archivo'] = $data['upload_data']['file_name'];
                $datos_archivo['resumen_archivo'] = $resumen_archivo[$i];
                //$datos_archivo['type'] =

                $this->M_comisiones->add_archivos($datos_archivo);
            }
        }
    }

    public function do_upload_multi_img($id_datos_rev, $tipo) {
        $this->load->library('upload');

        $files = $_FILES;
        $cpt = count($_FILES ['imagen'] ['name']);
        echo "cantidad deimagenes: " . $cpt;
        for ($i = 0; $i < $cpt; $i ++) {

            $_FILES ['imagen'] ['name'] = $files ['imagen'] ['name'] [$i];
            $_FILES ['imagen'] ['type'] = $files ['imagen'] ['type'] [$i];
            $_FILES ['imagen'] ['tmp_name'] = $files ['imagen'] ['tmp_name'] [$i];
            $_FILES ['imagen'] ['error'] = $files ['imagen'] ['error'] [$i];
            $_FILES ['imagen'] ['size'] = $files ['imagen'] ['size'] [$i];

            $nombre = convert_accented_characters($files ['imagen'] ['name'] [$i]);
            $config['upload_path'] = './uploads/images';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|zip|rar|doc|docx|xls|xlsx|ppt|pptx|pdf|avi|mpeg|mp3|mp4|3gp';
            $config['max_size'] = 2048000;
            $config['remove_spaces'] = true;
            $config['overwrite'] = true;
            $config['file_name'] = $nombre;
            $config['remove_spaces'] = true;
            $config['multi'] = 'all';
            //echo $config['upload_path'];

            $this->upload->initialize($config);
            //$this->upload->do_upload ('archivo');

            if (!$this->upload->do_upload('imagen')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                exit();
            } else {
                $resumen = $this->input->post('resumen_imagen');
                print_r($resumen[$i]);
                echo "indice: " . $i;
                $data = array('upload_data' => $this->upload->data());
                print_r($data['upload_data']);
                $datos_archivo['id_arc_datos'] = $id_datos_rev;
                $datos_archivo['tipo_archivo'] = $tipo;
                $datos_archivo['archivo_ruta'] = base_url('uploads/images');
                $datos_archivo['archivo'] = $data['upload_data']['file_name'];
                $datos_archivo['resumen_archivo'] = $resumen[$i];

                $this->M_comisiones->add_archivos($datos_archivo);
            }
        }
    }

    public function do_upload_multi_lib() {

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|zip|rar|doc|docx|xls|xlsx|ppt|pptx|pdf|avi|mpeg|mp3|mp4|3gp';
        $config['max_size'] = 2048000;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;
        $config['remove_spaces'] = true;
        $config['overwrite'] = false;
        $config['file_name'] = "";
        $config['remove_spaces'] = true;
        $config['multi'] = 'all';
        //echo $config['upload_path'];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('archivo')) {
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
            exit();
        } else {
            $data = array('upload_data' => $this->upload->data());
            return $data;
            exit();
        }
    }

    public function viewmapa() {
        $id = $this->input->post("id");
        if ($id == NULL || !is_numeric($id)) {
            echo "Id Invalido";
            return;
        } else {
            $data = $this->M_comisiones->get_by_id_mapa($id);
            if (empty($data)) {
                echo "No Se encontroel Mapa";
            } else {
                echo $data[0]->mapa;
            }
        }
    }

    public function resumen() {
        $id = $this->input->post("id");
        if ($id == NULL || !is_numeric($id)) {
            echo "Id Invalido";
            return;
        } else {
            $data = $this->M_comisiones->get_gen_by_id($id);
            if (empty($data)) {
                echo "Id es Invalido";
            } else {
                echo $data[0]->resumen_comision;
            }
        }
    }

    public function buscar_comisiones() {
        $data['listado'] = $this->M_comisiones->buscar_comi($this->input->post('palabraClave'));
        foreach ($data['listado'] as $valor) {

            $id_com = $valor->id_com;
            $Comi['datos_com'] = $this->M_comisiones->get_com_id($id_com);

            $valor->id = $Comi['datos_com'][0]->id;
            $valor->nombre = $Comi['datos_com'][0]->nombre;
            $valor->cedula = $Comi['datos_com'][0]->cedula;
            $valor->objeto = $Comi['datos_com'][0]->objeto;
            $valor->fecha_inicio = $Comi['datos_com'][0]->fecha_inicio;
            $valor->fecha_fin = $Comi['datos_com'][0]->fecha_fin;
            $valor->lugar = $Comi['datos_com'][0]->lugar;
            $valor->correo = $Comi['datos_com'][0]->correo;
        }

        $this->layout->setTitle('Comisiones Propias');

        $this->layout->css(array(base_url() . "public/js/datatables.css",
            base_url() . "public/css/theme.css"));
        $this->layout->js(array(base_url() . "public/js/datatables.min.js",
            base_url() . "public/js/comisiones_list.js"));

        $this->layout->view('view_list_comisiones', $data);
    }

    public function propias() {
        $data['listado'] = $this->M_comisiones->get_todos_ident($this->session->userdata['identificacion']);

        foreach ($data['listado'] as $valor) {
            $interno_gen = $valor->INTERNO_GEN;
            $interno_enc = $valor->INTERNO_ENC;
            $vigencia = $valor->VIGENCIA;
            $cod_unidad = $valor->CODIGO_UNIDAD_EJECUTORA;

            $Comi['listado_com'] = $this->M_comisiones->get_todos_com($interno_gen, $interno_enc, $vigencia, $cod_unidad);

            if ($Comi['listado_com'] != null) {
                $valor->id_datos = $Comi['listado_com'][0]->id_datos;
                $valor->interno_gen = $Comi['listado_com'][0]->interno_gen;
                $valor->interno_enc = $Comi['listado_com'][0]->interno_enc;
                $valor->vigencia = $Comi['listado_com'][0]->vigencia;
                $valor->codigo_unidad_ejecutora = $Comi['listado_com'][0]->codigo_unidad_ejecutora;
                $valor->id_tema = $Comi['listado_com'][0]->id_tema;
                $valor->tipo_comi = $Comi['listado_com'][0]->tipo_comi;
                $valor->resumen_comision = $Comi['listado_com'][0]->resumen_comision;
                $valor->participantes = $Comi['listado_com'][0]->participantes;
                $valor->mail_autor = $Comi['listado_com'][0]->mail_autor;
                $valor->actualizaciones = $Comi['listado_com'][0]->actualizaciones;
                $valor->fecha_creacion = $Comi['listado_com'][0]->fecha_creacion;
                $valor->fecha_actualizacion = $Comi['listado_com'][0]->fecha_actualizacion;
                $valor->ejecutada = $Comi['listado_com'][0]->ejecutada;
            } else {
                $valor->id_datos = "";
                $valor->interno_gen = "";
                $valor->interno_enc = "";
                $valor->vigencia = "";
                $valor->codigo_unidad_ejecutora = "";
                $valor->id_tema = "";
                $valor->tipo_comi = "";
                $valor->resumen_comision = "";
                $valor->participantes = "";
                $valor->mail_autor = "";
                $valor->actualizaciones = "";
                $valor->fecha_creacion = "";
                $valor->fecha_actualizacion = "";
                $valor->ejecutada = "";
            }

            $Mapa['listado_lugares'] = $this->M_comisiones->get_lugares($valor->LUGAR_COMISION);

            if ($Mapa['listado_lugares'] != null) {
                $valor->id_lugar = $Mapa['listado_lugares'][0]->id_lugar;
                $valor->lugar = $Mapa['listado_lugares'][0]->lugar;
                $valor->direccion = $Mapa['listado_lugares'][0]->direccion;
                $valor->mapa = $Mapa['listado_lugares'][0]->mapa;
            } else {
                $valor->id_lugar = "";
                $valor->lugar = "";
                $valor->direccion = "";
                $valor->mapa = "";
            }
        }

        $this->template->title('Comisiones Propias');
        $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
            <script src='" . base_url() . "public/js/comisiones_list_pro.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
        $this->template->build('comisiones/view_list_comi_pro', $data);
    }

    public function addmapa() {
        if ($this->input->post()) {
            $datos_insertar['lugar'] = $this->input->post('lugar');
            $datos_insertar['direccion'] = $this->input->post('direccion');
            $datos_insertar['mapa'] = $this->input->post('mapa');
            $this->M_comisiones->agregarmapa($datos_insertar);
            redirect('comisiones');
        }
    }

    public function prueba_correo() {
        $this->load->library('My_PHPMailer');

        $this->load->library('email');
        $configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => '0u67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
        //cargamos la configuraci�n para enviar mail
        $this->email->initialize($configMail);
        $this->email->from('aplicaciones@dane.gov.co', 'Innovaci�n');
        $this->email->to('dasuarezt@dane.gov.co');
        $this->email->cc('alexdast26@gmail.com');
        $this->email->subject('Recordatorio Comisi�n');

        $html = '
					  Apreciado usuario:
					  <p>Usted se ha registrado en el banco de innovaci�n del DaneRecuerde la importancia de compartir su vivencia en los espacios de comisi�n que permita realizar la gesti�n de conocimiento en la entidad.</p>
					  <p>Puede ingresar al siguiente link  <a href="' . base_url() . '" target="_blank">Link</a></p>
					  <p>Gracias por su compromiso con la entidad.</p>
				  ';

        $this->email->message($html);
        $this->email->send();
        if ($this->email->send()) {
            echo "Envio de Correo Exitoso";
        } else {
            echo "Error al enviar el correo";
        }
    }

    public function agregarcomentario() {
        if ($this->input->post()) {
            $datos_insertar['id_datos'] = $this->input->post('id_datos');
            $datos_insertar['asunto'] = $this->input->post('asunto');
            $datos_insertar['comentario'] = $this->input->post('comentario');
            $datos_insertar['usuario'] = $this->session->userdata['mail'];
            $this->M_comisiones->agregarcomentario($datos_insertar);
            redirect('Comisiones/ver/' . $this->input->post('id_datos'));
        }
    }

    public function votar() {
        $datos_insertar['rating_id'] = $this->input->post("id");
        $datos_insertar['rating_num'] = $this->input->post("rating");
        $datos_insertar['mail_voto'] = $this->session->userdata['mail'];
        //print_r($datos_insertar);
        $this->M_comisiones->insertarVoto($datos_insertar);
    }

    public function prueba() {

        $data['prueba'] = $this->M_comisiones->prueba();
        echo $this->session->userdata('mail');
        echo "<br><br><br>";
        print_r($data);
    }

}
