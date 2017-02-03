<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Palabras extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->model('M_tema');
        $this->load->model('M_palabras');
        $this->load->model('M_comisiones');
        $this->template->set_layout('layout_gen_tbl.php');
        date_default_timezone_set('America/Bogota');
    }

    public function index($tipo_comi = null, $aspecto = null, $criterio = null, $palabra = null) {
        
        $Identificacion = $this->session->userdata['identificacion'];
        
        // 1 = Aprendizaje, 2 = Nacional, 3 = internacional
        switch ($tipo_comi){
            case 2:
                if($palabra == ""){
                    $data['listado'] = $this->M_palabras->get_all_nacional();
                }
                else{
                    $data['listado'] = $this->M_palabras->get_all_nacional_palabra($palabra,$aspecto);
                }
                break;
            case 3:
                if($palabra == ""){
                    $data['listado'] = $this->M_palabras->get_all_internacional();
                }else{
                    $data['listado'] = $this->M_palabras->get_all_internacional_palabra($palabra,$aspecto);
                }
                break;
            default :
                if($palabra == ""){
                    $data['listado'] = $this->M_palabras->get_all_aprendizaje();
                }else{
                    $data['listado'] = $this->M_palabras->get_all_aprendizaje_palabra($palabra,$aspecto);
                }
                break;
        }
        
        $palabras_busqueda = "";
        
        foreach ($data['listado'] as $valor){
            $Interno_gen = $valor->interno_gen;
            $Interno_enc = $valor->interno_enc;
            $Vigencia    = $valor->vigencia;
            $CodUnidadEjec = $valor->codigo_unidad_ejecutora;
            $comision['listado'] = $this->M_comisiones->get_comision_id($Identificacion,$Interno_gen,$Interno_enc,$Vigencia,$CodUnidadEjec);
            
            $valor->LUGAR_COMISION = $comision['listado'][0]->LUGAR_COMISION;
            $valor->NOMBRE = $comision['listado'][0]->NOMBRE;
            $valor->OBJETO = $comision['listado'][0]->OBJETO;
            
            switch ($tipo_comi){
                case 2:
                    if($aspecto == "p"){
                        $palabras_busqueda.= $valor->nal_positivos;
                    }elseif($aspecto == "n"){
                        $palabras_busqueda.= $valor->nal_dificultades;
                    }else{
                        $palabras_busqueda.= $valor->aplicaciones;
                    }
                    break;
                case 3:
                    if($aspecto == "p"){
                        $palabras_busqueda.= $valor->lecciones;
                    }elseif($aspecto == "n"){
                        $palabras_busqueda.= $valor->oportunidades;
                    }else{
                        $palabras_busqueda.= $valor->aplicaciones;
                    }
                    break;
                default :
                    if($aspecto == "p"){
                        switch ($criterio){
                            case 1:
                            case 2:
                            case 3:
                            case 4:
                            case 5:
                                if($valor->id_criterio_ap == $criterio){
                                    $palabras_busqueda.= $valor->fortalezas_ap;
                                }
                                break;
                            default:
                                $palabras_busqueda.= $valor->fortalezas_ap;
                                break;
                        }
                    }elseif($aspecto == "n"){
                        switch ($criterio){
                            case 1:
                            case 2:
                            case 3:
                            case 4:
                            case 5:
                                if($valor->id_criterio_ap == $criterio){
                                    $palabras_busqueda.= $valor->oportunidades_ap;
                                }
                                break;
                            default:
                                $palabras_busqueda.= $valor->oportunidades_ap;
                                break;
                        }
                    }else{
                        switch ($criterio){
                            case 1:
                            case 2:
                            case 3:
                            case 4:
                            case 5:
                                if($valor->id_criterio_ap == $criterio){
                                    $palabras_busqueda.= $valor->aplicaciones_ap;
                                }
                                break;
                            default:
                                $palabras_busqueda.= $valor->aplicaciones_ap;
                                break;
                        }
                    }
                    
                    break;
            }
        }
        
        if(strlen($palabras_busqueda) > 1){
            $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
            $permitidas  =  array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
            $texto = str_replace($no_permitidas, $permitidas ,$palabras_busqueda);
            
            $textoLimpio = preg_replace('([^A-Za-z0-9])', ' ', $texto);	 

            $palabras_array = explode(" ", $textoLimpio);

            $palabras_count = array_count_values($palabras_array);
            //print_r($palabras_count);
            foreach ($palabras_count as $valor=>$item){
                if (strlen($valor) < 5 || $item < 2){
                    unset($palabras_count[$valor]);
                }
            }
            
            $ValidaCantidad = count($palabras_count);
            
            if($ValidaCantidad > 0){
                $minFontSize = 1;
                $maxFontSize = 8;

                //print_r($palabras_count);
                //print_r($data['listado']);
                //exit();

                $min = min($palabras_count);
                $max = max($palabras_count);
                $diferencia = $max - $min;
                if($diferencia <= 0){
                    $diferencia = 1;
                }
                $maxfont = $maxFontSize;
                
                if ($criterio != ""){
                    $file = base_url()."index.php/palabras/index/".$tipo_comi."/".$aspecto."/".$criterio."/";
                }else{
                    $file = base_url()."index.php/palabras/index/".$tipo_comi."/".$aspecto."/j/";
                }

                ksort($palabras_count);

                foreach ($palabras_count as $tag => $count){
                    $valor_relativo = round((($count - $min) / $diferencia) * 10);
                    if($count > $min){
                       $size = $maxfont * ($count-$min) / ($max - $min);
                       $cloudTags[] = '<span class="etiquetatam'.$valor_relativo.'"><a href='.$file.$tag.'>'.$tag.'</a></span>';
                    }else{
                       $size = $minFontSize;
                       $cloudTags[] = '<span class="etiquetatam'.$valor_relativo.'"><a href='.$file.$tag.'>'.$tag.'</a></span>';
                    }
                }
                $cloudTags[] = "<div style='clear:both'></div>";

                //print_r($palabras_count);
                $data['palabras'] = join("\n",$cloudTags);
            }  else {
                $data['palabras'] = '';
            }
        }else{
            $data['palabras'] = '';
        }
        
        $data['tipo_comi_sel'] = $tipo_comi;
        $data['aspecto_sel'] = $aspecto;
        $data['criterio_sel'] = $criterio;
        
        $this->template->title('Nube de palabras');
        $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
                                          <script src='" . base_url() . "public/js/palabras.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
        $this->template->build('palabras/view_list_palabras', $data);
    }
    
    public function addanalisis(){
        
        $Comision = $this->input->post('tipo_comision');
        
        switch ($Comision){
            case "2":
                $TipoCriterio = "Nacional";
                break;
            case "3":
                $TipoCriterio = "Internacional";
                break;
            default :
                $TipoCriterio = "Aprendizaje";
                break;
        }
        
        $Aspecto = $this->input->post('aspecto_sel');
        
        switch ($Aspecto){
            case "p":
                $TipoAspecto = "Aspectos positivos";
                break;
            case "n":
                $TipoAspecto = "Aspectos por mejorar";
                break;
            default :
                $TipoAspecto = "Aplicaciones para la entidad";
                break;
        }
        
        $Criterio = $this->input->post('criterio_sel');
        
        switch ($Criterio){
            case "1":
                $TipoCriterio = "Participación de los candidatos en el proceso de aprendizaje";
                break;
            case "2":
                $TipoCriterio = "Cumplimiento de la agenda o de los protocolos de la actividad";
                break;
            case "3":
                $TipoCriterio = "Comentarios sobre los materiales de aprendizaje y las pruebas de conocimiento (b-learning) ";
                break;
            case "4":
                $TipoCriterio = "Disponibilidad de equipos tecnológicos y funcionamiento de la plataforma de aprendizaje ";
                break;
            case "5":
                $TipoCriterio = "Otras observaciones ";
                break;
        }
        
        $datos_insertar['id_tipo_tema'] = $this->input->post('tipo_comision');
        $datos_insertar['aspecto'] = $TipoAspecto;
        $datos_insertar['id_criterio'] = $TipoCriterio;
        $datos_insertar['descripcion'] = $this->input->post('analisis');
        $datos_insertar['mail_destino'] = $this->input->post('destinatario');
        
        $this->M_palabras->add_analisis($datos_insertar);
        
        redirect('palabras/analisis');
        //redirect('palabras/analisis' . $id_datos . "/exito");
           
    }

    public function analisis($tipo_comi = null, $aspecto = null, $criterio = null, $usuario = null){
        $data = "";
        
        $data['tipo_comi_sel'] = $tipo_comi;
        $data['aspecto_sel'] = $aspecto;
        $data['criterio_sel'] = $criterio;
        
        $data['listado'] = $this->M_palabras->get_all_analisis();       
        
        $this->template->title('Gestionar');
        $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
                                          <script src='" . base_url() . "public/js/analisis.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
        $this->template->build('palabras/view_analisis_palabras', $data);
    }

    public function propias($tipo_comi = null, $aspecto = null, $criterio = null, $usuario = null){
        $data = "";
        
        $data['tipo_comi_sel'] = $tipo_comi;
        $data['aspecto_sel'] = $aspecto;
        $data['criterio_sel'] = $criterio;
        
        $data['listado'] = $this->M_palabras->get_analisis_user();       
        
        $this->template->title('Gestionar');
        $this->template->append_metadata("<script src='" . base_url() . "public/js/datatables.min.js'></script>
                                          <script src='" . base_url() . "public/js/analisis_propios.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script>");
        $this->template->build('palabras/view_analisis_propio', $data);
    }
    
    public function gestionuser($id = null, $actividad = null, $fecha = null){
        
        $datos_insertar['actividades'] = $this->input->post("id2");
        $datos_insertar['fecha_actividad'] = $this->input->post("id3");
        $datos_insertar['estado'] = 1;
        $id = $this->input->post("id");
        
        $this->M_palabras->edit_datos_analisis($id,$datos_insertar);
        
        echo "Exito";
        //redirect('palabras/analisis/propias');
    }
    
    public function todo() {

        $data['listado'] = $this->M_palabras->get_all_aprendizaje();
        
        echo "
        <table class='table table-striped' id='TblComisiones'>
            <thead>
                <th class='col-lg-2 text-center'>Lugar</th>
                <th class='col-lg-2 text-center'>Datos de contacto</th>
                <th class='col-lg-7 text-center'>Descripción</th>
                <th class='col-lg-1 text-center'>Informe</th>
            </thead>
            <tbody>";
                foreach ($data['listado'] as $valor){
                    echo "<tr>";
                        echo "<td>".$valor->id_datos."</td>";
                        echo "<td>".$valor->mail_autor."</td>";
                        echo "<td>".$valor->resumen_comision."</td>";
                        echo "<td class='text-center'><a href='".base_url()."index.php/Comisiones/ver/".$valor->id_datos."' class='' target='_black' ><i title='Detalle' class='fa fa-file-text-o fa-2x' aria-hidden='true'></a></td>";
                    echo "</tr>";
                    
                }
      echo "
            </tbody>
        </table>";

    }
}
