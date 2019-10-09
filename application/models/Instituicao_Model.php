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
        $this->db->select('TBP01_INSTITUICAO.*, TBH01_ENDERECO.NU_CEP, TBH01_ENDERECO.NO_LOGRADOURO, TBH01_ENDERECO.NU_ENDERECO, TBH01_ENDERECO.DE_COMPLEMENTO, TBH01_ENDERECO.NO_BAIRRO, TBH01_ENDERECO.NO_CIDADE, TBH01_ENDERECO.SG_UF, usuario.id as ID_USUARIO, TBH02_TELEFONE.NU_DDD, TBH02_TELEFONE.NU_TELEFONE');
        $this->db->from('TBP01_INSTITUICAO');
        $this->db->join('TBH01_ENDERECO', 'TBH01_ENDERECO.NU_TBH01 = TBP01_INSTITUICAO.NU_TBH01', 'INNER');
        $this->db->join('TBH02_TELEFONE', 'TBH02_TELEFONE.NU_TBH02 = TBP01_INSTITUICAO.NU_TBH02', 'LEFT');
        $this->db->join('TBP02_RESPONSAVEL_INSTITUICAO', 'TBP02_RESPONSAVEL_INSTITUICAO.NU_TBP01 = TBP01_INSTITUICAO.NU_TBH01', 'INNER');
        $this->db->join('usuario', 'usuario.id = TBP02_RESPONSAVEL_INSTITUICAO.ID_USUARIO', 'INNER');
        $this->db->where(array('TBP01_INSTITUICAO.NU_TBP01' => $id));
        // echo "<pre>" . $this->db->get_compiled_select(); exit();
        return $this->db->get()->row_array();
    }
        
    /*
     * Get all instituições
     */
    function get_all_instituicoes()
    {
        $this->db->select('TBP01_INSTITUICAO.*, regiao_administrativa.nome as regiao_administrativa_nome, TBH01_ENDERECO.NO_CIDADE, TBH01_ENDERECO.SG_UF, TBH02_TELEFONE.NU_DDD, TBH02_TELEFONE.NU_TELEFONE');
        $this->db->from('TBP01_INSTITUICAO');
        $this->db->join('TBH01_ENDERECO', 'TBH01_ENDERECO.NU_TBH01 = TBP01_INSTITUICAO.NU_TBH01', 'INNER');
        $this->db->join('TBH02_TELEFONE', 'TBH02_TELEFONE.NU_TBH02 = TBP01_INSTITUICAO.NU_TBH02', 'LEFT');
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
    
    function add_telefone($params)
    {
        $this->db->insert('TBH02_TELEFONE', $params);
        return $this->db->insert_id();
    }
    
    function add_vinculo_instituicao_usuario($params)
    {
        $this->db->insert('TBP02_RESPONSAVEL_INSTITUICAO', $params);
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

    function update_telefone($id, $params)
    {
        $this->db->where('NU_TBH02', $id);
        return $this->db->update('TBH02_TELEFONE', $params);
    }

    function update_vinculo_instituicao_usuario($id, $params)
    {
        $this->db->where('NU_TBP01', $id);
        return $this->db->update('TBP02_RESPONSAVEL_INSTITUICAO', $params);
    }
    
    /*
     * function to delete instituição
     */
    function delete_instituicao($id)
    {
        return $this->db->delete('TBP01_INSTITUICAO',array('NU_TBP01' => $id));
    }
}
