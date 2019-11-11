<?php 

class Presente_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function pesquisar_por_carta($idCarta) {
        return $this->db->get_where('presente', array('carta'=>$idCarta))->row_array();
    }
    
    function add($params)
    {
        $this->db->insert('presente',$params);
        return $this->db->insert_id();
    }
    
    function update($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('presente',$params);
    }

    function get_dados_presente($numeroCarta){
        $this->db->select('carta.id as idCarta, carta.numero as numeroCarta, beneficiado.nome as beneficiado_nome
            , beneficiado.sexo as beneficiado_sexo, r.nome as responsavel_nome, a.nome as adotante_nome, a.email as adotante_email
            , salap.sala as numeroSalaEntrega, local.nome as nomeLocalEntrega, p.local_armazenamento as localArmazenamentoPresente
            , p.id as idPresente, p.situacao as situacaoPresente, p.imagem_entrega, p.local_entrega as presente_local_entrega');
        $this->db->join('beneficiado', 'carta.beneficiado = beneficiado.id');
        $this->db->join('responsavel r', 'beneficiado.responsavel = r.id');
        $this->db->join('adotante a', 'carta.adotante = a.id', 'left');
        $this->db->join('presente p', 'carta.id = p.carta', 'left');
        $this->db->join('sala_entrega_responsavel salar', 'r.id = salar.responsavel', 'left');
        $this->db->join('sala_entrega_presente salap', 'salar.sala_entrega_presente = salap.id', 'left');
        $this->db->join('local_entrega local', 'local.id = salap.local_entrega');
        $this->db->like('carta.removida', false);


        $dadosPresente = $this->db->get_where('carta',array('carta.numero'=>$numeroCarta))->row_array();
        //echo $this->db->last_query();
        return $dadosPresente;

        //return $this->db->get_where('presente',array('carta'=>$idCarta))->row_array();
    }

    function get_all_situacoes_presente() {
        return $this->db->get('presente_situacao')->result_array();
    }
    
    function get_presentes_por_local_entrega($campanha=0) {
        $query = $this->db->query('SELECT c.regiao_administrativa as carta_destino, r.nome as presente_nome_regiao_entrega
            , l.nome as presente_nome_local_entrega, COUNT(p.id) AS total 
            FROM local_entrega l
            INNER JOIN local_entrega_regiao lr ON lr.local_entrega = l.id
            INNER JOIN regiao_administrativa r ON r.id = lr.regiao_administrativa
            LEFT JOIN presente p ON p.local_entrega = l.id AND p.situacao >= 4
            LEFT JOIN carta c ON c.id = p.carta
            GROUP BY l.nome, r.nome, c.regiao_administrativa
            ORDER BY c.regiao_administrativa');
        return $query->result_array();
    }
}