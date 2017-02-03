<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_estado extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

     public function get_estado_all($Id) {
        $sql = " SELECT * FROM com_datos_general_com_estados_comision ES LEFT JOIN com_estados_comision as CO on CO.id_estado = ES.id_estado ";
        $sql.= " WHERE ES.id_datos = " . $Id;
        $sql.= " order by fecha_actualizacion DESC LIMIT 1 ";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_estado_all_2() {
        $query = $this->db->get('com_estados_comision');
        return $query->result();
    }

    public function add_estado($DatosIsertar) {
        $this->db->insert('com_datos_general_com_estados_comision', $DatosIsertar);
        return $this->db->insert_id();
    }

    public function get_estado_by_id($id) {
        $query = $this->db->where('id_estado', $id);
        $query = $this->db->get('com_estados_comision');
        return $query->result();
    }
    
    public function get_estado_by_iddatos($id) {
        $query = $this->db->where('id_datos', $id);
        $query = $this->db->get('com_datos_general_com_estados_comision');
        return $query->result();
    }
}
