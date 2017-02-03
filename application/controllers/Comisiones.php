<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comisiones extends CI_Controller {

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
        if ($this->session->userdata('logueado')) {
            $this->validateident();
            
            $borra_indice = array();
            $data['listado'] = $this->M_comisiones->get_todos();

            foreach ($data['listado'] as $item => $valor) {
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
                    $valor->mail_usuario = $Comi['listado_com'][0]->mail_usuario;
                    $valor->actualizaciones = $Comi['listado_com'][0]->actualizaciones;
                    $valor->fecha_creacion = $Comi['listado_com'][0]->fecha_creacion;
                    $valor->fecha_actualizacion = $Comi['listado_com'][0]->fecha_actualizacion;

                    //$Mapa['listado_lugares'] = $this->M_comisiones->get_lugares($valor->LUGAR_COMISION);
                    $Mapa['listado_lugares'] = $this->M_comisiones->get_lugares($valor->id_datos);

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

                    if ($Comi['listado_com'][0]->ejecutada == 1) {
                        $borra_indice[] = $item;
                    }
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
                    $valor->mail_usuario = "";
                    $valor->actualizaciones = "";
                    $valor->fecha_creacion = "";
                    $valor->fecha_actualizacion = "";
                }
            }

            foreach ($borra_indice as $borrar) {
                unset($data['listado'][$borrar]);
            }

            $this->template->title('Comisiones');
            $this->template->append_metadata("<script type='text/javascript' src='" . base_url() . "public/js/datatables.min.js'></script>
            <script type='text/javascript' src='" . base_url() . "public/js/comisiones_list.js'></script></script><script type='text/javascript' src='" . base_url() . "public/js/estilos.js'></script>");
            $this->template->build('comisiones/view_list_comisiones', $data);
        }else {
            redirect(base_url("index.php/login/iniciar_sesion"));
        }
    }

    public function agregar($interno_gen = null, $interno_enc = null, $vigencia = null, $cod_unidad = null, $tipo_comision = null) {
        if (($interno_gen == NULL || !is_numeric($interno_gen)) || ($interno_enc == NULL || !is_numeric($interno_enc)) ||
                ($vigencia == NULL || !is_numeric($vigencia)) || ($cod_unidad == NULL ) || ($tipo_comision == NULL)) {
            echo "Parametros Invalidos";
            //return;
        } else {
            $data['datos_comisiones'] = $this->M_comisiones->get_by_id($interno_gen, $interno_enc, $vigencia, $cod_unidad);
            $data['temas'] = $this->M_tema->get_todos();
            $data['tipo_comision'] = $tipo_comision;
            $data['criterios'] = $this->M_criterio->get_todos();
            $Rutas['ruta_comision'] = $this->M_comisiones->ruta_comision($interno_gen, $interno_enc, $vigencia);

            $data['interno_gen'] = $interno_gen;
            $data['interno_enc'] = $interno_enc;
            $data['vigencia'] = $vigencia;
            $data['cod_unidad'] = $cod_unidad;

            $Aereo = 0;
            $Terreste = 0;
            $Otro = 0;

            foreach ($Rutas['ruta_comision'] as $Key => $Ruta) {
                $TipoRuta = $Ruta->TIPO_TRANSPORTE;

                switch ($TipoRuta) {
                    case "A":
                        $Aereo++;
                        break;
                    case "T":
                        $Terreste++;
                        break;
                    case "O":
                        $Otro++;
                        break;
                }
            }

            $TiposRuta = "";
            $RutaA = "";
            $RutaT = "";
            $RutaO = "";

            if ($Aereo >= 1) {
                $TiposRuta = " Aéreo(A)";
                $RutaA = "A";
            }
            if ($Terreste >= 1) {
                if ($TiposRuta == "") {
                    $TiposRuta = " Terrestre(T)";
                    $RutaT = "T";
                } else {
                    $TiposRuta.= " - Terrestre(T)";
                    $RutaT = "T";
                }
            }
            if ($Otro >= 1) {
                if ($TiposRuta == "") {
                    $TiposRuta = " Otro(O)";
                    $RutaO = "O";
                } else {
                    $TiposRuta.= " - Otro(O)";
                    $RutaO = "O";
                }
            }

            $data['TipoRuta'] = $TiposRuta;
            $data['RutaA'] = $RutaA;
            $data['RutaT'] = $RutaT;
            $data['RutaO'] = $RutaO;

            if (empty($data['datos_comisiones'])) {
                echo "Parametros invalidos, reporte al administrador la url.";
            } else {
                if ($this->input->post()) {

                    $Tema = $this->input->post('tema');

                    $datos_insertar['interno_gen'] = $interno_gen;
                    $datos_insertar['interno_enc'] = $interno_enc;
                    $datos_insertar['vigencia'] = $vigencia;
                    $datos_insertar['codigo_unidad_ejecutora'] = $cod_unidad;
                    $datos_insertar['id_tema'] = $this->input->post('tema');
                    $datos_insertar['tipo_comi'] = $tipo_comision;
                    $datos_insertar['resumen_comision'] = $this->input->post('resumen');
                    //$datos_insertar['participantes'] = $this->input->post('participantes');
                    $datos_insertar['com_administradores_id'] = $this->session->userdata('id_user');
                    $datos_insertar['actualizaciones'] = 0;
                    $datos_insertar['fecha_creacion'] = date('Y-m-d');
                    $datos_insertar['aplicaciones_entidad'] = $this->input->post('aplicaciones');
                    $datos_insertar['recomendaciones'] = $this->input->post('conclusiones');
                    $datos_insertar['estado_actual'] = 1;

                    $id_datos = $this->M_comisiones->add($datos_insertar);

                    $datos_estado['id_datos'] = $id_datos;
                    $datos_estado['id_estado'] = 1;
                    $datos_estado['usuario'] = $this->session->userdata('usuario');
                    $datos_estado['observaciones'] = "Registro de comisión";

                    $this->M_estado->add_estado($datos_estado);

                    if ($tipo_comision = "N") {
                        if ($Tema == "4") {
                            $Criterios = $this->input->post('criterio');

                            foreach ($Criterios as $Criterio) {

                                $AspPositivos = $this->input->post('asp_positivos_' . $Criterio);
                                $OpotunidadesMejora = $this->input->post('oportunidades_mejora_' . $Criterio);
                                $AplicacionesEntidad = $this->input->post('aplicaciones_entidad_' . $Criterio);

                                $datos_aprendizaje['id_datos_aprendizaje'] = $id_datos;
                                $datos_aprendizaje['id_criterio_ap'] = $Criterio;
                                $datos_aprendizaje['fortalezas_ap'] = $AspPositivos;
                                $datos_aprendizaje['oportunidades_ap'] = $OpotunidadesMejora;
                                $datos_aprendizaje['aplicaciones_ap'] = $AplicacionesEntidad;

                                $this->M_aspectos->add_aspectos_aprendizaje($datos_aprendizaje);
                            }
                        } else {
                            $ActividadesDesa = $this->input->post('nal_actdesarro');
                            $FortalezasPosit = $this->input->post('nal_positivos');
                            $OportunidadesMe = $this->input->post('nal_dificultades');

                            foreach ($ActividadesDesa as $Key => $Valor) {
                                $datos_aspectos['id_datos_otros'] = $id_datos;
                                $datos_aspectos['actividades_desarrolladas_ot'] = $ActividadesDesa[$Key];
                                $datos_aspectos['fortalezas_asp_positivos_ot'] = $FortalezasPosit[$Key];
                                $datos_aspectos['oportunidades_mejora_ot'] = $OportunidadesMe[$Key];

                                if ($ActividadesDesa[$Key] != "" || $FortalezasPosit[$Key] != "" || $OportunidadesMe[$Key] != "") {
                                    $this->M_aspectos->add_aspectos_otros($datos_aspectos);
                                }
                            }
                        }
                    } else {
                        $TemasTratados = $this->input->post('temas_tra');
                        $Lecciones = $this->input->post('lecciones');
                        $Oportunidades = $this->input->post('oportunidades');

                        foreach ($TemasTratados as $Key => $Valor) {
                            $datos_aspectos['id_datos_otros'] = $id_datos;
                            $datos_aspectos['actividades_desarrolladas_ot'] = $TemasTratados[$Key];
                            $datos_aspectos['fortalezas_asp_positivos_ot'] = $Lecciones[$Key];
                            $datos_aspectos['oportunidades_mejora_ot'] = $Oportunidades[$Key];

                            if ($TemasTratados[$Key] != "" || $Lecciones[$Key] != "" || $Oportunidades[$Key] != "") {
                                $this->M_aspectos->add_aspectos_otros($datos_aspectos);
                            }
                        }
                    }

                    $num_contactos = count($this->input->post('nombre_con'));

                    if ($num_contactos > 0) {
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

                            if ($nombre_con[$i] != "" || $apellido_con[$i] != "" || $cargo_con[$i] != "" || $mail_con[$i] != "" || $telefono_con[$i] != "") {
                                $this->M_comisiones->add_contactos($datos_contacto);
                            }
                        }
                    }

                    $Nombre = "certificadoper";
                    $this->do_upload($Nombre, $id_datos, "C");

                    $pasabordo = $this->input->post('RutaA');
                    if ($pasabordo != "") {
                        $Nombre = "pasabordo";
                        $this->do_upload($Nombre, $id_datos, $pasabordo);
                    }

                    $tiquete = $this->input->post('RutaT');
                    if ($tiquete != "") {
                        $Nombre = "tiquete";
                        $this->do_upload($Nombre, $id_datos, $tiquete);
                    }

                    $otraruta = $this->input->post('RutaO');
                    if ($otraruta != "") {
                        $Nombre = "otraruta";
                        $this->do_upload($Nombre, $id_datos, $otraruta);
                    }

                    $num_archivos = count($_FILES ['archivo'] ['name']);
                    $NombreArchivo = $_FILES ['archivo'] ['name'];
                    if ($num_archivos > 0 && $NombreArchivo[0] != "") {
                        $this->do_upload_multi($id_datos);
                    }

                    $IdUser = $this->session->userdata('id_user');
                    $filename = $interno_gen . $interno_enc . $vigencia . $cod_unidad . $IdUser . ".json";
                    $mode = "w+";

                    $Ruta = dirname(FCPATH);
                    $RutaFull = $Ruta . "/comisiones/uploads/borrador/" . $filename;

                    if (file_exists($RutaFull)) {
                        unlink($RutaFull);
                    }

                    redirect('comisiones/ver/' . $id_datos . "/exito");
                } else {

                    $data['borrador'] = $this->borrador($interno_gen, $interno_enc, $vigencia, $cod_unidad);

                    $this->template->set_layout('layout_gen.php');

                    $this->template->title('Completar Comisi&oacute;n');
                    $this->template->append_metadata("<script src='" . base_url() . "public/js/comisiones.js'></script>
                        <script src='" . base_url() . "public/js/bootstrapValidator.min.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
                    $this->template->build('comisiones/view_form_comisiones', $data);
                }
            }
        }
    }

    public function borrador($interno_gen, $interno_enc, $vigencia, $cod_unidad) {

        $IdUser = $this->session->userdata('id_user');

        if (empty($IdUser)) {
            redirect('login');
        } else {
            $borrador = "";
            $filename = $interno_gen . $interno_enc . $vigencia . $cod_unidad . $IdUser . ".json";
            $mode = "w+";

            $Ruta = dirname(FCPATH);
            $RutaFull = $Ruta . "/comisiones/uploads/borrador/" . $filename;

            if (file_exists($RutaFull)) {
                $File = file_get_contents($RutaFull);
                $borrador = json_decode($File, true);
                //var_dump($borrador);
                /* foreach ($borrador as $key => $valor) {
                  echo $key;
                  echo $valor;
                  } */
            }
            return $borrador;
        }
    }

    public function noejecutada($interno_gen = null, $interno_enc = null, $vigencia = null, $cod_unidad = null, $tipo_comision = null) {
        if (($interno_gen == NULL || !is_numeric($interno_gen)) || ($interno_enc == NULL || !is_numeric($interno_enc)) ||
                ($vigencia == NULL || !is_numeric($vigencia)) || ($cod_unidad == NULL ) || ($tipo_comision == NULL)) {
            echo "Parametros Invalidos";
        } else {
            $datos_insertar['interno_gen'] = $interno_gen;
            $datos_insertar['interno_enc'] = $interno_enc;
            $datos_insertar['vigencia'] = $vigencia;
            $datos_insertar['codigo_unidad_ejecutora'] = $cod_unidad;
            $datos_insertar['id_tema'] = 1;
            $datos_insertar['tipo_comi'] = $tipo_comision;
            $datos_insertar['resumen_comision'] = "No ejecutada";
            $datos_insertar['participantes'] = "No ejecutada";
            $datos_insertar['com_administradores_id'] = $this->session->userdata('id_user');
            $datos_insertar['actualizaciones'] = 0;
            $datos_insertar['fecha_creacion'] = date('Y-m-d');
            $datos_insertar['ejecutada'] = 1;
            $datos_insertar['aplicaciones_entidad'] = "No ejecutada";
            $datos_insertar['recomendaciones'] = "No ejecutada";

            $id_datos = $this->M_comisiones->add($datos_insertar);

            redirect('comisiones/propias/');
        }
    }

    public function editar($id = NULL, $tipo_comision = null, $error = null) {
        if ($id == NULL || !is_numeric($id)) {
            echo "Parametros Invalidos";
            return;
        } else {
            $data['datos_comisiones'] = $this->M_comisiones->get_by_id_datos($id);

            if (empty($data['datos_comisiones'])) {
                echo "Parametros invalidos D";
            } else {
                if ($this->input->post()) {

                    $Tema = $this->input->post('tema');
                    $act = $this->input->post('actualizaciones');
                    $act = $act + 1;

                    if ($act < 1000) {
                        $datos_estado['id_datos'] = $id;
                        $datos_estado['id_estado'] = 1;
                        $datos_estado['usuario'] = $this->session->userdata('usuario');
                        $datos_estado['observaciones'] = "Ajuste informe de comisión";

                        $this->M_estado->add_estado($datos_estado);

                        $datos_insertar['resumen_comision'] = $this->input->post('resumen');
                        //$datos_insertar['participantes'] = $this->input->post('participantes');
                        $datos_insertar['aplicaciones_entidad'] = $this->input->post('aplicaciones');
                        $datos_insertar['recomendaciones'] = $this->input->post('conclusiones');
                        $datos_insertar['actualizaciones'] = $act;
                        $datos_insertar['estado_actual'] = 1;

                        $this->M_comisiones->edit_datos_general($id, $datos_insertar);

                        if ($tipo_comision = "N") {
                            if ($Tema == "4") {
                                $IdAspectosAp = $this->input->post('id_asp_ap');
                                $AspPositivos = $this->input->post('asp_positivos');
                                $OpotunidadesMejora = $this->input->post('oportunidades_mejora');
                                $AplicacionesEntidad = $this->input->post('aplicaciones_entidad');

                                foreach ($IdAspectosAp as $Key => $Criterio) {
                                    $IdAspectoAp = $IdAspectosAp[$Key];
                                    $datos_aprendizaje['fortalezas_ap'] = $AspPositivos[$Key];
                                    $datos_aprendizaje['oportunidades_ap'] = $OpotunidadesMejora[$Key];
                                    $datos_aprendizaje['aplicaciones_ap'] = $AplicacionesEntidad[$Key];

                                    $this->M_aspectos->edit_aspectos_aprendizaje($IdAspectoAp, $datos_aprendizaje);
                                }
                            } else {
                                $IdAspectosOtros = $this->input->post('id_asp_ot');
                                $ActividadesDesa = $this->input->post('nal_actdesarro');
                                $FortalezasPosit = $this->input->post('nal_positivos');
                                $OportunidadesMe = $this->input->post('nal_dificultades');

                                foreach ($IdAspectosOtros as $Key => $Valor) {
                                    $IdAspectoOtro = $IdAspectosOtros[$Key];
                                    $datos_aspectos['actividades_desarrolladas_ot'] = $ActividadesDesa[$Key];
                                    $datos_aspectos['fortalezas_asp_positivos_ot'] = $FortalezasPosit[$Key];
                                    $datos_aspectos['oportunidades_mejora_ot'] = $OportunidadesMe[$Key];
                                    
                                    if($IdAspectoOtro == "new"){
                                        if ($ActividadesDesa[$Key] != "" || $FortalezasPosit[$Key] != "" || $OportunidadesMe[$Key] != "") {
                                            $datos_aspectos['id_datos_otros'] = $id;
                                            $this->M_aspectos->add_aspectos_otros($datos_aspectos);
                                        }
                                    }else{
                                        if($IdAspectoOtro != ""){
                                            if ($ActividadesDesa[$Key] != "" || $FortalezasPosit[$Key] != "" || $OportunidadesMe[$Key] != "") {
                                                $this->M_aspectos->edit_aspectos_otros($IdAspectoOtro, $datos_aspectos);
                                            }
                                        }else{
                                            if ($ActividadesDesa[$Key] != "" || $FortalezasPosit[$Key] != "" || $OportunidadesMe[$Key] != "") {
                                                $datos_aspectos['id_datos_otros'] = $id;
                                                $this->M_aspectos->add_aspectos_otros($datos_aspectos);
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            $IdAspectosOtros = $this->input->post('id_asp_oti');
                            $TemasTratados = $this->input->post('temas_tra');
                            $Lecciones = $this->input->post('lecciones');
                            $Oportunidades = $this->input->post('oportunidades');

                            foreach ($IdAspectosOtros as $Key => $Valor) {
                                $IdAspectoOtro = $IdAspectosOtros[$Key];
                                $datos_aspectos['actividades_desarrolladas_ot'] = $TemasTratados[$Key];
                                $datos_aspectos['fortalezas_asp_positivos_ot'] = $Lecciones[$Key];
                                $datos_aspectos['oportunidades_mejora_ot'] = $Oportunidades[$Key];

                                if ($TemasTratados[$Key] != "" || $Lecciones[$Key] != "" || $Oportunidades[$Key] != "") {
                                    $this->M_aspectos->edit_aspectos_otros($IdAspectoOtro, $datos_aspectos);
                                }
                            }
                        }

                        $num_contactos = count($this->input->post('nombre_con'));

                        if ($num_contactos > 0) {
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

                                if ($nombre_con[$i] != "" || $apellido_con[$i] != "" || $cargo_con[$i] != "" || $mail_con[$i] != "" || $telefono_con[$i] != "") {
                                    $this->M_comisiones->add_contactos($datos_contacto);
                                }
                            }
                        }

                        $num_archivos = count($_FILES ['archivo'] ['name']);
                        $nombre_archivo = $_FILES ['archivo'] ['name'][0];

                        if ($num_archivos > 0 && $nombre_archivo != null) {
                            $this->do_upload_multi($id);
                        }

                        redirect('comisiones/ver/' . $id . "/editar");
                    } else {
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
                    $data['archivos_ruta'] = $this->M_comisiones->get_by_archivos_ruta($id);
                    $data['imagenes'] = $this->M_comisiones->get_by_imagenes($id);
                    $data['contactos'] = $this->M_comisiones->get_by_contactos($id);
                    $data['temas'] = $this->M_tema->get_todos();
                    $data['error'] = $error;
                    //$data['tipos'] = $this->M_tema->get_todos_tipo();

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

        if ($id_contacto == NULL || !is_numeric($id_contacto)) {
            echo "El id es invalido.";
            return;
        } else {
            $data['datos_contacto'] = $this->M_comisiones->get_by_id_contacto($id_contacto);
            if (empty($data['datos_contacto'])) {
                echo "El contacto es invalido o no existe";
            } else {
                $datos_insertar['id_datos_con'] = $id_datos_edit;
                $datos_insertar['nombre'] = $this->input->post('nombre_edit');
                $datos_insertar['apellido'] = $this->input->post('apellido_edit');
                $datos_insertar['cargo'] = $this->input->post('cargo_edit');
                $datos_insertar['mail'] = $this->input->post('mail_edit');
                $datos_insertar['telefono'] = $this->input->post('telefono_edit');

                $this->M_comisiones->edit_contacto($datos_insertar, $id_contacto);
                redirect('Comisiones/editar/' . $id_datos_edit);
            }
        }
    }

    public function delete_contacto() {

        $id_contacto = $this->input->post('idcontacto_delete');
        $id_datos_edit = $this->input->post('id_datos_delete');

        if ($id_contacto == NULL || !is_numeric($id_contacto)) {
            echo "El id es invalido.";
            return;
        } else {
            $data['datos_contacto'] = $this->M_comisiones->get_by_id_contacto($id_contacto);
            if (empty($data['datos_contacto'])) {
                echo "El contacto es invalido o no existe";
            } else {

                $this->M_comisiones->delete_contacto($id_contacto);
                redirect('Comisiones/editar/' . $id_datos_edit);
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
                //print_r($data['datos_comisiones']);
                $data['aspectos'] = $data['datos_comisiones'];
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
                $data['archivos_ruta'] = $this->M_comisiones->get_by_archivos_ruta($id);
                $data['imagenes'] = $this->M_comisiones->get_by_imagenes($id);
                $data['contactos'] = $this->M_comisiones->get_by_contactos($id);
                $data['error'] = $error;

                $fecha_hoy = date('Y-m-d');
                $vistas_user = $this->M_comisiones->get_by_visitas_user($id, $this->session->userdata('mail'), $fecha_hoy);
                $num_vistas_user = $vistas_user[0]->vistos;
                $mail_usuario = $data['datos_comisiones'][0]->mail_usuario;

                $vistas_total = $this->M_comisiones->get_by_visitas($id);
                $num_vistas = $vistas_total[0]->vistos;

                if ($num_vistas_user == 0 and $mail_usuario != $this->session->userdata('mail')) {
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

    public function do_upload($NombreCampo, $IdDatos, $TipoRuta) {
        
        $nombre = $this->session->userdata('id_user').convert_accented_characters($_FILES[$NombreCampo]['name']);
        echo $nombre;
        $this->load->library('upload');
        $config = "";
        $config['upload_path'] = './uploads/legalizacion/';
        $config['allowed_types'] = 'doc|docx|xls|xlsx|pdf';
        $config['max_size'] = 2048000;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;
        $config['remove_spaces'] = true;
        $config['overwrite'] = true;
        $config['file_name'] = $nombre;
        $config['remove_spaces'] = true;
        //$this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($NombreCampo)) {
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
            exit();
        } else {
            $data[] = "";
            unset($_FILES[$NombreCampo]);
            $data = array('upload_data' => $this->upload->data());
            $datos_archivo_rutas['id_datos_ruta'] = $IdDatos;
            $datos_archivo_rutas['tipo_ruta'] = $TipoRuta;
            $datos_archivo_rutas['archivo_ruta'] = base_url('uploads/legalizacion/');
            $datos_archivo_rutas['archivo'] = $data['upload_data']['file_name'];

            $this->M_comisiones->add_archivos_rutas($datos_archivo_rutas);
            return true;
        }
    }

    public function do_upload_multi($id_datos_rev) {
        $this->load->library('upload');

        $files = $_FILES;
        $cpt = count($_FILES ['archivo'] ['name']);

        $tipo_anexo = $this->input->post('tipo_anexo');
        $resumen_archivo = $this->input->post('resumen_archivo');

        if ($cpt > 0) {
            for ($i = 0; $i < $cpt; $i ++) {

                $_FILES ['archivo'] ['name'] = $files ['archivo'] ['name'] [$i];
                $_FILES ['archivo'] ['type'] = $files ['archivo'] ['type'] [$i];
                $_FILES ['archivo'] ['tmp_name'] = $files ['archivo'] ['tmp_name'] [$i];
                $_FILES ['archivo'] ['error'] = $files ['archivo'] ['error'] [$i];
                $_FILES ['archivo'] ['size'] = $files ['archivo'] ['size'] [$i];

                $nombre = $this->session->userdata('id_user').convert_accented_characters($files ['archivo'] ['name'] [$i]);
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
                    /* print_r($error);
                      exit(); */
                } else {
                    $data = array('upload_data' => $this->upload->data());
                    $datos_archivo['id_arc_datos'] = $id_datos_rev;
                    $datos_archivo['tipo_archivo'] = $tipo_anexo[$i];
                    $datos_archivo['archivo_ruta'] = base_url('uploads/');
                    $datos_archivo['archivo'] = $data['upload_data']['file_name'];
                    $datos_archivo['resumen_archivo'] = $resumen_archivo[$i];

                    $this->M_comisiones->add_archivos($datos_archivo);
                }
            }
        }
    }

    public function do_upload_multi_img($id_datos_rev, $tipo) {
        $this->load->library('upload');

        $files = $_FILES;
        $cpt = count($_FILES ['imagen'] ['name']);
        echo "cantidad de imagenes: " . $cpt;
        for ($i = 0; $i < $cpt; $i ++) {

            $_FILES ['imagen'] ['name'] = $files ['imagen'] ['name'] [$i];
            $_FILES ['imagen'] ['type'] = $files ['imagen'] ['type'] [$i];
            $_FILES ['imagen'] ['tmp_name'] = $files ['imagen'] ['tmp_name'] [$i];
            $_FILES ['imagen'] ['error'] = $files ['imagen'] ['error'] [$i];
            $_FILES ['imagen'] ['size'] = $files ['imagen'] ['size'] [$i];

            $nombre = $this->session->userdata('id_user').convert_accented_characters($files ['imagen'] ['name'] [$i]);
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

    public function do_upload_legalizacion($NombreCampo, $IdDatos, $TipoRuta) {
        $this->load->library('upload');
        $config = "";
        $config['upload_path'] = './uploads/legalizacion/';
        $config['allowed_types'] = 'doc|docx|xls|xlsx|pdf';
        $config['max_size'] = 2048000;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;
        $config['remove_spaces'] = true;
        $config['overwrite'] = true;
        $config['file_name'] = $this->session->userdata('id_user').convert_accented_characters($_FILES[$NombreCampo]['name']);
        $config['remove_spaces'] = true;
        //$this->load->library('upload', $config);
        $this->upload->initialize($config);
            
        if (!$this->upload->do_upload($NombreCampo)) {
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
        } else {
            $data[] = "";
            unset($_FILES[$NombreCampo]);
            $data = array('upload_data' => $this->upload->data());
            $datos_archivo_rutas['tipo_ruta'] = $TipoRuta;
            $datos_archivo_rutas['archivo_ruta'] = base_url('uploads/legalizacion/');
            $datos_archivo_rutas['archivo'] = $data['upload_data']['file_name'];

            $this->M_comisiones->update_file_legalizacion($IdDatos, $datos_archivo_rutas);
            return true;
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
                echo $data[0]->latitud . "/" . $data[0]->longitud;
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
            $interno_gen = $valor->interno_gen;
            $interno_enc = $valor->interno_enc;
            $vigencia = $valor->vigencia;
            $cod_unidad = $valor->codigo_unidad_ejecutora;

            $Comi['listado_com'] = $this->M_comisiones->get_comision_id(0, $interno_gen, $interno_enc, $vigencia, $cod_unidad);

            $valor->LUGAR_COMISION = $Comi['listado_com'][0]->LUGAR_COMISION;
            $valor->NOMBRE = $Comi['listado_com'][0]->NOMBRE;
            $valor->OBJETO = $Comi['listado_com'][0]->OBJETO;
            $valor->FECHA_INICIAL = $Comi['listado_com'][0]->FECHA_INICIAL;
            $valor->FECHA_FINAL = $Comi['listado_com'][0]->FECHA_FINAL;
            $valor->LUGAR_COMISION = $Comi['listado_com'][0]->LUGAR_COMISION;

            $Mapa['listado_lugares'] = $this->M_comisiones->get_lugares($valor->id_datos);

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
            <script src='" . base_url() . "public/js/comisiones_list.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
        $this->template->build('comisiones/view_list_comisiones', $data);
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
                $valor->mail_usuario = $Comi['listado_com'][0]->mail_usuario;
                $valor->actualizaciones = $Comi['listado_com'][0]->actualizaciones;
                $valor->fecha_creacion = $Comi['listado_com'][0]->fecha_creacion;
                $valor->fecha_actualizacion = $Comi['listado_com'][0]->fecha_actualizacion;
                $valor->ejecutada = $Comi['listado_com'][0]->ejecutada;

                $Mapa['listado_lugares'] = $this->M_comisiones->get_lugares($valor->id_datos);
                $Estado = $this->M_estado->get_estado_all($valor->id_datos);

                if ($Estado != null) {
                    $valor->estado_comi = $Estado[0]->estado;
                } else {
                    $valor->estado_comi = "";
                }

                if ($Mapa['listado_lugares'] != NULL) {
                    $valor->id_lugar = $Mapa['listado_lugares'][0]->id_lugar;
                    $valor->lugar = $Mapa['listado_lugares'][0]->lugar;
                    $valor->direccion = $Mapa['listado_lugares'][0]->direccion;
                    $valor->mapa = "com_lugares";
                } else {
                    $valor->id_lugar = "";
                    $valor->lugar = "";
                    $valor->direccion = "";
                    $valor->mapa = "";
                }
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
                $valor->mail_usuario = "";
                $valor->actualizaciones = "";
                $valor->fecha_creacion = "";
                $valor->fecha_actualizacion = "";
                $valor->ejecutada = "";
                $sedes['listado_lugares'] = $this->M_comisiones->get_sedesSubsedes($valor->LUGAR_COMISION);

                if ($sedes['listado_lugares'] != NULL) {
                    $valor->id_lugar = $sedes['listado_lugares'][0]->id_sedes_subsedes;
                    $valor->lugar = $sedes['listado_lugares'][0]->lugar;
                    $valor->direccion = $sedes['listado_lugares'][0]->direccion;
                    $valor->mapa = "com_sedes_subsedes";
                } else {
                    $valor->id_lugar = "";
                    $valor->lugar = "";
                    $valor->direccion = "";
                    $valor->mapa = "";
                }
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

            $destino = $this->input->post('destino');

            if ($destino == "propias") {
                redirect('comisiones/propias');
            } else {
                redirect('comisiones');
            }
        }
    }

    public function prueba_correo() {
        $FileName = base_url("public/images/mail-comisiones-pendientes.png");   
        echo $FileName;
        $this->load->library('email');
        $configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => 'Ou67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
        //cargamos la configuraci�n para enviar mail
        $this->email->initialize($configMail);
        $this->email->from('aplicaciones@dane.gov.co', 'Innovación');
        $this->email->to('dasuarezt@dane.gov.co');
        $this->email->cc('diegosuarezt87@gmail.com');
        $this->email->subject('Recordatorio Comision');
        $this->email->attach($FileName);
        $cid = $this->email->attachment_cid($FileName);   
        
        $html = '<center><p><a href="http://somos.dane.gov.co"><img src="cid:'.$cid.'" border="0" ></a></p></center>'; 

        $this->email->message($html);
        $this->email->send();
        if (!$this->email->send()) {
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

    public function mapa($id_datos = null, $lugar = null, $destino = null, $id_lugar = null) {

        if ($lugar == NULL) {
            echo "El lugar no es valido";
            return;
        } else {
            if ($id_lugar != null) {
                if ($id_datos == "N") {
                    $data["lugares"] = $this->M_comisiones->get_by_id_sedes($id_lugar);
                } else {
                    $data["lugares"] = $this->M_comisiones->get_by_id_mapa($id_lugar);
                }
            } else {
                $data["lugares"] = "";
            }
        }

        $data["lugar"] = $lugar;
        $data["destino"] = $destino;
        $data["id_datos"] = $id_datos;
        $data['id_lugar'] = $id_lugar;

        $this->template->set_layout('layout_full.php');
        $this->template->title('Comisiones Propias');
        $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
            <script src='" . base_url() . "public/js/mapa.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
        $this->template->build('mapa/view_mapa', $data);
        //$this->load->view('mapa/view_mapa',$data);
    }

    public function addmapa_api() {

        if ($this->input->post()) {

            $id_datos = $this->input->post('id_datos');

            if ($id_datos != "N") {
                $datos_insertar['id_datos'] = $id_datos;
                $datos_insertar['mapa'] = "vacio";
            }

            $datos_insertar['lugar'] = $this->input->post('lugar');
            $datos_insertar['direccion'] = $this->input->post('direccion');
            $datos_insertar['latitud'] = $this->input->post('latitud');
            $datos_insertar['longitud'] = $this->input->post('longitud');

            $destino = $this->input->post('destino');
            $accion = $this->input->post('accion');

            if ($accion == 0) {
                if ($id_datos != "N") {
                    $this->M_comisiones->agregarmapa($datos_insertar);
                } else {
                    $this->M_comisiones->agregarsede($datos_insertar);
                }
            } else {
                if ($id_datos != "N") {
                    $this->M_comisiones->actualizarmapa($datos_insertar, $this->input->post('id_lugar'));
                } else {
                    $this->M_comisiones->actualizarmapasede($datos_insertar, $this->input->post('id_lugar'));
                }
            }

            if ($destino == "propias") {
                redirect('comisiones/propias');
            } else {
                redirect('comisiones');
            }
        }
    }

    public function deletemapa($destino = NULL, $id_mapa = NULL, $id_datos = NULL) {
        if ($id_datos != "N") {
            $this->M_comisiones->deletemapa($id_mapa);
        } else {
            $this->M_comisiones->deletemapasede($id_mapa);
        }

        if ($destino == "propias") {
            redirect('comisiones/propias');
        } else {
            redirect('comisiones');
        }
    }

    public function mapa2() {

        $data = "";
        $this->load->view('mapa/view_mapa_modal', $data);
    }

    public function prueba() {

        $data['prueba'] = $this->M_comisiones->prueba();
        echo "<br><br><br>";
        print_r($data);
    }

    public function validateident() {
        if ($this->session->userdata('logueado')) {
            $ident = $this->session->userdata('identificacion');
            if ($ident != null) {
                return true;
            } else {
                redirect(base_url('index.php/perfil/validateident'));
            }
        } else {
            redirect(base_url("index.php/login/iniciar_sesion"));
        }
    }
    
    public function edit_file_legalizacion() {
        $IdArchivo = $this->input->post('IdFileNew');
        $TipoArchivo = $this->input->post('TipFile');
        $IdDatosEdit = $this->input->post('iddatosedit');
        $TipoComi = $this->input->post('tipocomision');
        
        $error = null;

        if ($IdArchivo == NULL || !is_numeric($IdArchivo)) {
            $error = "Error";
            redirect('Comisiones/editar/' . $IdDatosEdit.'/'.$TipoComi."/".$error);
        } else {
            $error = "Exito";
            $Nombre = "newfile";
            $this->do_upload_legalizacion($Nombre, $IdArchivo, $TipoArchivo);
            redirect('Comisiones/editar/' . $IdDatosEdit.'/'.$TipoComi."/".$error);
        }
    }
    
    public function delete_file_comi($id = null, $id_comi = null, $Tipo = null) {
        if($id != null){
            $Ruta = "index.php/Comisiones/editar/".$id_comi."/".$Tipo;
            $this->M_comisiones->delete_archivo($id);
            redirect(base_url($Ruta));
        }else{
            return false;
        }
    }
    
    public function prueba_ident_usu($Ident){
        $Datos = $this->M_comisiones->get_todos_ident_prueba($Ident);
        echo "<pre>";
        var_dump($Datos);
    }
}
