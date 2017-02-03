<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_aspectos extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function add_aspectos_otros($DatosInsertar) {
        $this->db->insert('com_aspectos_otros', $DatosInsertar);
        return $this->db->insert_id();
    }
    
    public function add_aspectos_aprendizaje($DatosInsertar) {
        $this->db->insert('com_aspectos_aprendizaje', $DatosInsertar);
        return $this->db->insert_id();
    }
    
    public function edit_aspectos_otros($id, $DatosEditar) {
        $sql = "UPDATE com_aspectos_otros SET 
                actividades_desarrolladas_ot='" . $DatosEditar['actividades_desarrolladas_ot'] . "',
                fortalezas_asp_positivos_ot='" . $DatosEditar['fortalezas_asp_positivos_ot'] . "',
                oportunidades_mejora_ot='" . $DatosEditar['oportunidades_mejora_ot'] . "' 
                WHERE id_aspecto_ot = " . $id;
        
        //echo $sql;
        $this->db->query($sql);
    }
    
    public function edit_aspectos_aprendizaje($id, $DatosEditar) {
        $sql = "UPDATE com_aspectos_aprendizaje SET 
                fortalezas_ap='" . $DatosEditar['fortalezas_ap'] . "',
                oportunidades_ap='" . $DatosEditar['oportunidades_ap'] . "',
                aplicaciones_ap='" . $DatosEditar['aplicaciones_ap'] . "' 
                WHERE id_aspecto_ap = " . $id;
        $this->db->query($sql);
    }
}
