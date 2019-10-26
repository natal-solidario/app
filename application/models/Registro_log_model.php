<?php
class Registro_log_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get registro_log by id
     */
    function get_registro_log($id)
    {
        return $this->db->get_where('registro_log',array('id'=>$id))->row_array();
    }
        
    /*
     * Get all registros_log
     */
    function get_all_registros_log()
    {
        $this->db->order_by('id', 'desc');
        return $this->db->get('registro_log')->result_array();
    }
        
    /*
     * function to add new registro_log
     */
    function add_registro_log($params)
    {
        $this->db->insert('registro_log',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update registro_log
     */
    function update_registro_log($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('registro_log',$params);
    }
    
    /*
     * function to delete registro_log
     */
    function delete_registro_log($id)
    {
        return $this->db->delete('registro_log',array('id'=>$id));
    }
}
