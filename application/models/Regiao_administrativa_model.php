<?php 

class Regiao_administrativa_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
 
    function get_por_id($id)
    {
        return $this->db->get_where('regiao_administrativa',array('id' => $id))->row_array();
    }
 
    function get_all()
    {
        $this->db->order_by('nome');
        return $this->db->get('regiao_administrativa')->result();
    }
}