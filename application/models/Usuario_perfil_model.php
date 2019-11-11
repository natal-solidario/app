<?php
class Usuario_perfil_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all_perfil() {
        $this->db->order_by('id', 'desc');
        return $this->db->get('perfil')->result_array();
    }
    
    /*
     * Get usuario_perfil by id
     */
    function get_usuario_perfil($id)
    {
        return $this->db->get_where('usuario_perfil',array('id'=>$id))->row_array();
    }
        
    /*
     * Get all usuarios_perfil
     */
    function get_all_usuarios_perfil()
    {
        $this->db->order_by('id', 'desc');
        return $this->db->get('usuario_perfil')->result_array();
    }
        
    /*
     * function to add new usuario_perfil
     */
    function add_usuario_perfil($params)
    {
        $this->db->insert('usuario_perfil',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update usuario_perfil
     */
    function update_usuario_perfil($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('usuario_perfil',$params);
    }
    
    /*
     * function to delete usuario_perfil
     */
    function delete_usuario_perfil($id)
    {
        return $this->db->delete('usuario_perfil',array('id'=>$id));
    }
}
