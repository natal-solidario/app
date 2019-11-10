<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Local_entrega_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function get_locais() {
        return $this->db->get('local_entrega')->result_array();
    }

    function get_locais_armazenamento() {
        return $this->db->get_where('local_entrega',array('local_entrega_familias' => 0))->result_array();
    }

    function get_locais_entrega_presente() {
        return $this->db->get_where('local_entrega',array('local_entrega_familias' => 1))->result_array();
    }
}
?>