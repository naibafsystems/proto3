<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->model('M_cron');
        $this->load->model('M_comisiones');
        $this->load->model('M_tema');
        $this->load->model('M_criterio');
        $this->load->model('M_aspectos');
        $this->load->model('M_estado');
        $this->load->model('M_borrador');
        $this->load->model('Usuario');
        $this->template->set_layout('layout_gen_tbl.php');
        date_default_timezone_set('America/Bogota');
    }

    public function index() {
        
        $data['Users'] = $this->M_cron->get_all_users();
        
        foreach ($data['Users'] as $User) {
            
            $MailEnviado = "";
            $Respuesta = $this->Usuario->get_user_crm($User->usuario);
            
            if($Respuesta != null){
                $IdentUser = $Respuesta[0]->NUM_IDENT;
            
                $data['Comisiones'] = $this->M_comisiones->get_todos_ident($IdentUser);

                if($data['Comisiones'] != null){
                    foreach ($data['Comisiones'] as $valor){                        
                        $interno_gen = $valor->INTERNO_GEN;
                        $interno_enc = $valor->INTERNO_ENC;
                        $vigencia = $valor->VIGENCIA;
                        $cod_unidad = $valor->CODIGO_UNIDAD_EJECUTORA;
                        
                        $Comi['listado_com'] = $this->M_comisiones->get_todos_com($interno_gen, $interno_enc, $vigencia, $cod_unidad);
                        
                        if ($Comi['listado_com'] == null) {
                            $FechaActual = date('Y-m-d');
                            $FechaFinComi = $valor->FECHA_FINAL;
                            $Dias = $this->diferencia_fechas($FechaActual, $FechaFinComi);
                            
                            if ($Dias > 4){
                                if ($MailEnviado != $User->mail_usuario){
                                    $this->envio_correo($User->mail_usuario);
                                    echo "Comision: ".$valor->LUGAR_COMISION."<br>";
                                    echo "Correo a: ".$User->mail_usuario."<br>";
                                    echo "Dias desde termino de comsion: ".$Dias."<br><br>";
                                    $MailEnviado = $User->mail_usuario; 
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    public function diferencia_fechas($Fecha1, $Fecha2){
        $FechaActual = $Fecha1;
        $Da = explode("-", $FechaActual);
        $diaNac = $Da[2];
        $mesNac = $Da[1];
        $anoNac = $Da[0];

        $FechaActual = mktime(0, 0, 0, "$mesNac", "$diaNac", "$anoNac");

        $FechaProximo = $Fecha2;
        $Da1 = explode("-", $FechaProximo);
        $diaNac1 = $Da1[2];
        $mesNac1 = $Da1[1];
        $anoNac1 = $Da1[0];

        $FechaProximo = mktime(0, 0, 0, "$mesNac1", "$diaNac1", "$anoNac1");

        $Diferencia = ($FechaActual - $FechaProximo);
        $Dias = $Diferencia / (60 * 60 * 24);
        
        return $Dias;
    }

    public function envio_correo($Destino) {
        $FileName = base_url("public/images/mail-comisiones-pendientes.png");     
        $this->load->library('email');
        $configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => 'Ou67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
        //cargamos la configuracion para enviar mail
        $this->email->initialize($configMail);
        $this->email->from('aplicaciones@dane.gov.co', 'Somos DANE');
        $this->email->to($Destino);
        //$this->email->cc('dasuarezt@dane.gov.co');
        $this->email->subject('Recordatorio comisiones pendientes');
        $this->email->attach($FileName);
        $cid = $this->email->attachment_cid($FileName);   
        
        $html = '<center><p><a href="http://somos.dane.gov.co"><img src="cid:'.$cid.'" border="0" ></a></p></center>'; 

        $this->email->message($html);
        $this->email->send();
        
        if (!$this->email->send()) {
            echo "Envio de Correo Exitoso a: ".$Destino;
        } else {
            echo "Error al enviar el correo a: ".$Destino;
        }
        
        return true;
    }
}
