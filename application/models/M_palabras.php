<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_palabras extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_aprendizaje() {
        $sql = " SELECT * ";
        $sql.= " FROM com_datos_general ";
        $sql.= " LEFT JOIN com_aspectos_aprendizaje ON id_datos = id_datos_aprendizaje ";
        $sql.= " LEFT JOIN com_administradores ON com_administradores_id = id ";
        $sql.= " LEFT JOIN com_criterios ON id_criterio_ap = id_criterio ";
        $sql.= " WHERE ejecutada = 0 ";
        $sql.= " and id_tema = 4 ";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_all_aprendizaje_palabra($palabra,$aspecto) {
        $sql = " SELECT * ";
        $sql.= " FROM com_datos_general ";
        $sql.= " LEFT JOIN com_aspectos_aprendizaje ON id_datos = id_datos_aprendizaje ";
        $sql.= " LEFT JOIN com_administradores ON com_administradores_id = id ";
        $sql.= " LEFT JOIN com_criterios ON id_criterio_ap = id_criterio ";
        $sql.= " WHERE ejecutada = 0 ";
        $sql.= " and id_tema = 4 ";
        if($aspecto == "p"){
            $sql.= " and (fortalezas_ap LIKE '%".$palabra."%' )";
        }elseif($aspecto == "n"){
            $sql.= " and (aplicaciones_ap LIKE '%".$palabra."%' ) ";
        }else{
            $sql.= " and (oportunidades_ap LIKE '%".$palabra."%' ) ";
        }
        
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_all_nacional() {
        $sql = " SELECT * ";
        $sql.= " FROM com_datos_general ";
        $sql.= " LEFT JOIN com_aspectos_otros ON id_datos = id_datos_otros ";
        $sql.= " LEFT JOIN com_administradores ON com_administradores_id = id ";
        $sql.= " WHERE ejecutada = 0 ";
        $sql.= " and id_tema <> 4 ";
        $sql.= " and tipo_comi = 1 ";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_all_nacional_palabra($palabra,$aspecto) {
        $sql = " SELECT * ";
        $sql.= " FROM com_datos_general ";
        $sql.= " LEFT JOIN com_aspectos ON id_datos = id_asp_datos ";
        $sql.= " WHERE ejecutada = 0 ";
        $sql.= " and id_tema <> 4 ";
        $sql.= " and tipo_comi = 1 ";
        
        if($aspecto == "p"){
            $sql.= " and (fortalezas_asp_positivos_ot LIKE '%".$palabra."%') ";
        }elseif($aspecto == "n"){
            $sql.= " and (oportunidades_mejora_ot LIKE '%".$palabra."%') ";
        }else{
            $sql.= " and (fortalezas_asp_positivos_ot LIKE '%".$palabra."%') ";
        }
        
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_all_internacional() {
        $sql = " SELECT * ";
        $sql.= " FROM com_datos_general ";
        $sql.= " LEFT JOIN com_aspectos_otros ON id_datos = id_datos_otros ";
        $sql.= " LEFT JOIN com_administradores ON com_administradores_id = id ";
        $sql.= " WHERE ejecutada = 0 ";
        $sql.= " and id_tema = 4 ";
        $sql.= " and tipo_comi = 3 ";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_all_internacional_palabra($palabra,$aspecto) {
        $sql = " SELECT * ";
        $sql.= " FROM com_datos_general ";
        $sql.= " LEFT JOIN com_aspectos ON id_datos = id_asp_datos ";
        $sql.= " WHERE ejecutada = 0 ";
        $sql.= " and id_tema = 4 ";
        $sql.= " and tipo_comi = 3 ";
        
        if($aspecto == "p"){
            $sql.= " and (fortalezas_asp_positivos_ot LIKE '%".$palabra."%') ";
        }elseif($aspecto == "n"){
            $sql.= " and (oportunidades_mejora_ot LIKE '%".$palabra."%') ";
        }else{
            $sql.= " and (fortalezas_asp_positivos_ot LIKE '%".$palabra."%') ";
        }
        
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_all_analisis() {
        $sql = " SELECT * ";
        $sql.= " FROM com_analisis ";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_analisis_user() {
        $sql = " SELECT id_analisis, id_tipo_tema, id_criterio, aspecto, mail_destino, descripcion, actividades, fecha_actividad, estado";
        $sql.= " FROM com_analisis ";
        //$sql.= " LEFT JOIN com_aspectos ON id_datos = id_asp_datos ";
        $sql.= " WHERE mail_destino = '".$this->session->userdata('mail')."'  ";
        //$sql.= " and id_tema = 4 ";
        //$sql.= " and tipo_comi = 3 ";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function add_analisis($DatosInsertar) {
        $this->db->insert('com_analisis', $DatosInsertar);
        return $this->db->insert_id();
    }
    
    public function edit_datos_analisis($id,$DatosEditar) {
        $sql = "UPDATE com_analisis SET 
                actividades='".$DatosEditar['actividades']."',
                fecha_actividad='".$DatosEditar['fecha_actividad']."',
                estado=".$DatosEditar['estado']."
                WHERE id_analisis = " . $id;
        $this->db->query($sql);
    }
}
