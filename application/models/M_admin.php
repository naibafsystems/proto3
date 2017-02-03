<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_no_ejecutadas() {
        $sql = " SELECT * FROM com_datos_general ";
        $sql.= " LEFT JOIN com_administradores ON com_administradores_id = id ";
        $sql.= " WHERE ejecutada = 1 ";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function update_no_ejecutadas($Id) {
        $sql = " DELETE FROM com_datos_general ";
        $sql.= " WHERE id_datos = ".$Id;
        $query = $this->db->query($sql);
        return true;
    }
    
    public function users() {
        $sql = " SELECT * FROM com_administradores ORDER BY id desc";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
