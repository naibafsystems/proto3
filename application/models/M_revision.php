<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_revision extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_dependencia_jefe($identificacion) {
        $Dane = $this->load->database('dane_crm', true);
		$cadena_sql = 'SELECT DEP_USUARIO, CODIGO_DEPENDENCIA, DESCRIPCION, ANTECESOR  
								FROM GH_ADMIN_USUARIOS GU
								JOIN GH_PARAM_DEPENDENCIA GD ON GU.ID_USUARIO = GD.FK_ID_USUARIO 
								WHERE GU.NUM_IDENT = '.$identificacion;
								
        $query = $Dane->query($cadena_sql);
        return $query->result();
    }
	
	public function consultaUsuarioComision($identificacion) {   
        $Dane = $this->load->database('dane_crm', true);
		$cadena_sql = 'SELECT * FROM GH_ADMIN_USUARIOS GU
								WHERE NUM_IDENT = '.$identificacion.' ORDER BY NOM_USUARIO ';
        $query = $Dane->query($cadena_sql);
        return $query->result();
    }
	
	public function usuarios_dependencia_antecesor_todos($dependencia, $identificacion) {   
        $Dane = $this->load->database('dane_crm', true);
		$cadena_sql = 'SELECT * FROM GH_ADMIN_USUARIOS GU
								JOIN GH_PARAM_DEPENDENCIA GD ON GU.DEP_USUARIO = GD.CODIGO_DEPENDENCIA AND NUM_IDENT != '.$identificacion.' AND GU.TIPOV_USUARIO IN(1,2)
								WHERE ANTECESOR = '.$dependencia.' OR CODIGO_DEPENDENCIA = '.$dependencia.' ORDER BY NOM_USUARIO ';
        $query = $Dane->query($cadena_sql);
        return $query->result();
    }
	
	public function usuarios_dependencia_todos($dependencia, $identificacion) {
        $Dane = $this->load->database('dane_crm', true);
		$cadena_sql = 'SELECT * FROM GH_ADMIN_USUARIOS GU
								JOIN GH_PARAM_DEPENDENCIA GD ON GU.DEP_USUARIO = GD.CODIGO_DEPENDENCIA AND GU.TIPOV_USUARIO IN(1,2)
								WHERE CODIGO_DEPENDENCIA = '.$dependencia.' ORDER BY NOM_USUARIO ';
        $query = $Dane->query($cadena_sql);
        return $query->result();
    }
	
	public function usuarios_dependencia_antecesor_funcionarios($dependencia, $identificacion) {   
        $Dane = $this->load->database('dane_crm', true);
		$cadena_sql = 'SELECT * FROM GH_ADMIN_USUARIOS GU
								JOIN GH_PARAM_DEPENDENCIA GD ON GU.DEP_USUARIO = GD.CODIGO_DEPENDENCIA AND NUM_IDENT != '.$identificacion.' AND GU.TIPOV_USUARIO = 1
								WHERE ANTECESOR = '.$dependencia.' OR CODIGO_DEPENDENCIA = '.$dependencia.' ORDER BY NOM_USUARIO ';
        $query = $Dane->query($cadena_sql);
        return $query->result();
    }
	
	public function usuarios_dependencia_funcionarios($dependencia, $identificacion) {
        $Dane = $this->load->database('dane_crm', true);
		$cadena_sql = 'SELECT * FROM GH_ADMIN_USUARIOS GU
								JOIN GH_PARAM_DEPENDENCIA GD ON GU.DEP_USUARIO = GD.CODIGO_DEPENDENCIA AND GU.TIPOV_USUARIO = 1
								WHERE CODIGO_DEPENDENCIA = '.$dependencia.' ORDER BY NOM_USUARIO ';
        $query = $Dane->query($cadena_sql);
        return $query->result();
    }
	
	
	public function usuarios_dependencia_antecesor_contratistas($dependencia, $identificacion) {   
        $Dane = $this->load->database('dane_crm', true);
		$cadena_sql = 'SELECT * FROM GH_ADMIN_USUARIOS GU
								JOIN GH_PARAM_DEPENDENCIA GD ON GU.DEP_USUARIO = GD.CODIGO_DEPENDENCIA AND NUM_IDENT != '.$identificacion.' AND GU.TIPOV_USUARIO = 2
								WHERE ANTECESOR = '.$dependencia.' OR CODIGO_DEPENDENCIA = '.$dependencia.' ORDER BY NOM_USUARIO ';
        $query = $Dane->query($cadena_sql);
        return $query->result();
    }
	
	public function usuarios_dependencia_contratistas($dependencia, $identificacion) {
        $Dane = $this->load->database('dane_crm', true);
		$cadena_sql = 'SELECT * FROM GH_ADMIN_USUARIOS GU
								JOIN GH_PARAM_DEPENDENCIA GD ON GU.DEP_USUARIO = GD.CODIGO_DEPENDENCIA AND GU.TIPOV_USUARIO = 2
								WHERE CODIGO_DEPENDENCIA = '.$dependencia.' ORDER BY NOM_USUARIO ';
        $query = $Dane->query($cadena_sql);
        return $query->result();
    }
	
	public function estado_comision($id_datos) {
        $sql = " SELECT * FROM com_datos_general_com_estados_comision ";
        $sql.= " WHERE id_datos = " . $id_datos;
		$sql.= " ORDER BY fecha_actualizacion DESC ";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function archivos_comision($id_datos) {
        $sql = " SELECT tipo_archivo, archivo_ruta, archivo FROM com_archivos ";
        $sql.= " WHERE id_arc_datos = " . $id_datos;
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function archivos_comision_rutas($id_datos) {
        $sql = " SELECT tipo_ruta, archivo_ruta, archivo FROM com_archivos_rutas ";
        $sql.= " WHERE id_datos_ruta = " . $id_datos;
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function estados() {
        $sql = " SELECT * FROM com_estados_comision WHERE id_estado != 1";
        $query = $this->db->query($sql);
        return $query->result();
    }
	public function estados_revision() {
        $sql = " SELECT * FROM com_estados_comision WHERE id_estado IN(2,3)";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function guardarEstado($param) {
		$this -> db -> trans_start();
		$this -> db -> insert('com_datos_general_com_estados_comision', $param);
		//$insert_id = $this -> db -> insert_id();
		return $this -> db -> trans_complete();
		//return $insert_id;
	}
	
	public function get_usuarios_gh($usuario) {
        $sql = " SELECT * FROM com_usuarios_gh WHERE nom_usuario = '".$usuario."' AND estado ='AC'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function consultaCoorGH() {
        $sql = " SELECT * FROM com_usuarios_gh WHERE perfil = 'Coordinador' AND estado ='AC'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function consultaFuncionariosGH() {
        $sql = " SELECT * FROM com_usuarios_gh WHERE perfil = 'funcionario' AND estado ='AC'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function consultaCoorCC() {
        $sql = " SELECT * FROM com_usuarios_cc WHERE perfil = 'Coordinador' AND estado ='AC'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function consultaFuncionariosCC() {
        $sql = " SELECT * FROM com_usuarios_cc WHERE perfil = 'funcionario' AND estado ='AC'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function consultaCoorCO() {
        $sql = " SELECT * FROM com_usuarios_co WHERE perfil = 'Coordinador' AND estado ='AC'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function consultaFuncionariosCO() {
        $sql = " SELECT * FROM com_usuarios_co WHERE perfil = 'funcionario' AND estado ='AC'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	 
	public function consultaCoorTE() {
        $sql = " SELECT * FROM com_usuarios_te WHERE perfil = 'Coordinador' AND estado ='AC'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function consultaFuncionariosTE() {
        $sql = " SELECT * FROM com_usuarios_te WHERE perfil = 'funcionario' AND estado ='AC'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function consultaUsuarioAsignado($id_datos) {
        $sql = " SELECT asignado FROM com_legalizacion WHERE id_datos = ".$id_datos." AND estado ='AC'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function consultaTipoComision($id_datos) {
        $sql = " SELECT tipo_cuenta FROM com_legalizacion WHERE id_datos = ".$id_datos." AND estado ='AC'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function get_usuarios_cc($usuario) {
        $sql = " SELECT * FROM com_usuarios_cc WHERE nom_usuario = '".$usuario."' AND estado ='AC'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function get_usuarios_co($usuario) {
        $sql = " SELECT * FROM com_usuarios_co WHERE nom_usuario = '".$usuario."' AND estado ='AC'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function get_usuarios_te($usuario) {
        $sql = " SELECT * FROM com_usuarios_te WHERE nom_usuario = '".$usuario."' AND estado ='AC'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function comisiones_p_legalizar() {
        $sql = " SELECT * FROM com_datos_general WHERE estado_actual = 2 ";  
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function datos_comisiones($id_datos) {
        $sql = " SELECT *, tem.desc_tema FROM com_datos_general dg
				JOIN com_tipo_tema tem ON dg.id_tema = tem.id_tema
				WHERE id_datos = ".$id_datos."
				 ";  
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function datos_contacto($id_datos) {  
        $sql = " SELECT * FROM  com_datos_contacto 
				WHERE id_datos_con = ".$id_datos."
				 ";  
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function datos_aspectos_apr($id_datos) {  
        $sql = " SELECT * FROM  com_aspectos_aprendizaje asp 
				JOIN  com_criterios cri ON cri.id_criterio = asp.id_criterio_ap
				WHERE id_datos_aprendizaje = ".$id_datos."
				 ";  
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function datos_aspectos_otro($id_datos) {    
        $sql = " SELECT * FROM  com_aspectos_otros 
				WHERE id_datos_otros = ".$id_datos."
				 ";  
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function comisiones_cuenta($usuario) {
        $sql = " SELECT * FROM com_datos_general cd
		JOIN com_legalizacion cl ON cl.id_datos = cd.id_datos AND cl.estado = 'AC' 
		WHERE estado_actual = 5 and tipo_cuenta = 'CU' AND cl.asignado = '".$usuario."' ";  
        $query = $this->db->query($sql);
        return $query->result();
    }
		
	public function comisiones_avance($usuario) {
        $sql = " SELECT * FROM com_datos_general cd
		JOIN com_legalizacion cl ON cl.id_datos = cd.id_datos AND cl.estado = 'AC' 
		WHERE estado_actual = 5 and tipo_cuenta = 'AV' AND cl.asignado = '".$usuario."' ";  
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function comisiones_todas($usuario) {
        $sql = " SELECT * FROM com_datos_general cd
		JOIN com_legalizacion cl ON cl.id_datos = cd.id_datos  AND cl.estado = 'AC' 
		WHERE estado_actual = 5  AND cl.asignado = '".$usuario."' ";  
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function comisiones_legalizadas() {
        $sql = " SELECT * FROM com_datos_general cd
		JOIN com_legalizacion cl ON cl.id_datos = cd.id_datos
		WHERE estado_actual = 4 AND cl.estado = 'AC' OR asignado = 'mfcuenca' ";  
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function grupo_cc() {
        $sql = " SELECT * FROM com_usuarios_cc WHERE estado ='AC' AND nom_usuario NOT IN('".$this->session->userdata('usuario')."')";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function grupo_co() {
        $sql = " SELECT * FROM com_usuarios_co WHERE estado ='AC' AND nom_usuario NOT IN('".$this->session->userdata('usuario')."')";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function grupo_gh() {
        $sql = " SELECT * FROM com_usuarios_gh WHERE estado ='AC' AND nom_usuario NOT IN('".$this->session->userdata('usuario')."')";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function grupo_te() {
        $sql = " SELECT * FROM com_usuarios_te WHERE estado ='AC' AND nom_usuario NOT IN('".$this->session->userdata('usuario')."')";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function grupo_cc_coor() {
        $sql = " SELECT * FROM com_usuarios_cc WHERE estado ='AC' AND nom_usuario NOT IN('".$this->session->userdata('usuario')."') AND perfil = 'Coordinador'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function grupo_co_coor() {
        $sql = " SELECT * FROM com_usuarios_co WHERE estado ='AC' AND nom_usuario NOT IN('".$this->session->userdata('usuario')."') AND perfil = 'Coordinador'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function grupo_gh_coor() {
        $sql = " SELECT * FROM com_usuarios_gh WHERE estado ='AC' AND nom_usuario NOT IN('".$this->session->userdata('usuario')."') AND perfil = 'Coordinador'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function grupo_te_coor() {
        $sql = " SELECT * FROM com_usuarios_te WHERE estado ='AC' AND nom_usuario NOT IN('".$this->session->userdata('usuario')."') AND perfil = 'Coordinador'";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function estados_comision($id_datos) {
        $sql = " SELECT * FROM com_datos_general_com_estados_comision WHERE id_datos = ".$id_datos." ORDER BY fecha_actualizacion DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function guardarEstadoActual($data) {
        $sql = "UPDATE com_datos_general SET 
                estado_actual='" . $data['estado_actual'] . "'
                WHERE id_datos = " . $data['id_datos'];
        $this->db->query($sql);
		return true;
    }
	
	public function guardarAsignacion($data) {
        $sql = "UPDATE com_legalizacion SET 
                asignado='" . $data['asignado'] . "'
                WHERE id_datos = " . $data['id_datos'];
        $this->db->query($sql);
		return true;
    }
	
	public function actualizarEstadoAprobacion($data) {
        $sql = "UPDATE com_legalizacion SET 
                estado='" . $data['estado'] . "'
                WHERE id_datos = " . $data['id_datos'];
        $this->db->query($sql);
		return true;
    }
	
	public function guardarLegalizacion($param) {
		$this -> db -> trans_start();
		$this -> db -> insert('com_legalizacion', $param);
		//$insert_id = $this -> db -> insert_id();
		return $this -> db -> trans_complete();
		//return $insert_id;
	}
	
	public function get_todos_crm() {
        $Dane = $this->load->database('dane_crm', true);
        $query = $Dane->query('SELECT * FROM GESTIONH.GH_ADMIN_USUARIOS ');
        //$query = $Dane->query("SELECT gen.INTERNO_GEN,gen.INTERNO_ENC,gen.VIGENCIA,gen.CODIGO_UNIDAD_EJECUTORA,gen.LUGAR_COMISION,gen.NOMBRE,gen.FECHA_INICIAL,gen.FECHA_FINAL,gen.OBJETO FROM com_general gen WHERE gen.FECHA_INICIAL >= '01/06/2016' ");
        return $query->result();
    }
	
	public function datos_usuario_crm($usuario) {
        $Dane = $this->load->database('dane_crm', true);
        $query = $Dane->query("SELECT * FROM GESTIONH.GH_ADMIN_USUARIOS WHERE LOG_USUARIO = '".$usuario."'");
        return $query->result();
    }
	
	public function datosUsuarioCedula($usuario) {
        $Dane = $this->load->database('dane_crm', true);
        $query = $Dane->query("SELECT NOM_USUARIO, APE_USUARIO, MAIL_USUARIO, DEP_USUARIO, GD.DESCRIPCION
								FROM GESTIONH.GH_ADMIN_USUARIOS GU
								JOIN GESTIONH.GH_PARAM_DEPENDENCIA GD ON GD.CODIGO_DEPENDENCIA = GU.DEP_USUARIO
								WHERE NUM_IDENT = ".$usuario); 
        return $query->result();
    }	
	
	
	public function territoriales() {
        $sql = " SELECT id_territorial, desc_territorial FROM com_territoriales ";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function tipo_contrato() {
        $sql = " SELECT id_tipocont, desc_tipocont FROM com_tipo_contrato ";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function datosCiudad($id_territorial) {
        $sql = " SELECT id_ciudad, desc_ciudad FROM com_ciudad_territorial WHERE id_territorial = ".$id_territorial." ";  
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function guardarInscripcion($param) {
		$this -> db -> trans_start();
		$this -> db -> insert('com_inscripcion', $param);
		//$insert_id = $this -> db -> insert_id();
		return $this -> db -> trans_complete();
		//return $insert_id;
	}
	
	public function inscripcion($id) {
        $sql = " SELECT * FROM com_inscripcion WHERE identificacion = ".$id." ";  
        $query = $this->db->query($sql);
        return $query->result();
    }
	
	public function total_inscritos() {
		$sql = " SELECT  identificacion,	nombres, apellidos, email, grupo, ins.id_territorial, ter.desc_territorial, ins.id_ciudad, ciu.desc_ciudad, ins.id_tipo_vinc, tc.desc_tipocont, otra_vinc, fecha_vinc, fecha_fin 
				FROM com_inscripcion ins
				JOIN com_territoriales ter ON ter.id_territorial = ins.id_territorial 
				JOIN com_tipo_contrato tc ON tc.id_tipocont = ins.id_tipo_vinc 
				JOIN com_ciudad_territorial ciu ON ciu.id_ciudad = ins.id_ciudad ";  
        $query = $this->db->query($sql);
        return $query->result();
    }
}
