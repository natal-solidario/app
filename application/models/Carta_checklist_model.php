<?php
class Carta_checklist_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get carta_checklist by id
     */
    function get_carta_checklist($id)
    {
        return $this->db->get_where('carta_checklist',array('id_carta'=>$id))->row_array();
    }
        
    /*
     * Get all carta_checklist
     */
    function get_all_cartas_checklist()
    {
        $this->db->order_by('id', 'desc');
        return $this->db->get('carta_checklist')->result_array();
    }
        
    /*
     * function to add new carta_checklist
     */
    function add_carta_checklist($params)
    {
        $this->db->insert('carta_checklist',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update carta_checklist
     */
    function update_carta_checklist($id,$params)
    {
        $this->db->where('id_carta',$id);
        return $this->db->update('carta_checklist',$params);
    }
    
    /*
     * function to delete carta_checklist
     */
    function delete_carta_checklist($id)
    {
        return $this->db->delete('carta_checklist',array('id_carta'=>$id));
    }
}
