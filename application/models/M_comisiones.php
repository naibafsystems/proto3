<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_comisiones extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_todos() {
        $Dane = $this->load->database('dane_ora', true);
        //$query = $Dane->query("SELECT gen.INTERNO_GEN,gen.INTERNO_ENC,gen.VIGENCIA,gen.CODIGO_UNIDAD_EJECUTORA,gen.LUGAR_COMISION,gen.NOMBRE,gen.FECHA_INICIAL,gen.FECHA_FINAL,gen.OBJETO FROM com_general gen WHERE gen.FECHA_INICIAL >= '01/06/2016' ");
        $query = $Dane->query("SELECT gen.INTERNO_GEN,gen.INTERNO_ENC,gen.VIGENCIA,gen.CODIGO_UNIDAD_EJECUTORA,gen.LUGAR_COMISION,gen.NOMBRE,to_char(gen.FECHA_INICIAL,'YYYY-MM-DD') as FECHA_INICIAL,to_char(gen.FECHA_FINAL,'YYYY-MM-DD') as FECHA_FINAL,gen.OBJETO
                 FROM com_general gen 
                 WHERE gen.FECHA_INICIAL >= '01/06/2016' ");
        return $query->result();
    }

    public function get_todos_ident($ident) {
        $Dane = $this->load->database('dane_ora', true);
        $sql = "SELECT gen.INTERNO_GEN,gen.INTERNO_ENC,gen.VIGENCIA,gen.CODIGO_UNIDAD_EJECUTORA,gen.LUGAR_COMISION,gen.NOMBRE,to_char(gen.FECHA_INICIAL,'YYYY-MM-DD') as FECHA_INICIAL,to_char(gen.FECHA_FINAL,'YYYY-MM-DD') as FECHA_FINAL,gen.OBJETO, liq.VB_OD 
                FROM com_general gen, com_liquida liq 
                WHERE gen.NUMERO_DOCUMENTO = '" . $ident . "' 
                and gen.INTERNO_GEN = liq.INTERNO_GEN 
                and gen.INTERNO_ENC = liq.INTERNO_ENC 
                and gen.VIGENCIA = liq.VIGENCIA 
                and gen.CODIGO_UNIDAD_EJECUTORA = liq.CODIGO_UNIDAD_EJECUTORA 
                and gen.FECHA_INICIAL >= '18/11/2016' ";
        $sql.= "and liq.INTERNO_LIQ = (select max(INTERNO_LIQ) from com_liquida tblliq where gen.INTERNO_GEN = tblliq.INTERNO_GEN and gen.INTERNO_ENC = tblliq.INTERNO_ENC and gen.VIGENCIA = tblliq.VIGENCIA and gen.CODIGO_UNIDAD_EJECUTORA = tblliq.CODIGO_UNIDAD_EJECUTORA)";
        $query = $Dane->query($sql);
        return $query->result();
    }

    public function get_comision_id($ident, $Interno_gen, $Interno_enc, $Vigencia, $CodUnidadEjec) {
        $Dane = $this->load->database('dane_ora', true);
        $sql = "SELECT gen.INTERNO_GEN,gen.INTERNO_ENC,gen.VIGENCIA,gen.CODIGO_UNIDAD_EJECUTORA,gen.LUGAR_COMISION,gen.NOMBRE,gen.FECHA_INICIAL,gen.FECHA_FINAL,gen.OBJETO,gen.NUMERO_DOCUMENTO FROM com_general gen 
                WHERE 
                    gen.INTERNO_GEN = " . $Interno_gen . " 
                and gen.INTERNO_ENC = " . $Interno_enc . " 
                and gen.VIGENCIA = " . $Vigencia . " 
                and gen.CODIGO_UNIDAD_EJECUTORA = " . $CodUnidadEjec;
        $query = $Dane->query($sql);
        return $query->result();
    }

    public function get_todos_com($interno_gen, $interno_enc, $vigencia, $cod_unidad) {
        $sql = " SELECT * FROM com_datos_general ";
        $sql.= " LEFT JOIN com_administradores ON com_administradores_id = id ";
        $sql.= " WHERE interno_gen = " . $interno_gen;
        $sql.= " AND interno_enc = " . $interno_enc;
        $sql.= " AND vigencia    = " . $vigencia;
        $sql.= " AND codigo_unidad_ejecutora  = '" . $cod_unidad . "' ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_lugares($lugar) {
        $sql = " SELECT * FROM com_lugares ";
        $sql.= " WHERE id_datos = " . $lugar;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_sedesSubsedes($lugar) {
        $sql = " SELECT * FROM com_sedes_subsedes ";
        $sql.= " WHERE lugar like '%" . $lugar . "%' ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function add($DatosInsertar) {
        $this->db->insert('com_datos_general', $DatosInsertar);
        $id_datos = $this->db->insert_id();
        return $this->db->insert_id();
    }

    public function add_aspectos($DatosInsertar) {
        $this->db->insert('com_aspectos', $DatosInsertar);
        return $this->db->insert_id();
    }

    public function add_contactos($DatosInsertar) {
        $this->db->insert('com_datos_contacto', $DatosInsertar);
        return $this->db->insert_id();
    }

    public function add_archivos($DatosInsertar) {
        $this->db->insert('com_archivos', $DatosInsertar);
        return $this->db->insert_id();
    }

    public function add_archivos_rutas($DatosInsertar) {
        $this->db->insert('com_archivos_rutas', $DatosInsertar);
        return $this->db->insert_id();
    }

    public function edit_datos_general($id, $DatosEditar) {
        $sql = "UPDATE com_datos_general SET 
                resumen_comision='" . $DatosEditar['resumen_comision'] . "',
                participantes='" . $DatosEditar['participantes'] . "',
                actualizaciones=" . $DatosEditar['actualizaciones'] . ",
                aplicaciones_entidad='" . $DatosEditar['aplicaciones_entidad'] . "',
                recomendaciones='" . $DatosEditar['recomendaciones'] . "',
                estado_actual = ".$DatosEditar['estado_actual']." 
                WHERE id_datos = " . $id;
        $this->db->query($sql);
    }

    public function get_by_id($interno_gen, $interno_enc, $vigencia, $cod_unidad) {
        $Dane = $this->load->database('dane_ora', true);
        $sql = " SELECT * FROM com_general ";
        $sql.= " WHERE INTERNO_GEN = " . $interno_gen;
        $sql.= " AND INTERNO_ENC = " . $interno_enc;
        $sql.= " AND VIGENCIA    = " . $vigencia;
        $sql.= " AND CODIGO_UNIDAD_EJECUTORA  = '" . $cod_unidad . "' ";
        $query = $Dane->query($sql);
        return $query->result();
    }

    public function get_by_id_mapa($id) {
        $sql = " SELECT * FROM com_lugares ";
        $sql.= " WHERE id_lugar = " . $id;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_by_id_sedes($id) {
        $sql = " SELECT * FROM com_sedes_subsedes ";
        $sql.= " WHERE id_sedes_subsedes = " . $id;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_by_id_datos($id) {
        $sql = "SELECT * FROM com_datos_general 
LEFT JOIN com_aspectos_otros ON id_datos = id_datos_otros 
LEFT JOIN com_aspectos_aprendizaje ON id_datos = id_datos_aprendizaje 
LEFT JOIN com_administradores ON com_administradores_id = id 
LEFT JOIN com_criterios ON id_criterio_ap = id_criterio 
WHERE id_datos = " . $id;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_by_id_contacto($id) {
        $sql = "SELECT * FROM com_datos_contacto WHERE id_contacto = " . $id;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function edit_contacto($datos_insertar, $id) {
        $query = $this->db->where('id_contacto', $id);
        $this->db->update('com_datos_contacto', $datos_insertar);
    }

    public function delete_contacto($id) {
        $this->db->where('id_contacto', $id);
        $this->db->delete('com_datos_contacto');
    }
    
    public function delete_archivo($id) {
        $this->db->where('id_archivo', $id);
        $this->db->delete('com_archivos');
    }

    public function get_by_archios($id) {
        //$sql = "SELECT id_archivo,tipo_archivo,archivo_ruta,archivo,resumen_archivo FROM com_archivos WHERE (tipo_archivo = 'presentaciones' || tipo_archivo = 'documentos') AND id_arc_datos = " . $id;
        $sql = "SELECT id_archivo,tipo_archivo,archivo_ruta,archivo,resumen_archivo FROM com_archivos WHERE id_arc_datos = " . $id;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_by_archivos_ruta($id) {
        $sql = "SELECT id_ruta,id_datos_ruta,tipo_ruta,archivo_ruta,archivo,fecha_actualizacion FROM com_archivos_rutas WHERE id_datos_ruta = " . $id;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_by_imagenes($id) {
        $sql = "SELECT tipo_archivo,archivo_ruta,archivo,resumen_archivo FROM com_archivos WHERE tipo_archivo = 'imagenes' AND id_arc_datos = " . $id;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_by_contactos($id) {
        $sql = "SELECT id_contacto,nombre,apellido,cargo,mail,telefono FROM com_datos_contacto WHERE id_datos_con = " . $id;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_by_visitas_user($id, $mail, $fecha) {
        $sql = "SELECT COUNT(*) as vistos 
        FROM com_comisiones_vistas 
        WHERE id_vista_datos = " . $id;
        $sql.= " and mail_visto = '" . $mail . "'";
        $sql.= " and fecha_visto >= '" . $fecha . "'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_by_visitas($id) {
        $sql = "SELECT COUNT(*) as vistos 
        FROM com_comisiones_vistas 
        WHERE id_vista_datos = " . $id;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function add_visita($DatosInsertar) {
        $this->db->insert('com_comisiones_vistas', $DatosInsertar);
        $id_datos = $this->db->insert_id();
        return $this->db->insert_id();
    }

    public function get_by_id_votos($id) {
        $sql = "SELECT SUM(rating_num) as sum FROM com_rating_comisiones WHERE rating_id = " . $id;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_by_id_votos_count($id) {
        $sql = "SELECT COUNT(*) as num FROM com_rating_comisiones WHERE rating_id = " . $id;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_tema() {
        $query = $this->db->select('id_tema,tema');
        $query = $this->db->get('com_temas');
        return $query->row();
    }

    public function get_gen_by_id($id) {
        $query = $this->db->where('id_datos', $id);
        $query = $this->db->get('com_datos_general');
        return $query->result();
    }

    public function buscar_comi($palabra_clave) {
        $sql = "SELECT * FROM com_datos_general 
                LEFT JOIN com_aspectos_otros ON id_datos = id_datos_otros 
                LEFT JOIN com_aspectos_aprendizaje ON id_datos = id_datos_aprendizaje
                LEFT JOIN com_archivos ON id_arc_datos = id_datos 
                LEFT JOIN com_administradores ON com_administradores_id = id 
                WHERE resumen_comision like '%" . $palabra_clave . "%' 
                   OR participantes like '%" . $palabra_clave . "%' 
                   OR aplicaciones_entidad like'%" . $palabra_clave . "%' 
                   OR recomendaciones like '%" . $palabra_clave . "%' 
                   OR fecha_creacion like '%" . $palabra_clave . "%' 
                   OR fortalezas_ap like '%" . $palabra_clave . "%' 
                   OR oportunidades_ap like '%" . $palabra_clave . "%' 
                   OR aplicaciones_ap like '%" . $palabra_clave . "%' 
                   OR actividades_desarrolladas_ot like '%" . $palabra_clave . "%' 
                   OR fortalezas_asp_positivos_ot like '%" . $palabra_clave . "%' 
                   OR oportunidades_mejora_ot like '%" . $palabra_clave . "%' 
                ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function agregarmapa($DatosInsertar) {
        $this->db->insert('com_lugares', $DatosInsertar);
        $id_datos = $this->db->insert_id();
        return $this->db->insert_id();
    }
    
    public function agregarsede($DatosInsertar) {
        $this->db->insert('com_sedes_subsedes', $DatosInsertar);
        $id_datos = $this->db->insert_id();
        return $this->db->insert_id();
    }

    public function actualizarmapa($DatosInsertar, $id) {
        $query = $this->db->where('id_lugar', $id);
        $this->db->update('com_lugares', $DatosInsertar);
    }
    
    public function actualizarmapasede($DatosInsertar, $id) {
        $query = $this->db->where('id_sedes_subsedes', $id);
        $this->db->update('com_sedes_subsedes', $DatosInsertar);
    }

    public function deletemapa($id) {
        $this->db->where('id_lugar', $id);
        $this->db->delete('com_lugares');
    }
    
    public function deletemapasede($id) {
        $this->db->where('id_sedes_subsedes', $id);
        $this->db->delete('com_sedes_subsedes');
    }

    public function comentarios($id) {
        $sql = " SELECT * FROM com_comentarios ";
        $sql.= " WHERE id_datos = " . $id;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function agregarcomentario($DatosInsertar) {
        $this->db->insert('com_comentarios', $DatosInsertar);
        $id_datos = $this->db->insert_id();
        return $this->db->insert_id();
    }

    public function insertarVoto($DatosInsertar) {
        $this->db->insert('com_rating_comisiones', $DatosInsertar);
        return;
    }

    public function ruta_comision($interno_gen, $interno_enc, $vigencia) {
        $Dane = $this->load->database('dane_ora', true);
        $query = $Dane->query("SELECT * FROM com_detalle det where det.INTERNO_GEN = " . $interno_gen . " and det.INTERNO_ENC = " . $interno_enc . " and det.VIGENCIA = '" . $vigencia . "' ");
        return $query->result();
    }

    public function prueba() {
        $Dane = $this->load->database('dane_ora', true);
        //$query = $Dane->query('SELECT * FROM com_liquida where INTERNO_GEN = 1 and INTERNO_ENC = 274 and VIGENCIA = 2016 and CODIGO_UNIDAD_EJECUTORA = 01 ');
        //$query = $Dane->query("SELECT gen.INTERNO_GEN,gen.INTERNO_ENC,gen.VIGENCIA,gen.CODIGO_UNIDAD_EJECUTORA,gen.LUGAR_COMISION,gen.NOMBRE,gen.FECHA_INICIAL,gen.FECHA_FINAL,gen.OBJETO FROM com_general gen WHERE gen.INTERNO_GEN = 1 and gen.INTERNO_ENC = 274 and gen.VIGENCIA = 2016 and gen.CODIGO_UNIDAD_EJECUTORA = 01");
        $query = $Dane->query("SELECT * FROM com_detalle det where det.INTERNO_GEN = 1 and det.INTERNO_ENC = 1135 and det.VIGENCIA = '2016' ");
        return $query->result();
    }

    public function get_todos_crm() {
        $Dane = $this->load->database('dane_crm', true);
        $query = $Dane->query('SELECT * FROM GESTIONH.GH_ADMIN_USUARIOS ');
        //$query = $Dane->query("SELECT gen.INTERNO_GEN,gen.INTERNO_ENC,gen.VIGENCIA,gen.CODIGO_UNIDAD_EJECUTORA,gen.LUGAR_COMISION,gen.NOMBRE,gen.FECHA_INICIAL,gen.FECHA_FINAL,gen.OBJETO FROM com_general gen WHERE gen.FECHA_INICIAL >= '01/06/2016' ");
        return $query->result();
    }
    
    public function update_file_legalizacion($id, $DatosEditar) {
        $sql = "UPDATE com_archivos_rutas SET 
                tipo_ruta='" . $DatosEditar['tipo_ruta'] . "',
                archivo_ruta='" . $DatosEditar['archivo_ruta'] . "',
                archivo='" . $DatosEditar['archivo'] . "'
                WHERE id_ruta = " . $id;
        $this->db->query($sql);
    }
    
    public function get_todos_ident_prueba($ident) {
        $Dane = $this->load->database('dane_ora', true);
        $sql = "SELECT gen.INTERNO_GEN,gen.INTERNO_ENC,gen.VIGENCIA,gen.CODIGO_UNIDAD_EJECUTORA,gen.LUGAR_COMISION,gen.NOMBRE,to_char(gen.FECHA_INICIAL,'YYYY-MM-DD') as FECHA_INICIAL,to_char(gen.FECHA_FINAL,'YYYY-MM-DD') as FECHA_FINAL,gen.OBJETO, liq.VB_OD 
                FROM com_general gen, com_liquida liq 
                WHERE gen.NUMERO_DOCUMENTO = '" . $ident . "' 
                and gen.INTERNO_GEN = liq.INTERNO_GEN 
                and gen.INTERNO_ENC = liq.INTERNO_ENC 
                and gen.VIGENCIA = liq.VIGENCIA 
                and gen.CODIGO_UNIDAD_EJECUTORA = liq.CODIGO_UNIDAD_EJECUTORA 
                and gen.FECHA_INICIAL >= '01/01/2016' ";
        //$sql.= "and liq.INTERNO_LIQ = (select max(INTERNO_LIQ) from com_liquida tblliq where gen.INTERNO_GEN = tblliq.INTERNO_GEN and gen.INTERNO_ENC = tblliq.INTERNO_ENC and gen.VIGENCIA = tblliq.VIGENCIA and gen.CODIGO_UNIDAD_EJECUTORA = tblliq.CODIGO_UNIDAD_EJECUTORA)";
        $query = $Dane->query($sql);
        return $query->result();
    }
}
