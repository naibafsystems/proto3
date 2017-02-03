<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_services extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_todos_crm() {
        $Dane = $this->load->database('dane_crm', true);
        $query = $Dane->query('SELECT * FROM GESTIONH.GH_ADMIN_USUARIOS');
        return $query->result();
    }
    
    public function get_user_crm($ident) {
        $Dane = $this->load->database('dane_crm', true);
        $query = $Dane->query('SELECT * FROM GESTIONH.GH_ADMIN_USUARIOS WHERE NUM_IDENT = '.$ident);
        return $query->result();
    }
}
