<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_cron extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_users() {
        $sql = " SELECT id,usuario,estado,mail_usuario FROM com_administradores ";
        $sql.= " WHERE estado = 1 ";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
