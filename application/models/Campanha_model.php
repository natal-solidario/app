<?php
class Campanha_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->campanhaTbl = 'TBC01_CAMPANHA';
    }

    function get($id)
    {
        return $this->db->get_where($this->campanhaTbl, array('NU_TBC01' => $id))->row();
    }

    function get_campanha_atual()
    {
        $this->db->select_max('AA_CAMPANHA');
        $this->db->from($this->campanhaTbl);
        return $this->db->get_where($this->campanhaTbl, array('AA_CAMPANHA' => $this->db->get()->row()->AA_CAMPANHA))->row_array();
    }

    function get_all()
    {
        $this->db->order_by('AA_CAMPANHA', 'desc');
        return $this->db->get($this->campanhaTbl)->result();
    }

    function get_instituicoes($id)
    {
        $this->db->select('TBP01_INSTITUICAO.*, regiao_administrativa.nome as regiao_administrativa_nome, TBH01_ENDERECO.NO_CIDADE, TBH01_ENDERECO.SG_UF, TBC02_ABRANGENCIA_INSTITUICAO.NU_TBC02, TBH02_TELEFONE.NU_DDD, TBH02_TELEFONE.NU_TELEFONE');
        $this->db->from('TBP01_INSTITUICAO');
        $this->db->join('TBH01_ENDERECO', 'TBH01_ENDERECO.NU_TBH01 = TBP01_INSTITUICAO.NU_TBH01', 'INNER');
        $this->db->join('TBH02_TELEFONE', 'TBH02_TELEFONE.NU_TBH02 = TBP01_INSTITUICAO.NU_TBH02', 'LEFT');
        $this->db->join('regiao_administrativa', 'regiao_administrativa.id = TBP01_INSTITUICAO.ID_REGIAO_ADMINISTRATIVA', 'INNER');
        $this->db->join('TBC02_ABRANGENCIA_INSTITUICAO', 'TBC02_ABRANGENCIA_INSTITUICAO.NU_TBP01 = TBP01_INSTITUICAO.NU_TBP01', 'INNER');
        $this->db->order_by('TBP01_INSTITUICAO.NU_TBP01', 'desc');
        $this->db->where(array('TBC02_ABRANGENCIA_INSTITUICAO.NU_TBC01' => $id));
        // echo "<pre>" . $this->db->get_compiled_select(); exit();
        return $this->db->get()->result_array();
    }

    function add($params)
    {
        $this->db->insert($this->campanhaTbl, $params);
        // echo "<pre>" . $this->db->get_compiled_select(); exit();
        return $this->db->insert_id();
    }

    function add_instituicao($params)
    {
        $this->db->insert('TBC02_ABRANGENCIA_INSTITUICAO', $params);
        return $this->db->insert_id();
    }

    function del_instituicao($id)
    {
        return $this->db->delete('TBC02_ABRANGENCIA_INSTITUICAO', array('NU_TBC02' => $id));
    }
    
    function update($id, $params)
    {
        $this->db->where('NU_TBC01', $id);
        return $this->db->update($this->campanhaTbl, $params);
    }
    
    function delete($id)
    {
        return $this->db->delete($this->campanhaTbl, array('NU_TBC01' => $id));
    }
}