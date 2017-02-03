<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_comision extends CI_Model {

        public function __construct(){
            parent::__construct();
        }
        
        public function get_todos(){
			$query = $this->db->get('com_general');
			return $query->result();
		}
        
        public function add(){
            $DatosInsertar = $this->input->post();
            unset($DatosInsertar['btn_enviar']); 
            $this->db->insert('com_general',$DatosInsertar);
            
            return $this->db->insert_id();
        }
        
        public function edit($id){
            $DatosEditar = $this->input->post();
            unset($DatosEditar['btn_enviar']);
            $query = $this->db->where('id',$id);
            $this->db->update('com_general',$DatosEditar);
		}
        
        public function get_by_id($id){
			$query = $this->db->where('id',$id);
            $query = $this->db->get('com_general');
			return $query->result();
		}
        
        public function delete($id){
			$query = $this->db->where('id',$id);
            $query = $this->db->delete('com_general');
		}
}
