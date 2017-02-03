<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Revision extends CI_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->model('M_comisiones');
        $this->load->model('M_tema');
        $this->load->model('M_criterio');
        $this->load->model('M_aspectos');
		$this->load->model('M_revision');
		
        $this->template->set_layout('layout_gen_tbl.php');
        date_default_timezone_set('America/Bogota');
    }

    public function index() {
        
		$usuarios_gh = $this->M_revision->get_usuarios_gh($this->session->userdata('usuario'));
		$usuarios_cc = $this->M_revision->get_usuarios_cc($this->session->userdata('usuario'));
		$usuarios_co = $this->M_revision->get_usuarios_co($this->session->userdata('usuario'));
		$usuarios_te = $this->M_revision->get_usuarios_te($this->session->userdata('usuario'));
		
		if(count($usuarios_gh) > 0)
		{
			$data['estados'] = $this->M_revision->estados();
		
			$this->template->title('Legalizaci&oacute;n');
			$this->template->append_metadata("
			<link rel='stylesheet' type='text/css' href='".base_url('public/css/fileinput/fileinput.css')."' media='all' />
			<link rel='stylesheet' type='text/css' href='".base_url('public/css/validationEngine.jquery.css')."' media='all' />
			<script type='text/javascript' src='".base_url('public/js/fileinput/fileinput.js')."' ></script>
			<script type='text/javascript' src='".base_url('public/js/fileinput/fileinput_locale_es.js')."' ></script>
			<script type='text/javascript' src='".base_url('public/js/jquery.validationEngine.js')."' ></script>
			<script type='text/javascript' src='".base_url('public/js/jquery.validationEngine-es.js')."' ></script>
			<script src='" . base_url() . "public/js/datatables.min.js'></script>
				<script src='" . base_url() . "public/js/comisiones_list.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script></script>
				<script src='" . base_url() . "public/js/revision.js'></script>");
			
			if($usuarios_gh[0]->perfil == 'Coordinador'){
				$this->template->build('revision/view_list_legalizacion_aprobacion', $data);
			}else{
				$this->template->build('revision/view_list_legalizacion', $data);
			}		
				
			
			
		}else if(count($usuarios_cc) > 0){
			
			$this->template->title('Central de cuentas');
			$this->template->append_metadata("
			<link rel='stylesheet' type='text/css' href='".base_url('public/css/fileinput/fileinput.css')."' media='all' />
			<link rel='stylesheet' type='text/css' href='".base_url('public/css/validationEngine.jquery.css')."' media='all' />
			<script type='text/javascript' src='".base_url('public/js/fileinput/fileinput.js')."' ></script>
			<script type='text/javascript' src='".base_url('public/js/fileinput/fileinput_locale_es.js')."' ></script>
			<script type='text/javascript' src='".base_url('public/js/jquery.validationEngine.js')."' ></script>
			<script type='text/javascript' src='".base_url('public/js/jquery.validationEngine-es.js')."' ></script>
			<script src='" . base_url() . "public/js/datatables.min.js'></script>
				<script src='" . base_url() . "public/js/comisiones_list.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script></script>
				<script src='" . base_url() . "public/js/revision.js'></script>");
			$this->template->build('revision/view_list_central');
			
		}else if(count($usuarios_co) > 0){
			
			$this->template->title('Contabilidad');
			$this->template->append_metadata("
			<link rel='stylesheet' type='text/css' href='".base_url('public/css/fileinput/fileinput.css')."' media='all' />
			<link rel='stylesheet' type='text/css' href='".base_url('public/css/validationEngine.jquery.css')."' media='all' />
			<script type='text/javascript' src='".base_url('public/js/fileinput/fileinput.js')."' ></script>
			<script type='text/javascript' src='".base_url('public/js/fileinput/fileinput_locale_es.js')."' ></script>
			<script type='text/javascript' src='".base_url('public/js/jquery.validationEngine.js')."' ></script>
			<script type='text/javascript' src='".base_url('public/js/jquery.validationEngine-es.js')."' ></script>
			<script src='" . base_url() . "public/js/datatables.min.js'></script>
				<script src='" . base_url() . "public/js/comisiones_list.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script></script>
				<script src='" . base_url() . "public/js/revision.js'></script>");
			$this->template->build('revision/view_list_contabilidad');
			
		}else if(count($usuarios_te) > 0){  
			
			$this->template->title('Tesoreria');
			$this->template->append_metadata("
			<link rel='stylesheet' type='text/css' href='".base_url('public/css/fileinput/fileinput.css')."' media='all' />
			<link rel='stylesheet' type='text/css' href='".base_url('public/css/validationEngine.jquery.css')."' media='all' />
			<script type='text/javascript' src='".base_url('public/js/fileinput/fileinput.js')."' ></script>
			<script type='text/javascript' src='".base_url('public/js/fileinput/fileinput_locale_es.js')."' ></script>
			<script type='text/javascript' src='".base_url('public/js/jquery.validationEngine.js')."' ></script>
			<script type='text/javascript' src='".base_url('public/js/jquery.validationEngine-es.js')."' ></script>
			<script src='" . base_url() . "public/js/datatables.min.js'></script>
				<script src='" . base_url() . "public/js/comisiones_list.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script></script>
				<script src='" . base_url() . "public/js/revision.js'></script>");
			$this->template->build('revision/view_list_tesoreria');
			
		}else{
			$this->template->build('revision/view_usuario_no_aut');
		}
		
    }
	
	public function revisa() {   
		
        $data['dependencia_jefe'] = $this->M_revision->get_dependencia_jefe($this->session->userdata('identificacion'));		
		$data['estados'] = $this->M_revision->estados_revision();
		
        $this->template->title('Revisi&oacute;n');
        $this->template->append_metadata("
		<link rel='stylesheet' type='text/css' href='".base_url('public/css/fileinput/fileinput.css')."' media='all' />
		<link rel='stylesheet' type='text/css' href='".base_url('public/css/validationEngine.jquery.css')."' media='all' />
		<script type='text/javascript' src='".base_url('public/js/fileinput/fileinput.js')."' ></script>
		<script type='text/javascript' src='".base_url('public/js/fileinput/fileinput_locale_es.js')."' ></script>
		<script type='text/javascript' src='".base_url('public/js/jquery.validationEngine.js')."' ></script>
		<script type='text/javascript' src='".base_url('public/js/jquery.validationEngine-es.js')."' ></script>
		<script src='" . base_url() . "public/js/datatables.min.js'></script>
            <script src='" . base_url() . "public/js/comisiones_list.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script></script>
			<script src='" . base_url() . "public/js/revision.js'></script>");
        $this->template->build('revision/view_list_revision', $data);
    }
	
	
	
	public function guardarEstado(){
		$msjAd = ""; 
		if(isset($_FILES['docAjustes']) && $_FILES['docAjustes']['size'] > 0){
			$config['upload_path'] = './uploads/ajustes/';
			$config['allowed_types'] = 'doc|docx|pdf|jpg';
			$config['max_size'] = 2048000;			
			$config['overwrite'] = true;
			$config['file_name'] = convert_accented_characters($_FILES['docAjustes']['name']);
			$config['remove_spaces'] = true;
			//echo $config['upload_path'];
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('docAjustes')) {
				$error = array('error' => $this->upload->display_errors());
				//var_dump($error);exit;
			} else {
				$data = array('upload_data' => $this->upload->data());
				/*
				$this->load->library('email');
				$configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => 'Ou67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
				//cargamos la configuraci?n para enviar mail
				$this->email->initialize($configMail);
				
				$this->email->set_newline("\r\n");  
				$this->email->from('somosdane@dane.gov.co', 'Somos Dane');
				$this->email->to('esanchez1988@gmail.com');
				//$this->email->cc('diegosuarezt87@gmail.com');
				$this->email->attach($data['upload_data']['full_path']);
				$filename = base_url("public/images/logo-portal-1_0.png");
				$this->email->attach($filename);
				$cid = $this->email->attachment_cid($filename);
				$this->email->subject('Ajuste informe comisión');
				
				//$imagen = '<img src='.base_url().'public/images/logo-portal-1_0.png" />';
				//$Link = '<a href='.base_url().'>'.$imagen.'</a>';
				
				//$html = $Link;
				$html = '  
							<center><p><img src="cid:'.$cid.'" border="0"><p></center>
							Apreciado usuario:
							<p>Se ha realizado la revisión de la comisión y adjunto viene un documento con los ajustes correspondientes. </p>
							<p><b>Observaciones: '.$_REQUEST['observaciones'].'</b></p>
							<p>Puede ingresar al siguiente <a href="' . base_url() . '" target="_blank">Link</a> y realizar los ajustes y de nuevo enviarlo para las respectiva revisión</p>
							<p>Gracias por su compromiso con la entidad.</p>
							
						  ';

				$this->email->message($html);
				$this->email->send();
				if (!$this->email->send()) {
					$msjAd = "";
				} else {
					$msjAd = "Error al enviar el correo, por favor notifique al administrador del aplicativo.";
				}
				*/
			}
		}else{
			$funcionariosGH = $this->M_revision->consultaFuncionariosGH(); 
			/*
			$this->load->library('email');
			$configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => 'Ou67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
			//cargamos la configuraci?n para enviar mail
			$this->email->initialize($configMail);
			$this->email->from('somosdane@dane.gov.co', 'Somos Dane');
			for($i=0;$i<count($funcionariosGH);$i++){
				$this->email->to($funcionariosGH[$i]->nom_usuario.'@dane.gov.co');
			}
			//$this->email->to('esanchez1988@gmail.com');
			$this->email->cc('esanchez1988@gmail.com');
			$filename = base_url("public/images/logo-portal-1_0.png");
			$this->email->attach($filename);
			$cid = $this->email->attachment_cid($filename);
			$this->email->subject('Nueva comisión Gestión Humana');
			
			//$imagen = '<img src='.base_url().'public/images/logo-portal-1_0.png" />';
			//$Link = '<a href='.base_url().'>'.$imagen.'</a>';
			
			//$html = $Link;
			$html = '  
						<center><p><img src="cid:'.$cid.'" border="0"><p></center>
						Apreciados usuarios:
						<p>Se ha realizado la aprobación de una comisión de parte de una dependencia, por favor ingrese al siguiente <a href="' . base_url() . '" target="_blank">link</a> y continue con el proceso</p>
						<p><b>Observaciones: '.$_REQUEST['observaciones'].'</b></p>
						<p>Gracias por su compromiso con la entidad.</p>
						
					  ';

			$this->email->message($html);
			$this->email->send();
			if (!$this->email->send()) {
				$msjAd = "";
			} else {
				$msjAd = "Error al enviar el correo, por favor notifique al administrador del aplicativo.";
			}
			*/
		}
		
		$datos['id_datos'] = $_REQUEST['id_datos'];
		$datos['id_estado'] = $_REQUEST['estado'];
		$datos['usuario'] = $this->session->userdata('usuario');
		$datos['observaciones'] = $_REQUEST['observaciones'];
		$datos['fecha_actualizacion'] = date('Y-m-d H:i:s');
		$cambioEstado = $this->M_revision->guardarEstado($datos); 
		
		$datos['id_datos'] = $_REQUEST['id_datos'];
		$datos['estado_actual'] = $_REQUEST['estado'];
		$datos['fecha_actualizacion'] = date('Y-m-d H:i:s');
		$cambioEstado = $this->M_revision->guardarEstadoActual($datos); 
			
		if($cambioEstado)
		{
			$this->session->set_flashdata('retornoExito', 'Se realizo la actualizaci&oacute;n con exito. '.$msjAd );
			redirect(base_url('index.php/revision/revisa'), 'refresh');
			exit;
		}else
		{
			$this->session->set_flashdata('retornoError', 'Por favor verifique la informaci&oacute;n, no fue posible actualizar la informaci&oacuten.'.$msjAd);
			redirect(base_url('index.php/revision/revisa'), 'refresh');
			exit;
		}
	}
	
	public function guardarLegalizacion(){
		
		if($_REQUEST['estado'] == 3){
			
			$datos['id_datos'] = $_REQUEST['id_datos']; 
			$datos['id_estado'] = $_REQUEST['estado'];
			$datos['fecha_actualizacion'] = date('Y-m-d H:i:s');
			$datos['usuario'] = $this->session->userdata('usuario');
			$datos['observaciones'] = $_REQUEST['observaciones'];
			$cambioEstado = $this->M_revision->guardarEstado($datos);
			
			$datosAct['id_datos'] = $_REQUEST['id_datos']; 
			$datosAct['estado_actual'] = $_REQUEST['estado']; 
			$cambioEstadoActual = $this->M_revision->guardarEstadoActual($datosAct);
			
			$usuarioComision = $this->M_revision->consultaUsuarioComision($_REQUEST['cedula']); 
			//var_dump($usuarioComision);	  
			/*
			$this->load->library('email');
			$configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => 'Ou67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
			//cargamos la configuraci?n para enviar mail
			$this->email->initialize($configMail);
			$this->email->from('aplicaciones@dane.gov.co', 'Somos Dane');
			
			$this->email->to($usuarioComision[0]->MAIL_USUARIO);
			//$this->email->to('esanchez1988@gmail.com');
			$this->email->cc('esanchez1988@gmail.com');
			$filename = base_url("public/images/logo-portal-1_0.png");
			$this->email->attach($filename);
			$cid = $this->email->attachment_cid($filename);
			$this->email->subject('Devolución comisión');
			
			//$imagen = '<img src='.base_url().'public/images/logo-portal-1_0.png" />';
			//$Link = '<a href='.base_url().'>'.$imagen.'</a>';
			
			//$html = $Link;
			$html = '  
						<center><p><img src="cid:'.$cid.'" border="0"><p></center>
						Apreciado usuario:
						<p>Se ha realizado la revisión de la comisión y esta ha sido devuelta, por favor ingrese al siguiente <a href="' . base_url() . '" target="_blank">link</a> y continue con el proceso</p>
						<p><b>Observaciones: '.$_REQUEST['observaciones'].'</b></p>
						<p>Gracias por su compromiso con la entidad.</p>
						
					  ';
			
			$this->email->message($html);
			//$this->email->send();
			if ($this->email->send()) {
				$msjAd = "";
			} else {
				$msjAd = "Error al enviar el correo, por favor notifique al administrador del aplicativo.";
			}
			*/
			$this->session->set_flashdata('retornoExito', 'Se realizo la actualizaci&oacute;n con exito' );
			redirect(base_url('index.php/revision/'), 'refresh');
			exit;
			
		}else{
			
			if($_REQUEST['tipo_cuenta'] == 'avance'){
			
				if(isset($_FILES['docReintegro']) && $_FILES['docReintegro']['size'] > 0){
					$resumen_archivo = $this->input->post('resumen_archivo');
				
					$config_rein['upload_path'] = './uploads/legalizacion/';
					$config_rein['allowed_types'] = 'pdf';
					$config_rein['max_size'] = 5000;			
					$config_rein['overwrite'] = true;
					//$config_rein['file_name'] = convert_accented_characters($_FILES['docReintegro']['name']);
					$config_rein['remove_spaces'] = true;

					$this->load->library('upload', $config_rein);

					if (!$this->upload->do_upload('docReintegro')) {
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('retornoError', 'No fue posible cargar el archivo de Reintegro. Error: '.$this->upload->display_errors());
						redirect(base_url('index.php/revision/'), 'refresh');
						exit;
					} else {
						$data_rein = array('upload_data' => $this->upload->data());
						
						$datosLega['doc_reintegro'] = $data_rein['upload_data']['file_name'];
					}
				}else{
					$datosLega['doc_reintegro'] = '';
				}
				
				
			}else{
				$datosLega['doc_reintegro'] = '';
			}
				
			//DOCUMENTO CDP
			$config_cdp['upload_path'] = './uploads/legalizacion/';
			$config_cdp['allowed_types'] = 'pdf';
			$config_cdp['max_size'] = 5000;			
			$config_cdp['overwrite'] = true;
			//$config_cdp['file_name'] = convert_accented_characters($_FILES['docCDP']['name']);
			$config_cdp['remove_spaces'] = true;

			$this->load->library('upload', $config_cdp);

			if (!$this->upload->do_upload('docCDP')) {
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('retornoError', 'No fue posible cargar el archivo de CDP. Error: '.$this->upload->display_errors());
				redirect(base_url('index.php/revision/'), 'refresh');
				exit;
			} else {
				
				$data_cdp = array('upload_data' => $this->upload->data());
				
				$datosLega['doc_cdp'] = $data_cdp['upload_data']['file_name'];
			}
			
			//DOCUMENTO RP
			$config_rp['upload_path'] = './uploads/legalizacion/';
			$config_rp['allowed_types'] = 'pdf';
			$config_rp['max_size'] = 5000;			
			$config_rp['overwrite'] = true;
			//$config_rp['file_name'] = convert_accented_characters($_FILES['docRP']['name']);
			$config_rp['remove_spaces'] = true;

			$this->load->library('upload', $config_rp);
			
			if (!$this->upload->do_upload('docRP')) {
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('retornoError', 'No fue posible cargar el archivo de RP. Error: '.$this->upload->display_errors());
				redirect(base_url('index.php/revision/'), 'refresh');
				exit;
			} else {
				
				$data_rp = array('upload_data' => $this->upload->data());
				
				$datosLega['doc_rp'] = $data_rp['upload_data']['file_name'];
			}
			
			//DOCUMENTO docRE
			$config_re['upload_path'] = './uploads/legalizacion/';
			$config_re['allowed_types'] = 'pdf';
			$config_re['max_size'] = 5000;			
			$config_re['overwrite'] = true;
			//$config_re['file_name'] = convert_accented_characters($_FILES['docRE']['name']);
			$config_re['remove_spaces'] = true;

			$this->load->library('upload', $config_re);

			if (!$this->upload->do_upload('docRE')) {
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('retornoError', 'No fue posible cargar el archivo de Resoluci&oacute;n. Error: '.$this->upload->display_errors());
				redirect(base_url('index.php/revision/'), 'refresh');
				exit;
			} else {
				$data_re = array('upload_data' => $this->upload->data());
				
				$datosLega['doc_re'] = $data_re['upload_data']['file_name'];  
			}
			
			//DOCUMENTO Formato Legalizacion
			$config_fl['upload_path'] = './uploads/legalizacion/';
			$config_fl['allowed_types'] = 'pdf';
			$config_fl['max_size'] = 5000;			
			$config_fl['overwrite'] = true;
			$config_fl['file_name'] = convert_accented_characters($_FILES['docFL']['name']);
			$config_fl['remove_spaces'] = true;

			$this->load->library('upload', $config_fl);

			if (!$this->upload->do_upload('docFL')) {
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('retornoError', 'No fue posible cargar el archivo de Formato Legalizaci&oacute;n. Error: '.$this->upload->display_errors());
				redirect(base_url('index.php/revision/'), 'refresh');
				exit;
			} else {
				$data_fl = array('upload_data' => $this->upload->data());
				
				$datosLega['doc_fl'] = $data_fl['upload_data']['file_name'];
			}
				
			$datos['id_datos'] = $_REQUEST['id_datos']; 
			$datos['id_estado'] = $_REQUEST['estado'];
			$datos['fecha_actualizacion'] = date('Y-m-d H:i:s');
			$datos['usuario'] = $this->session->userdata('usuario');
			$datos['observaciones'] = $_REQUEST['observaciones'];
			$cambioEstado = $this->M_revision->guardarEstado($datos);
			
			$datosAct['id_datos'] = $_REQUEST['id_datos']; 
			$datosAct['estado_actual'] = $_REQUEST['estado']; 
			$cambioEstadoActual = $this->M_revision->guardarEstadoActual($datosAct);
			
			$datosLega['id_datos'] = $_REQUEST['id_datos']; 
			$datosLega['fecha_legalizacion'] = date('Y-m-d H:i:s');
			$datosLega['estado'] = 'AC';
			
			if($_REQUEST['tipo_cuenta'] == 'avance'){
				$datosLega['tipo_cuenta'] = 'AV';
				$coordinadorCO = $this->M_revision->consultaCoorCO(); 
				$datosLega['asignado'] = $coordinadorCO[0]->nom_usuario;
			}else{
				$datosLega['tipo_cuenta'] = 'CU';
				$coordinadorCC = $this->M_revision->consultaCoorCC(); 
				$datosLega['asignado'] = $coordinadorCC[0]->nom_usuario;
			}	
			
			$guardarLegalizacion = $this->M_revision->guardarLegalizacion($datosLega); 
				
			if($guardarLegalizacion)
			{
				$coordinadorGH = $this->M_revision->consultaCoorGH(); 
				/*
				$this->load->library('email');
				$configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => 'Ou67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
				//cargamos la configuraci?n para enviar mail
				$this->email->initialize($configMail);
				$this->email->from('aplicaciones@dane.gov.co', 'Somos Dane');
				$this->email->to($coordinadorGH[0]->nom_usuario.'@dane.gov.co');
				//$this->email->to('esanchez1988@gmail.com');
				$this->email->cc('esanchez1988@gmail.com');
				$filename = base_url("public/images/logo-portal-1_0.png");
				$this->email->attach($filename);
				$cid = $this->email->attachment_cid($filename);
				$this->email->subject('Aprobación comisión');
				
				//$imagen = '<img src='.base_url().'public/images/logo-portal-1_0.png" />';
				//$Link = '<a href='.base_url().'>'.$imagen.'</a>';
				
				//$html = $Link;
				$html = '  
							<center><p><img src="cid:'.$cid.'" border="0"><p></center>
							Apreciado usuario:
							<p>Se ha realizado la revisión de una nueva comisión para su aprobación, por favor ingrese al siguiente <a href="' . base_url() . '" target="_blank">link</a> y continue con el proceso</p>
							<p><b>Observaciones: '.$_REQUEST['observaciones'].'</b></p>
							<p>Gracias por su compromiso con la entidad.</p>
							
						  ';

				$this->email->message($html);
				//$this->email->send();
				if ($this->email->send()) {
					$msjAd = "";
				} else {
					$msjAd = "Error al enviar el correo, por favor notifique al administrador del aplicativo.";
				}
				*/
				$this->session->set_flashdata('retornoExito', 'Se realizo la actualizaci&oacute;n con exito' );
				redirect(base_url('index.php/revision/'), 'refresh');
				exit;
			}else
			{
				$this->session->set_flashdata('retornoError', 'Por favor verifique la informaci&oacute;n, no fue posible actualizar la informaci&oacuten');
				redirect(base_url('index.php/revision/'), 'refresh');
				exit;
			}
			
		}
		
	}
	
	public function guardarAprobacion(){
				
		$datos['id_datos'] = $_REQUEST['id_datos']; 
		$datos['id_estado'] = $_REQUEST['estado'];
		$datos['fecha_actualizacion'] = date('Y-m-d H:i:s');
		$datos['usuario'] = $this->session->userdata('usuario');
		$datos['observaciones'] = $_REQUEST['observaciones'];
		$cambioEstado = $this->M_revision->guardarEstado($datos);
		
		$datosAct['id_datos'] = $_REQUEST['id_datos']; 
		$datosAct['estado_actual'] = $_REQUEST['estado']; 
		$cambioEstadoActual = $this->M_revision->guardarEstadoActual($datosAct);
		      
		if($_REQUEST['estado'] == 2){    
			$datosEst['id_datos'] = $_REQUEST['id_datos']; 
			$datosEst['estado'] = 'IN'; 
			$cambioEstadoLegaliza = $this->M_revision->actualizarEstadoAprobacion($datosEst);
			
			$funcionariosGH = $this->M_revision->consultaFuncionariosGH(); 
			/*
			$this->load->library('email');
			$configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => 'Ou67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
			//cargamos la configuraci?n para enviar mail
			$this->email->initialize($configMail);
			$this->email->from('aplicaciones@dane.gov.co', 'Somos Dane');
			for($i=0;$i<count($funcionariosGH);$i++){
				$this->email->to($funcionariosGH[$i]->nom_usuario.'@dane.gov.co');
			}
			//$this->email->to('esanchez1988@gmail.com');
			$this->email->cc('esanchez1988@gmail.com');
			$filename = base_url("public/images/logo-portal-1_0.png");
			$this->email->attach($filename);
			$cid = $this->email->attachment_cid($filename);
			$this->email->subject('Ajuste comisión Gestión Humana');
			
			//$imagen = '<img src='.base_url().'public/images/logo-portal-1_0.png" />';
			//$Link = '<a href='.base_url().'>'.$imagen.'</a>';
			
			//$html = $Link;
			$html = '  
						<center><p><img src="cid:'.$cid.'" border="0"><p></center>
						Apreciados usuarios:
						<p>Se ha realizado la revisión de una comisión y ha sido devuelta para revisión, por favor ingrese al siguiente <a href="' . base_url() . '" target="_blank">link</a> y continue con el proceso</p>
						<p><b>Observaciones: '.$_REQUEST['observaciones'].'</b></p>
						<p>Gracias por su compromiso con la entidad.</p>
						
					  ';

			$this->email->message($html);
			//$this->email->send();
			if ($this->email->send()) {
				$msjAd = "";
			} else {
				$msjAd = "Error al enviar el correo, por favor notifique al administrador del aplicativo.";
			}
			*/
		}else{ 
			
			$datosLegalizacion = $this->M_revision->consultaTipoComision($_REQUEST['id_datos']);
			
			if($datosLegalizacion[0]->tipo_cuenta == 'AV'){
				$datosLega['id_datos'] = $_REQUEST['id_datos'];
				$coordinadorCO = $this->M_revision->consultaCoorCO(); 
				$datosLega['asignado'] = $coordinadorCO[0]->nom_usuario;
			}else{
				$datosLega['id_datos'] = $_REQUEST['id_datos'];
				$coordinadorCC = $this->M_revision->consultaCoorCC(); 
				$datosLega['asignado'] = $coordinadorCC[0]->nom_usuario;
			}	
			
			$guardarLegalizacion = $this->M_revision->guardarAsignacion($datosLega); 
			
			$funcionarioAsignado = $this->M_revision->consultaUsuarioAsignado($_REQUEST['id_datos']); 
			/*
			$this->load->library('email');
			$configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => 'Ou67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
			//cargamos la configuraci?n para enviar mail
			$this->email->initialize($configMail);
			$this->email->from('aplicaciones@dane.gov.co', 'Somos Dane');
			$this->email->to($funcionarioAsignado[0]->asignado.'@dane.gov.co');
			//$this->email->to('esanchez1988@gmail.com');
			$this->email->cc('esanchez1988@gmail.com');
			$filename = base_url("public/images/logo-portal-1_0.png");
			$this->email->attach($filename);
			$cid = $this->email->attachment_cid($filename);
			$this->email->subject('Asignación revisión comisión');
			
			//$imagen = '<img src='.base_url().'public/images/logo-portal-1_0.png" />';
			//$Link = '<a href='.base_url().'>'.$imagen.'</a>';
			
			//$html = $Link;
			$html = '  
						<center><p><img src="cid:'.$cid.'" border="0"><p></center>
						Apreciados usuarios:
						<p>Se ha realizado la asignación de una comisión, por favor ingrese al siguiente <a href="' . base_url() . '" target="_blank">link</a> y continue con el proceso</p>
						<p><b>Observaciones: '.$_REQUEST['observaciones'].'</b></p>
						<p>Gracias por su compromiso con la entidad.</p>
						
					  ';

			$this->email->message($html);
			//$this->email->send();
			if ($this->email->send()) {
				$msjAd = "";
			} else {
				$msjAd = "Error al enviar el correo, por favor notifique al administrador del aplicativo.";
			}*/
		}
		
		if($cambioEstadoActual)
		{
			$this->session->set_flashdata('retornoExito', 'Se realizo la actualizaci&oacute;n con exito' );
			redirect(base_url('index.php/revision/'), 'refresh');
			exit;
		}else
		{
			$this->session->set_flashdata('retornoError', 'Por favor verifique la informaci&oacute;n, no fue posible actualizar la informaci&oacuten');
			redirect(base_url('index.php/revision/'), 'refresh');
			exit;
		}
	}
	
	public function actualizarAsignacion(){
				
		if($this->session->userdata('usuario') == NULL || $this->session->userdata('usuario') == ''){ 
			echo "<script>alert('Su sesión ha finalizado, por favor ingrese de nuevo')</script>";
			redirect(base_url(), 'refresh');
			exit;
		}else{
			$datos['id_datos'] = $_REQUEST['id_datos']; 
		
			if($_REQUEST['asignacion'] == 'mfcuenca'){
				$datos['id_estado'] = 4;
				
				$datosAct['id_datos'] = $_REQUEST['id_datos']; 
				$datosAct['estado_actual'] = 4; 
				$cambioEstadoActual = $this->M_revision->guardarEstadoActual($datosAct);
			}else{
				$datos['id_estado'] = 5;
			}
			
			if($_REQUEST['asignacion'] != 'archivo'){
				$datos['fecha_actualizacion'] = date('Y-m-d H:i:s');
				$datos['usuario'] = $this->session->userdata('usuario');
				$datos['observaciones'] = $_REQUEST['observaciones'];
				$cambioEstado = $this->M_revision->guardarEstado($datos);		
						
				$datos['id_datos'] = $_REQUEST['id_datos']; 
				$datos['asignado'] = $_REQUEST['asignacion'];
				$cambioEstado = $this->M_revision->guardarAsignacion($datos);
				
				$funcionarioAsignado = $this->M_revision->consultaUsuarioAsignado($_REQUEST['id_datos']); 
				/*	
				$this->load->library('email');
				$configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => 'Ou67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
				//cargamos la configuraci?n para enviar mail
				$this->email->initialize($configMail);
				$this->email->from('aplicaciones@dane.gov.co', 'Somos Dane');
				$this->email->to($_REQUEST['asignacion'].'@dane.gov.co');
				//$this->email->to('esanchez1988@gmail.com');
				$this->email->cc('esanchez1988@gmail.com');
				$filename = base_url("public/images/logo-portal-1_0.png");
				$this->email->attach($filename);
				$cid = $this->email->attachment_cid($filename);
				$this->email->subject('Asignación revisión comisión');
				
				//$imagen = '<img src='.base_url().'public/images/logo-portal-1_0.png" />';
				//$Link = '<a href='.base_url().'>'.$imagen.'</a>';
				
				//$html = $Link;
				$html = '  
							<center><p><img src="cid:'.$cid.'" border="0"><p></center>
							Apreciados usuarios:
							<p>Se ha realizado la asignación de una comisión, por favor ingrese al siguiente <a href="' . base_url() . '" target="_blank">link</a> y continue con el proceso</p>
							<p><b>Observaciones: '.$_REQUEST['observaciones'].'</b></p>
							<p>Gracias por su compromiso con la entidad.</p>
							
						  ';

				$this->email->message($html);
				//$this->email->send();
				if ($this->email->send()) {
					$msjAd = "";
				} else {
					$msjAd = "Error al enviar el correo, por favor notifique al administrador del aplicativo.";
				}
				*/
			}else{
				$datos['fecha_actualizacion'] = date('Y-m-d H:i:s');
				$datos['usuario'] = $this->session->userdata('usuario');
				$datos['observaciones'] = $_REQUEST['observaciones'];
				$cambioEstado = $this->M_revision->guardarEstado($datos);		
						
				$datos['id_datos'] = $_REQUEST['id_datos']; 
				$datos['asignado'] = $_REQUEST['asignacion'];
				$cambioEstado = $this->M_revision->guardarAsignacion($datos);
			}
			
			
			
			if($cambioEstado)
			{
				$this->session->set_flashdata('retornoExito', 'Se realizo la actualizaci&oacute;n con exito' );
				redirect(base_url('index.php/revision/'), 'refresh');
				exit;
			}else
			{
				$this->session->set_flashdata('retornoError', 'Por favor verifique la informaci&oacute;n, no fue posible actualizar la informaci&oacuten');
				redirect(base_url('index.php/revision/'), 'refresh');
				exit;
			}
		}		
				
		
	}
	
	public function cargarArchivo($id) {
		$this->load->library('html2pdf');

		$data['datos'] = $this->M_comisiones->get_gen_by_id($id);
		$data['contactos'] = $this->M_comisiones->get_by_contactos($id);
		
		$contenido = "  
			        <table align='center' style='width: 100%;'>			        	
			            <tr>
			                <td align='center' >
			                    <h3>Informe Comisi&oacute;n</h3>			                    
			                </td>
			            </tr>
			        </table>";
		
		//$contenido .= utf8_decode($this->load->view('revision/view_consultar_pdf', $data, true));	
			
		$contenido .= "<br><br><br><table align='center' width = '100%'>            
			    <tr>
			        <td align='center'>
			        	<img src='./images/footer_pdf.png' width='600px'>			                	
			        </td> 
			    </tr>
			</table>";
		

        $this->html2pdf->html($contenido);
		
		$this->html2pdf->folder('./uploads/pdfs/');
		
        $this->html2pdf->filename('informe-'.$id . '.pdf');
		
        $this->html2pdf->paper('Letter', 'portrait');
		
		$this->html2pdf->create('download');
		
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

    public function prueba_correo() {
        //var_dump($usuarioComision);	  
		$this->load->library('email');
		$configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => 'Ou67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
		//cargamos la configuraci?n para enviar mail
		$this->email->initialize($configMail);
		$this->email->from('aplicaciones@dane.gov.co', 'Somos Dane');
		
		$this->email->to('esanchez1988@gmail.com');
		$this->email->cc('esanchez1988@gmail.com');
		$filename = base_url("public/images/logo-portal-1_0.png");
		$this->email->attach($filename);
		$cid = $this->email->attachment_cid($filename);
		$this->email->subject('Devolución comisión');
		
		//$imagen = '<img src='.base_url().'public/images/logo-portal-1_0.png" />';
		//$Link = '<a href='.base_url().'>'.$imagen.'</a>';
		
		//$html = $Link;
		$html = '  
					<center><p><img src="cid:'.$cid.'" border="0"><p></center>
					Apreciado usuario:
					<p>Se ha realizado la revisión de la comisión y esta ha sido devuelta, por favor ingrese al siguiente <a href="' . base_url() . '" target="_blank">link</a> y continue con el proceso</p>
					<p><b>Observaciones: asdasdasdasd</b></p>
					<p>Gracias por su compromiso con la entidad.</p>
					
				  ';
		
		$this->email->message($html);
		
        if ($this->email->send()) {
            echo "Envio de Correo Exitoso";
        } else {
            echo "Error al enviar el correo";
        }
    }
	
	public function inscripcion() {
		
		$this->template->set_layout('layout_general.php');
		
		if($this->session->userdata('identificacion')){
			$data['territoriales'] = $this->M_revision->territoriales();  
			$data['tipo_contrato'] = $this->M_revision->tipo_contrato();
			$data['datos_usuario'] = $this->M_revision->datosUsuarioCedula($this->session->userdata('identificacion'));
			$inscripcion = $this->M_revision->inscripcion($this->session->userdata('identificacion'));
			
			if(is_array($inscripcion) &&  count($inscripcion) > 0){
				$this->template->title('Inscripci&oacute;n curso inducci&oacute;n');
				
				$this->template->build('revision/view_form_inscripcion_ok', $data);
			}else{
				$this->template->title('Inscripci&oacute;n curso inducci&oacute;n');
				$this->template->append_metadata("
				<link rel='stylesheet' type='text/css' href='".base_url('public/css/fileinput/fileinput.css')."' media='all' />
				<link rel='stylesheet' type='text/css' href='".base_url('public/css/validationEngine.jquery.css')."' media='all' />
				<script type='text/javascript' src='".base_url('public/js/fileinput/fileinput.js')."' ></script>
				<script type='text/javascript' src='".base_url('public/js/fileinput/fileinput_locale_es.js')."' ></script>
				<script type='text/javascript' src='".base_url('public/js/jquery.validationEngine.js')."' ></script>
				<script type='text/javascript' src='".base_url('public/js/jquery.validationEngine-es.js')."' ></script>
				<link rel='stylesheet' href='//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
				<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>
				<script src='" . base_url() . "public/js/datatables.min.js'></script>
					<script src='" . base_url() . "public/js/comisiones_list.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script></script>
					<script src='" . base_url() . "public/js/revision.js'></script>");
				$this->template->build('revision/view_form_inscripcion', $data);
			}
			
			
		}else{
			
		}
    } 
	
	public function guardarInscripcion(){
				
		
				
		$datos['identificacion'] = $_REQUEST['doc_iden']; 
		$datos['nombres'] = $_REQUEST['nombres'];
		$datos['apellidos'] = $_REQUEST['apellidos'];
		$datos['email'] = $_REQUEST['email'];
		$datos['grupo'] = $_REQUEST['grupo'];
		$datos['id_territorial'] = $_REQUEST['territorial'];
		$datos['id_ciudad'] = $_REQUEST['ciudad'];
		$datos['id_tipo_vinc'] = $_REQUEST['tipo_vinc'];
		$datos['otra_vinc'] = $_REQUEST['tipo_vinc_otra'];
		$datos['fecha_vinc'] = $_REQUEST['fecha_vinculacion'];
		$datos['fecha_fin'] = $_REQUEST['fecha_finalizacion'];
		$guardarInscr = $this->M_revision->guardarInscripcion($datos);
				
		if($guardarInscr == true)
		{
			$this->session->set_flashdata('retornoExito', '&iexcl;Muy bien! Te has inscrito correctamente. En unos d&iacute;as recibir&aacute;s confirmaci&oacute;n para que puedas ingresar a tu "Misi&oacute;n estad&iacute;stica".' );
			redirect(base_url('index.php/revision/inscripcion'), 'refresh');
			exit;
		}else
		{
			$this->session->set_flashdata('retornoError', 'No se pudo realizar el registro.');
			redirect(base_url('index.php/revision/inscripcion'), 'refresh');
			exit;
		}
	}
	
	public function rinsc() {
		
		$this->template->set_layout('layout_general.php');
		
		if($this->session->userdata('usuario') == 'emsanchezc' || $this->session->userdata('usuario') == 'hjramirezs' || $this->session->userdata('usuario') == 'yfgarzong'){
			$data['inscritos'] = $this->M_revision->total_inscritos();
			
				$this->template->title('Inscripci&oacute;n curso inducci&oacute;n');
				$this->template->append_metadata("
				<link rel='stylesheet' type='text/css' href='".base_url('public/css/fileinput/fileinput.css')."' media='all' />
				<link rel='stylesheet' type='text/css' href='".base_url('public/css/validationEngine.jquery.css')."' media='all' />
				<script type='text/javascript' src='".base_url('public/js/fileinput/fileinput.js')."' ></script>
				<script type='text/javascript' src='".base_url('public/js/fileinput/fileinput_locale_es.js')."' ></script>
				<script type='text/javascript' src='".base_url('public/js/jquery.validationEngine.js')."' ></script>
				<script type='text/javascript' src='".base_url('public/js/jquery.validationEngine-es.js')."' ></script>
				<link rel='stylesheet' href='//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
				<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>
				<script src='" . base_url() . "public/js/datatables.min.js'></script>
					<script src='" . base_url() . "public/js/comisiones_list.js'></script></script><script src='" . base_url() . "public/js/estilos.js'></script></script>
					<script src='" . base_url() . "public/js/revision.js'></script>");
				$this->template->build('revision/view_reporte_inscripcion', $data);
						
		}else{
			
		}
    } 
	
	public function cargaDatos(){ 
	
		$datosUsuario = $this->M_revision->datosUsuarioCedula($this->input->post('identificacion'));
		
		if(count($datosUsuario) > 0){
			$data = array(
				'datos' => "OK", 
				'nombres' => $datosUsuario[0]->NOM_USUARIO,
				'apellidos'=> $datosUsuario[0]->APE_USUARIO,
				'mail'=> $datosUsuario[0]->MAIL_USUARIO,
				'grupo'=> $datosUsuario[0]->DESCRIPCION
			);
		}else{
			$data = array(
				'datos' => "error",
				'mensaje' => "Error, no se encontro el usuario" 
			);
		}
		//Either you can print value or you can send value to database
		echo json_encode($data);
	}
	
	public function cargarCiudad(){
		
		$datosCiudad = $this->M_revision->datosCiudad($this->input->post('territorial'));
		
		if(count($datosCiudad)>0){
			
			echo "<option value=''>Seleccione la ciudad...</option>";  
			
			for($i=0;$i<count($datosCiudad);$i++){
				echo "<option value='".$datosCiudad[$i]->id_ciudad."'>".$datosCiudad[$i]->desc_ciudad."</option>";
			}
			
		}else{
			echo "<option value=''>Seleccione territorial</option>";
		}
		
	}
	
	public function generaWord($id_datos){
		
		header('Content-type: application/vnd.ms-word');
		header("Content-Disposition: attachment; filename=informe_comision.doc");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$info_comision = $this->M_revision->datos_comisiones($id_datos);	
		$info_contacto = $this->M_revision->datos_contacto($id_datos);	
		$info_aspectos_apr = $this->M_revision->datos_aspectos_apr($id_datos);	
		$info_aspectos_otr = $this->M_revision->datos_aspectos_otro($id_datos);	
		
		$listado_com = $this->M_comisiones->get_comision_id(0, $info_comision[0]->interno_gen, $info_comision[0]->interno_enc, $info_comision[0]->vigencia, $info_comision[0]->codigo_unidad_ejecutora);
							
		
		$NOMBRE = $listado_com[0]->NOMBRE;
		$OBJETO = $listado_com[0]->OBJETO;
		$FECHA_INICIAL = $listado_com[0]->FECHA_INICIAL;
		$FECHA_FINAL = $listado_com[0]->FECHA_FINAL;
		$LUGAR_COMISION = $listado_com[0]->LUGAR_COMISION;
		?>
		<html>
			<head>
				<meta charset="UTF-8">
				<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/informe_word.css')?>"> 
			</head>
			<body>
			<center><img src="<?php echo base_url("public/images/logo-portal-1_0.png");?>"></center>
			<center><h1>Informe de comisi&oacute;n</h1></center>
			
			<table style="width:100%;" border="1">
				<tr>
					<td><b>Nombre:</b></td>
					<td><?php echo stripcslashes(nl2br($NOMBRE))?></td>
				</tr>
				<tr>
					<td><b>Objeto:</b></td>
					<td><?php echo stripcslashes(nl2br($OBJETO))?></td>
				</tr>
				<tr>
					<td><b>Fecha Inicial:</b></td>
					<td><?php echo stripcslashes(nl2br($FECHA_INICIAL))?></td>
				</tr>
				<tr>
					<td><b>Fecha Final:</b></td>
					<td><?php echo stripcslashes(nl2br($FECHA_FINAL))?></td>
				</tr>
				<tr>
					<td><b>Lugar Comisi&oacute;n:</b></td>
					<td><?php echo stripcslashes(nl2br($LUGAR_COMISION))?></td>
				</tr>
				<tr>
					<td><b>Tipo Comisi&oacute;n:</b></td>
					<td><?php echo stripcslashes(nl2br($info_comision[0]->desc_tema))?></td>
				</tr>
				<tr>
					<td><b>Resumen:</b></td>
					<td><?php echo stripcslashes(nl2br($info_comision[0]->resumen_comision))?></td>
				</tr>
				<?php
			
				if($info_comision[0]->participantes != ''){
					?>
					<tr>
						<td><b>Participantes:</b></td>
						<td><?php echo stripcslashes(nl2br($info_comision[0]->participantes))?></td>
					</tr>					
					<?php
				}
				?>
				<tr>
					<td><b>Aplicaci&oacute;n:</b></td>
					<td><?php echo stripcslashes(nl2br($info_comision[0]->aplicaciones_entidad))?></td>
				</tr>
				<tr>
					<td><b>Recomendaciones:</b></td>
					<td><?php echo stripcslashes(nl2br($info_comision[0]->recomendaciones))?></td>
				</tr>
			</table>
			
			<center><h2>Datos de contacto</h2></center>
			<table style="width:100%;" border="1">
				<tr>
					<th><b>Nombre</b></th>
					<th><b>Apellido</b></th>
					<th><b>Cargo</b></th>
					<th><b>Email</b></th>
					<th><b>Telefono</b></th>
				</tr>
				<?php
			
				if(count($info_contacto)>0){
					for($i=0;$i<count($info_contacto);$i++){
						?>
						<tr>
							<td><?php echo ($info_contacto[$i]->nombre)?></td>
							<td><?php echo ($info_contacto[$i]->apellido)?></td>
							<td><?php echo ($info_contacto[$i]->cargo)?></td>
							<td><?php echo ($info_contacto[$i]->mail)?></td>
							<td><?php echo ($info_contacto[$i]->telefono)?></td>
						</tr>					
						<?php
					}
				}
				?>				
			</table>
			
			<center><h2>Actividades desarrolladas</h2></center>
			<table style="width:100%;" border="1">
				
				<?php
			
				if(count($info_aspectos_apr)>0){
					?>
					<tr>
						<th><b>Criterios</b></th>						
						<th><b>Fortalezas y aspectos positivos</b></th>
						<th><b>Oportunidades de mejora</b></th>
						<th><b>Aplicaciones para la entidad</b></th>
					</tr>
					<?php
					for($j=0;$j<count($info_aspectos_apr);$j++){
						?>
						<tr>
							<td><?php echo stripcslashes(nl2br($info_aspectos_apr[$j]->criterio))?></td> 								
							<td><?php echo stripcslashes(nl2br($info_aspectos_apr[$j]->fortalezas_ap))?></td>
							<td><?php echo stripcslashes(nl2br($info_aspectos_apr[$j]->oportunidades_ap))?></td>
							<td><?php echo stripcslashes(nl2br($info_aspectos_apr[$j]->aplicaciones_ap))?></td>
						</tr>					
						<?php
					}
				}
				
				if(count($info_aspectos_otr)>0){
					?>
					<tr>
						<th><b>Actividades desarrolladas</b></th>
						<th><b>Fortalezas y aspectos positivos</b></th>
						<th><b>Oportunidades de mejora</b></th>
					</tr>
					<?php
					for($k=0;$k<count($info_aspectos_otr);$k++){
						?>
						<tr>
							<td><?php echo stripcslashes(nl2br($info_aspectos_otr[$k]->actividades_desarrolladas_ot))?></td>
							<td><?php echo stripcslashes(nl2br($info_aspectos_otr[$k]->fortalezas_asp_positivos_ot))?></td>
							<td><?php echo stripcslashes(nl2br($info_aspectos_otr[$k]->oportunidades_mejora_ot))?></td>
						</tr>					
						<?php
					}
				}
				?>				
			</table>
			
			</body>
		</html>
		<?php 
	}

}
