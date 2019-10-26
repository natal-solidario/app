<?php
class Registro_log_acao_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get registro_log_acao by id
     */
    function get_registro_log_acao($id)
    {
        return $this->db->get_where('registro_log_acao',array('id'=>$id))->row_array();
    }
        
    /*
     * Get all registros_log_acao
     */
    function get_all_registros_log_acao()
    {
        $this->db->order_by('id', 'desc');
        return $this->db->get('registro_log_acao')->result_array();
    }
        
    /*
     * function to add new registro_log_acao
     */
    function add_registro_log_acao($params)
    {
        $this->db->insert('registro_log_acao',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update registro_log_acao
     */
    function update_registro_log_acao($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('registro_log_acao',$params);
    }
    
    /*
     * function to delete registro_log_acao
     */
    function delete_registro_log_acao($id)
    {
        return $this->db->delete('registro_log_acao',array('id'=>$id));
    }
}
