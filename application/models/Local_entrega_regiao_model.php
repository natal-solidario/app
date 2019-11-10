<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Local_entrega_regiao_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function get_local_entrega_por_regiao($idRegiaoAdministrativa, $dataAtual) {
        $this->db->select('local_entrega_regiao.*, l.nome as nomeLocalEntrega, l.endereco as enderecoLocalEntrega'.
            ', l.url_google_maps as mapsLocalEntrega, l.local_entrega_familias as entregaFamiliasLocalEntrega');
        $this->db->join('local_entrega l', 'l.id = local_entrega');
        $this->db->where('ano_evento', date("Y"));
        $this->db->where('l.local_entrega_familias', false);
        $this->db->where('regiao_administrativa', $idRegiaoAdministrativa)
            ->group_start()
            ->where('data_regular', true)
            ->or_where('inicio <=', $dataAtual)
            ->group_end();
        $this->db->order_by('inicio', 'desc');
        
        $retorno = $this->db->get('local_entrega_regiao')->result_array();
        
        return $retorno;
    }
    
    function get_local_entrega_familias_por_regiao($idRegiaoAdministrativa) {
        $this->db->select('local_entrega_regiao.*, l.nome as nomeLocalEntrega, l.endereco as enderecoLocalEntrega'.
            ', l.url_google_maps as mapsLocalEntrega, l.local_entrega_familias as entregaFamiliasLocalEntrega');
        $this->db->join('local_entrega l', 'l.id = local_entrega');
        $this->db->where('ano_evento', date("Y"));
        $this->db->where('l.local_entrega_familias', true);
        $this->db->where('regiao_administrativa', $idRegiaoAdministrativa);
        $this->db->order_by('inicio', 'desc');
        
        $retorno = $this->db->get('local_entrega_regiao')->row_array();
        
        return $retorno;
    }
    
    
    function get_local_entrega_familias() {
        $this->db->select('local_entrega_regiao.*, l.nome as nomeLocalEntrega, l.id as idLocalEntrega, l.endereco as enderecoLocalEntrega'.
            ', l.url_google_maps as mapsLocalEntrega, l.local_entrega_familias as entregaFamiliasLocalEntrega'.
            ', r.nome as regiao_administrativa_nome, r.id as regiao_administrativa_id');
        $this->db->join('local_entrega l', 'l.id = local_entrega');
        $this->db->join('regiao_administrativa r', 'r.id = local_entrega_regiao.regiao_administrativa');
        $this->db->where('ano_evento', date("Y"));
        $this->db->where('l.local_entrega_familias', true);
        $this->db->order_by('r.nome', 'asc');
        $this->db->order_by('l.nome', 'asc');

        return $this->db->get('local_entrega_regiao')->result_array();
    }
}
?>