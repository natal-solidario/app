<?php
/* 
 * João Paulo
 * jpaulocs@gmail.com
 */
 
class Beneficiado_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get beneficiado by id
     */
    function get_beneficiado($id)
    {
        return $this->db->get_where('beneficiado',array('id'=>$id))->row_array();
    }

    /*
     * Get all beneficiados
     */
    function get_all_beneficiados()
    {
        $this->db->select('beneficiado.*, responsavel.nome as responsavel_nome');
        $this->db->join('responsavel', 'beneficiado.responsavel = responsavel.id');
        $this->db->order_by('beneficiado.id', 'desc');
        return $this->db->get('beneficiado')->result_array();
    }

    /*
     * function to add new beneficiado
     */
    function add_beneficiado($params)
    {
        $this->db->insert('beneficiado',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update beneficiado
     */
    function update_beneficiado($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('beneficiado',$params);
    }
    
    /*
     * function to delete beneficiado
     */
    function delete_beneficiado($id)
    {
        return $this->db->delete('beneficiado',array('id'=>$id));
    }

    /*
     * Get all beneficiados
     */
    function get_all_beneficiados_por_adotante($idAdotante)
    {
        $this->db->select('beneficiado.nome');
        $this->db->distinct();
        $this->db->join('carta', 'beneficiado.id = carta.beneficiado');
        $this->db->join('adotante', 'carta.adotante = adotante.id');
        $this->db->where('adotante.id', $idAdotante);
        $this->db->group_by('beneficiado.nome');
        $this->db->order_by('beneficiado.nome', 'asc');
        return $this->db->get('beneficiado')->result_array();
    }
}