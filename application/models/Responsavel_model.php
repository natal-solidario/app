<?php
/* 
 * João Paulo
 * jpaulocs@gmail.com
 */
 
class Responsavel_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get responsavel by id
     */
    function get_responsavel($id)
    {
        return $this->db->get_where('responsavel',array('id' => $id))->row_array();
    }
    
    /*
     * Get responsavel by cpf
     */
    function get_responsavel_by_cpf($id)
    {
        // return $this->db->get_where('responsavel',array("REPLACE(REPLACE(documento_numero, '-', ''), '.', '') =" => $id))->row_array();

        $sql = "REPLACE(REPLACE(`documento_numero`, '-', ''), '.', '') = " . preg_replace("/[^0-9A-Za-z]/", "", $id) . "";
        $this->db->from('responsavel')->where($sql);
        // echo "<pre>" . $this->db->get_compiled_select(); exit();
        return $this->db->get()->row_array();
    }
    
    /*
     * Retorna responsável por nome e data de nascimento
     */
    function get_responsavel_by_nome_data_nascimento($nome, $data_nascimento)
    {
        // return $this->db->get_where('responsavel',array("REPLACE(REPLACE(documento_numero, '-', ''), '.', '') =" => $id))->row_array();

        $sql = "TRIM(`nome`) = '" . mb_strtolower($nome) . "' AND `data_nascimento` = '" . $data_nascimento . "'";
        $this->db->from('responsavel')->where($sql);
        // echo "<pre>" . $this->db->get_compiled_select(); exit();
        return $this->db->get()->row_array();
    }
        
    /*
     * Get all responsaveis
     */
    function get_all_responsaveis()
    {
        $this->db->order_by('id', 'desc');
        return $this->db->get('responsavel')->result_array();
    }
        
    /*
     * function to add new responsavel
     */
    function add_responsavel($params)
    {
        $this->db->insert('responsavel',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update responsavel
     */
    function update_responsavel($id, $params)
    {
        $this->db->where('id', $id);
        $update = $this->db->update('responsavel', $params);
        return ($update ? $id : $update);
    }
    
    /*
     * function to delete responsavel
     */
    function delete_responsavel($id)
    {
        return $this->db->delete('responsavel',array('id'=>$id));
    }
}
