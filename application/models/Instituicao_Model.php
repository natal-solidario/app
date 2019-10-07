<?php

class Instituicao_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->instituicaoTbl = 'TBP01_INSTITUICAO';
    }
    
    /*
     * Get instituição by id
     */
    function get_instituicao($id)
    {
        $this->db->select('TBP01_INSTITUICAO.*, TBH01_ENDERECO.NU_CEP, TBH01_ENDERECO.NO_LOGRADOURO, TBH01_ENDERECO.NU_ENDERECO, TBH01_ENDERECO.DE_COMPLEMENTO, TBH01_ENDERECO.NO_BAIRRO, TBH01_ENDERECO.NO_CIDADE, TBH01_ENDERECO.SG_UF, usuario.id as ID_USUARIO');
        $this->db->join('TBH01_ENDERECO', 'TBH01_ENDERECO.NU_TBH01 = TBP01_INSTITUICAO.NU_TBH01', 'INNER');
        $this->db->join('tbp02_responsavel_instituicao', 'tbp02_responsavel_instituicao.NU_TBP01 = TBP01_INSTITUICAO.NU_TBH01', 'INNER');
        $this->db->join('usuario', 'usuario.id = tbp02_responsavel_instituicao.ID_USUARIO', 'INNER');
        return $this->db->get_where('TBP01_INSTITUICAO', array('TBP01_INSTITUICAO.NU_TBP01' => $id))->row_array();
    }
        
    /*
     * Get all instituições
     */
    function get_all_instituicoes()
    {
        $this->db->select('TBP01_INSTITUICAO.*, regiao_administrativa.nome as regiao_administrativa_nome, TBH01_ENDERECO.NO_CIDADE, TBH01_ENDERECO.SG_UF');
        $this->db->from('TBP01_INSTITUICAO');
        $this->db->join('TBH01_ENDERECO', 'TBH01_ENDERECO.NU_TBH01 = TBP01_INSTITUICAO.NU_TBH01', 'INNER');
        $this->db->join('regiao_administrativa', 'regiao_administrativa.id = TBP01_INSTITUICAO.ID_REGIAO_ADMINISTRATIVA', 'INNER');
        $this->db->order_by('TBP01_INSTITUICAO.NU_TBP01', 'desc');
        // echo $this->db->get_compiled_select();
        return $this->db->get()->result_array();
    }

    /*
     * function to add new instituicao
     */
    function add_instituicao($params)
    {
        $this->db->insert('TBP01_INSTITUICAO', $params);
        return $this->db->insert_id();
    }
    
    function add_endereco($params)
    {
        $this->db->insert('TBH01_ENDERECO', $params);
        return $this->db->insert_id();
    }
    
    function add_vinculo_instituicao_usuario($params)
    {
        $this->db->insert('tbp02_responsavel_instituicao', $params);
        return $this->db->insert_id();
    }
    
    /*function add_abrangencia_instituicao($params)
    {
        $this->db->insert('tbc02_abrangencia_instituicao', $params);
        return $this->db->insert_id();
    }*/
    
    /*
     * function to update instituição
     */
    function update_instituicao($id, $params)
    {
        $this->db->where('NU_TBP01', $id);
        return $this->db->update('TBP01_INSTITUICAO', $params);
    }

    function update_endereco($id, $params)
    {
        $this->db->where('NU_TBH01', $id);
        return $this->db->update('TBH01_ENDERECO', $params);
    }

    function update_vinculo_instituicao_usuario($id, $params)
    {
        $this->db->where('NU_TBP01', $id);
        return $this->db->update('tbp02_responsavel_instituicao', $params);
    }
    
    /*
     * function to delete instituição
     */
    function delete_instituicao($id)
    {
        return $this->db->delete('TBP01_INSTITUICAO',array('NU_TBP01' => $id));
    }
}
