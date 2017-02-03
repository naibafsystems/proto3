<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Model {

    public function __construct() {
        parent::__construct();
        //$this->load->database(); se esta caergando desde el aotiloader de config
    }

    public function esAdministrador($userName) {
        $sql = "SELECT * FROM com_administradores WHERE estado = 1 and usuario = '" . $userName . "'";
        $query = $this->db->query($sql);
        $resultado = $query->result();
        $this->db->close();
        return $resultado;
    }

    public function identificacion($userName) {
        $sql = "SELECT  numero_documento FROM com_administradores WHERE estado=1 and usuario = '" . $userName . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $documento = TRUE;
        }
        $this->db->close();
        return $documento;
    }

    /*public function add_admin($login, $ident) {
        $sql = "INSERT INTO com_administradores(id, usuario, tipo, numero_documento, estado, mail_usuario) VALUES ('','$login','2',$ident,'1','" . $login . "@dane.gov.co')";
        $query = $this->db->query($sql);
        return $this->db->insert_id();
    }*/
    
    public function add_admin($login) {
        $sql = "INSERT INTO com_administradores(usuario, tipo, estado, mail_usuario, terminos) VALUES ('$login','2','1','" . $login . "@dane.gov.co', 0)";
        $query = $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function documento($usuario) {
        $sql = "SELECT * FROM com_administradores WHERE usuario = '" . $usuario . "' ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_user_crm($UserName) {
        $Dane = $this->load->database('dane_crm', true);
        $query = $Dane->query("SELECT ID_USUARIO,NUM_IDENT,NOM_USUARIO,APE_USUARIO,TEL_USUARIO,EXT_USUARIO,MAIL_USUARIO,DEP_USUARIO,TERR_USUARIO,LOG_USUARIO,SEXO,IMAGEN FROM GESTIONH.GH_ADMIN_USUARIOS where LOG_USUARIO = '".$UserName."'");
        return $query->result();
    }
}
