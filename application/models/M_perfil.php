<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_perfil extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_todos_crm() {
        $Dane = $this->load->database('dane_crm', true);
        $query = $Dane->query('SELECT * FROM GESTIONH.GH_ADMIN_USUARIOS');
        return $query->result();
    }
    
    public function get_document_crm($Documento) {
        $Dane = $this->load->database('dane_crm', true);
        $query = $Dane->query('SELECT ID_USUARIO,NOM_USUARIO,APE_USUARIO,TEL_USUARIO,EXT_USUARIO,MAIL_USUARIO,DEP_USUARIO,TERR_USUARIO,LOG_USUARIO,SEXO,IMAGEN FROM GESTIONH.GH_ADMIN_USUARIOS where NUM_IDENT = '.$Documento);
        return $query->result();
    }
    
    public function get_adicionales_crm($Llave) {
        $Dane = $this->load->database('dane_crm', true);
        $query = $Dane->query('SELECT CODIGO_DEPENDENCIA,DESCRIPCION,ANTECESOR,FK_ID_USUARIO,CARGO,ESTADO FROM GESTIONH.GH_PARAM_DEPENDENCIA where CODIGO_DEPENDENCIA = '.$Llave);
        return $query->result();
    }
    
    public function get_idiomas_crm($Documento) {
        $Dane = $this->load->database('dane_crm', true);
        $query = $Dane->query('SELECT * FROM USER_IDIOMA LEFT JOIN GH_PARAM_IDIOMAS on FK_ID_IDIOMA = ID_IDIOMA where FK_ID_USUARIO = '.$Documento);
        return $query->result();
    }
    
    public function get_estudios_crm($Documento) {
        $Dane = $this->load->database('dane_crm', true);
        $query = $Dane->query('SELECT * FROM USER_INFO_ACADEMICA LEFT JOIN GH_PARAM_NIVEL_ESTUDIO ON FK_ID_ESTUDIO = ID_ESTUDIO where FK_ID_USUARIO = '.$Documento.' order by ANNO asc' );
        return $query->result();
    }
    
    public function get_interes($Correo) {
        $sql = "SELECT * FROM com_conocimiento as c left join com_subcategoria as s 
                  on c.id_subcategoria = s.id_subcategoria WHERE com_administradores_id = '".$Correo."' and tipo = 2";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_categorias() {
        $sql = " SELECT * FROM com_categoria ";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_subcategorias($IdCategoria) {
        $sql = " SELECT * FROM com_subcategoria where id_categoria = ".$IdCategoria;
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function add_subcategorias($DatosInsertar) {
        $this->db->insert('com_conocimiento', $DatosInsertar);
        $id_datos = $this->db->insert_id();
        return $this->db->insert_id();
    }
    
    public function add_datos_ad($DatosInsertar){
        $this->db->insert('com_datos_adicionales', $DatosInsertar);
        $id_datos = $this->db->insert_id();
        return $this->db->insert_id();
    }

    public function add_idioma($DatosInsertar) {
        $this->db->insert('com_idiomas', $DatosInsertar);
        $id_datos = $this->db->insert_id();
        return $this->db->insert_id();
    }
    
    public function add_software($DatosInsertar) {
        $this->db->insert('com_software', $DatosInsertar);
        $id_datos = $this->db->insert_id();
        return $this->db->insert_id();
    }
    
    public function get_software($Correo) {
        $sql = " SELECT * FROM com_software where com_administradores_id = '".$Correo."'";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_adicional($IdUser) {
        $sql = " SELECT * FROM com_datos_adicionales where id_administrador = '".$IdUser."'";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_categorias_cono($Correo) {
        $sql = "SELECT * FROM com_conocimiento as c left join com_subcategoria as s 
                  on c.id_subcategoria = s.id_subcategoria WHERE com_administradores_id = '".$Correo."' and tipo = 1";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_dependencia() {
        $Dane = $this->load->database('dane_crm', true);
        $query = $Dane->query('SELECT * FROM GESTIONH.GH_PARAM_DEPENDENCIA');
        return $query->result();
    }
    
    public function get_param() {
        $Dane = $this->load->database('dane_crm', true);
        $query = $Dane->query('SELECT * FROM GESTIONH.GH_PARAM_DIVIPOLA');
        return $query->result();
    }
    
    public function update_terminos($id) {
        $sql = "UPDATE com_administradores SET 
                terminos = 1
                WHERE id = " . $id;
        $this->db->query($sql);
    }
}
