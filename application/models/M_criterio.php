<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_criterio extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_todos() {
        $query = $this->db->get('com_criterios');
        return $query->result();
    }
}
