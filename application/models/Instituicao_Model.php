<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Instituicao_model extends CI_Model
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
        $this->db->select('TBP01_INSTITUICAO.*, TBH01_ENDERECO.NU_CEP, TBH01_ENDERECO.NO_LOGRADOURO, TBH01_ENDERECO.NU_ENDERECO, TBH01_ENDERECO.DE_COMPLEMENTO, TBH01_ENDERECO.NO_BAIRRO, TBH01_ENDERECO.NO_CIDADE, TBH01_ENDERECO.SG_UF, usuario.id as ID_USUARIO, TBH02_TELEFONE.NU_DDD, TBH02_TELEFONE.NU_TELEFONE, TBC02_ABRANGENCIA_INSTITUICAO.NU_TBC02 as ABRANGENCIA_ID');
        $this->db->from('TBP01_INSTITUICAO');
        $this->db->join('TBH01_ENDERECO', 'TBH01_ENDERECO.NU_TBH01 = TBP01_INSTITUICAO.NU_TBH01', 'LEFT');
        $this->db->join('TBH02_TELEFONE', 'TBH02_TELEFONE.NU_TBH02 = TBP01_INSTITUICAO.NU_TBH02', 'LEFT');
        $this->db->join('TBP02_RESPONSAVEL_INSTITUICAO', 'TBP02_RESPONSAVEL_INSTITUICAO.NU_TBP01 = TBP01_INSTITUICAO.NU_TBP01', 'LEFT');
        $this->db->join('TBC02_ABRANGENCIA_INSTITUICAO', 'TBC02_ABRANGENCIA_INSTITUICAO.NU_TBP01 = TBP01_INSTITUICAO.NU_TBP01', 'LEFT');
        $this->db->join('usuario', 'usuario.id = TBP02_RESPONSAVEL_INSTITUICAO.ID_USUARIO', 'LEFT');
        $this->db->where(array('TBP01_INSTITUICAO.NU_TBP01' => $id));
        // echo "<pre>" . $this->db->get_compiled_select(); exit();
        return $this->db->get()->row_array();
    }
        
    /*
     * Get all instituições
     */
    function get_all_instituicoes()
    {
        $this->db->select('TBP01_INSTITUICAO.*, regiao_administrativa.nome as regiao_administrativa_nome, TBH01_ENDERECO.NO_CIDADE, TBH01_ENDERECO.SG_UF, TBH02_TELEFONE.NU_DDD, TBH02_TELEFONE.NU_TELEFONE, TBC02_ABRANGENCIA_INSTITUICAO.NU_TBC02 as ABRANGENCIA_ID');
        $this->db->from('TBP01_INSTITUICAO');
        $this->db->join('TBH01_ENDERECO', 'TBH01_ENDERECO.NU_TBH01 = TBP01_INSTITUICAO.NU_TBH01', 'LEFT');
        $this->db->join('TBH02_TELEFONE', 'TBH02_TELEFONE.NU_TBH02 = TBP01_INSTITUICAO.NU_TBH02', 'LEFT');
        $this->db->join('regiao_administrativa', 'regiao_administrativa.id = TBP01_INSTITUICAO.ID_REGIAO_ADMINISTRATIVA', 'INNER');
        $this->db->join('TBC02_ABRANGENCIA_INSTITUICAO', 'TBC02_ABRANGENCIA_INSTITUICAO.NU_TBP01 = TBP01_INSTITUICAO.NU_TBP01', 'LEFT');
        $this->db->order_by('TBP01_INSTITUICAO.NU_TBP01', 'desc');
        // echo $this->db->get_compiled_select();
        return $this->db->get()->result_array();
    }

    function get_instituicao_by_usuario($usuario_id)
    {
        $this->db->select('TBP01_INSTITUICAO.*, usuario.id as ID_USUARIO, TBC02_ABRANGENCIA_INSTITUICAO.NU_TBC02 as ABRANGENCIA_ID');
        $this->db->from('TBP01_INSTITUICAO');
        $this->db->join('TBP02_RESPONSAVEL_INSTITUICAO', 'TBP02_RESPONSAVEL_INSTITUICAO.NU_TBP01 = TBP01_INSTITUICAO.NU_TBP01', 'LEFT');
        $this->db->join('TBC02_ABRANGENCIA_INSTITUICAO', 'TBC02_ABRANGENCIA_INSTITUICAO.NU_TBP01 = TBP01_INSTITUICAO.NU_TBP01', 'LEFT');
        $this->db->join('usuario', 'usuario.id = TBP02_RESPONSAVEL_INSTITUICAO.ID_USUARIO', 'LEFT');
        $this->db->where(array('TBP02_RESPONSAVEL_INSTITUICAO.ID_USUARIO' => $usuario_id));
        // echo "<pre>" . $this->db->get_compiled_select(); exit();
        return $this->db->get()->row_array();
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
        $this->delete_vinculo_instituicao_usuario($params);
        $this->db->insert('TBP02_RESPONSAVEL_INSTITUICAO', $params);
        return $this->db->insert_id();
    }
    
    function add_abrangencia_instituicao($params)
    {
        $this->db->insert('TBC02_ABRANGENCIA_INSTITUICAO', $params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update instituição
     */
    function update_instituicao($id, $params)
    {
        $this->db->where('NU_TBP01', $id);
        $update = $this->db->update('TBP01_INSTITUICAO', $params);
        return ($update ? $id : $update);
    }

    function update_endereco($id, $params)
    {
        $this->db->where('NU_TBH01', $id);
        $update = $this->db->update('TBH01_ENDERECO', $params);
        return ($update ? $id : $update);
    }

    function update_telefone($id, $params)
    {
        $this->db->where('NU_TBH02', $id);
        $update = $this->db->update('TBH02_TELEFONE', $params);
        return ($update ? $id : $update);
    }

    function update_vinculo_instituicao_usuario($id, $params)
    {
        $this->add_vinculo_instituicao_usuario($params);
    }
    
    /*
     * function to delete instituição
     */
    function delete_instituicao($id)
    {
        return $this->db->delete('TBP01_INSTITUICAO',array('NU_TBP01' => $id));
    }

    function delete_vinculo_instituicao_usuario($params)
    {
        return $this->db->delete('TBP02_RESPONSAVEL_INSTITUICAO', $params);
    }

    function delete_abrangencia_instituicao($id)
    {
        // Pega a campanha atual
        $this->db->select_max('AA_CAMPANHA');
        $this->db->from('TBC01_CAMPANHA');
        $campanha_atual = $this->db->get_where('TBC01_CAMPANHA', array('AA_CAMPANHA' => $this->db->get()->row()->AA_CAMPANHA))->row_array();

        // TBP01 = instituição / TBC01 = campanha
        $params = array('NU_TBP01' => $id, 'NU_TBC01' => $campanha_atual['NU_TBC01']);
        $delete = $this->db->delete('TBC02_ABRANGENCIA_INSTITUICAO', $params);
        return ($delete ? $id : $delete);
    }

    function checar_instituicao_vinculo_campanha_atual($id) {
        // Pega a campanha atual
        $this->db->select_max('AA_CAMPANHA');
        $this->db->from('TBC01_CAMPANHA');
        $campanha_atual = $this->db->get_where('TBC01_CAMPANHA', array('AA_CAMPANHA' => $this->db->get()->row()->AA_CAMPANHA))->row_array();

        // TBP01 = instituição / TBC01 = campanha
        $this->db->where(array('NU_TBP01' => $id, 'NU_TBC01' => $campanha_atual['NU_TBC01']));
        return $this->db->get('TBC02_ABRANGENCIA_INSTITUICAO')->num_rows();
    }

    function get_instituicao_vinculo_campanha($id) {
        $this->db->select('TBP01_INSTITUICAO.*, TBH01_ENDERECO.NU_CEP, TBH01_ENDERECO.NO_LOGRADOURO, TBH01_ENDERECO.NU_ENDERECO, TBH01_ENDERECO.DE_COMPLEMENTO, TBH01_ENDERECO.NO_BAIRRO, TBH01_ENDERECO.NO_CIDADE, TBH01_ENDERECO.SG_UF, usuario.id as ID_USUARIO, TBH02_TELEFONE.NU_DDD, TBH02_TELEFONE.NU_TELEFONE, TBC02_ABRANGENCIA_INSTITUICAO.NU_TBC02 as ABRANGENCIA_ID');
        $this->db->from('TBP01_INSTITUICAO');
        $this->db->join('TBH01_ENDERECO', 'TBH01_ENDERECO.NU_TBH01 = TBP01_INSTITUICAO.NU_TBH01', 'LEFT');
        $this->db->join('TBH02_TELEFONE', 'TBH02_TELEFONE.NU_TBH02 = TBP01_INSTITUICAO.NU_TBH02', 'LEFT');
        $this->db->join('TBP02_RESPONSAVEL_INSTITUICAO', 'TBP02_RESPONSAVEL_INSTITUICAO.NU_TBP01 = TBP01_INSTITUICAO.NU_TBP01', 'LEFT');
        $this->db->join('TBC02_ABRANGENCIA_INSTITUICAO', 'TBC02_ABRANGENCIA_INSTITUICAO.NU_TBP01 = TBP01_INSTITUICAO.NU_TBP01', 'LEFT');
        $this->db->join('usuario', 'usuario.id = TBP02_RESPONSAVEL_INSTITUICAO.ID_USUARIO', 'LEFT');
        $this->db->where(array('TBC02_ABRANGENCIA_INSTITUICAO.NU_TBC02' => $id));
        // echo "<pre>" . $this->db->get_compiled_select(); exit();
        return $this->db->get()->row_array();

    }

    function check_unique_cnpj($id = '', $cnpj) {
        $this->db->where('NU_CNPJ', $cnpj);

        if ($id) {
            $this->db->where_not_in('NU_TBP01', $id);
        }
        return $this->db->get('TBP01_INSTITUICAO')->num_rows();
    }
}
