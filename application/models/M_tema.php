<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tema extends CI_Model {

        public function __construct(){
            parent::__construct();
            //$this->load->database(); se esta caergando desde el aotiloader de config
        }
        
        public function get_todos(){
            $query = $this->db->get('com_temas');
            return $query->result();
        }
        
        public function add(){
            $DatosInsertar = $this->input->post();
            unset($DatosInsertar['btn_enviar']); 
            $this->db->insert('com_temas',$DatosInsertar);
            
            return $this->db->insert_id();
        }
        
        public function edit($id){
            $DatosEditar = $this->input->post();
            unset($DatosEditar['btn_enviar']);
            $query = $this->db->where('id_tema',$id);
            $this->db->update('com_temas',$DatosEditar);
		}
        
        public function get_by_id($id){
			$query = $this->db->where('id_tema',$id);
            $query = $this->db->get('com_temas');
			return $query->result();
		}
        
        public function delete($id){
			$query = $this->db->where('id_tema',$id);
            $query = $this->db->delete('com_temas');
		}
}
