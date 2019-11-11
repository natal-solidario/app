<?php
class Carta_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function get_carta_pedido($id)
    {
        return $this->db->get_where('carta',array('id'=>$id))->row_array();
    }

    function get_all_cartas($limit, $start, $ordem, $direcao)
    {
        $this->db->limit($limit, $start);
        $this->db->select('carta.*, beneficiado.nome as beneficiado_nome, beneficiado.data_nascimento as beneficiado_data, responsavel.nome as responsavel_nome, adotante.nome as adotante_nome, carteiro.first_name as carteiro_nome, mobilizador.first_name as mobilizador_nome');
        $this->db->join('beneficiado', 'carta.beneficiado = beneficiado.id');
        $this->db->join('responsavel', 'beneficiado.responsavel = responsavel.id');
        $this->db->join('usuario carteiro', 'carteiro.id = carta.carteiro_associado');
        $this->db->join('usuario mobilizador', 'mobilizador.id = carta.mobilizador');
        $this->db->join('adotante', 'carta.adotante = adotante.id', 'left');
        $this->db->where('carta.removida', false);
        $this->db->order_by(($ordem ? $ordem : 'id'), ($direcao ? $direcao : 'desc'));
        return $this->db->get('carta')->result_array();
    }
    
    function get_total_responsaveis_por_regiao($campanha='')
    {
        $this->db->select(
            'nome as regiao_administrativa, COUNT(1) as total FROM ('
	           . ' SELECT ra.nome, responsavel.id FROM carta c' 
	           . ' INNER JOIN beneficiado b ON b.id = c.beneficiado' 
	           . ' INNER JOIN responsavel ON responsavel.id=b.responsavel' 
	           . ' INNER JOIN regiao_administrativa ra ON ra.id=c.regiao_administrativa'
               . ' WHERE c.removida = 0'
               . ($campanha ? ' AND LEFT(c.numero, 4) = ' . $campanha : '')
	           . ' GROUP BY ra.nome, responsavel.id) AS TBL'
            . ' GROUP BY nome'
            . ' ORDER BY nome', FALSE);
        return $this->db->get()->result_array();
    }
    
    function get_total_cartas_por_mobilizador($campanha='') {
        $this->db->select(
             'CASE u.first_name' 
            .'		WHEN u.first_name IS NULL THEN u.first_name' 
            .'		ELSE \'Sem mobilizador vinculado\' END as nome,' 
            .' COUNT(1) AS total'  
            .' FROM carta c'
            .' LEFT JOIN usuario u ON u.id=c.mobilizador'
            .' WHERE c.removida=0'
            . ($campanha ? ' AND LEFT(c.numero, 4) = ' . $campanha : '')
            .' GROUP BY u.first_name' 
            .' ORDER BY u.first_name', FALSE);
        return $this->db->get()->result_array();
    }
    
    function get_total_cartas_por_carteiro($campanha='') {
        $this->db->select(
            'CASE u.first_name'
            .'		WHEN u.first_name IS NULL THEN u.first_name'
            .'		ELSE \'Sem carteiro vinculado\' END as nome,'
            .' COUNT(1) AS total'
            .' FROM carta c'
            .' LEFT JOIN usuario u ON u.id=c.carteiro_associado'
            .' WHERE c.removida=0'
            . ($campanha ? ' AND LEFT(c.numero, 4) = ' . $campanha : '')
            .' GROUP BY u.first_name'
            .' ORDER BY u.first_name', FALSE);
        return $this->db->get()->result_array();
    }
    
    function get_total_cartas_adotadas_por_regiao($campanha='') {
        $this->db->select(
            ' ra.nome, COUNT(1) as total FROM carta c'
            . ' JOIN regiao_administrativa ra ON ra.id=c.regiao_administrativa'
            . ' WHERE c.adotante IS NOT NULL AND c.removida=0'
            . ($campanha ? ' AND LEFT(c.numero, 4) = ' . $campanha : '')
            . ' GROUP BY ra.nome'
            . ' ORDER BY nome', FALSE);
        return $this->db->get()->result_array();
    }
    
    function get_total_cartas_aguardando_adocao_por_regiao($campanha='') {
        $this->db->select(
            ' ra.nome, COUNT(1) as total FROM carta c'
            . ' JOIN regiao_administrativa ra ON ra.id=c.regiao_administrativa'
            . ' WHERE c.adotante IS NULL AND c.removida=0'
            . ($campanha ? ' AND LEFT(c.numero, 4) = ' . $campanha : '')
            . ' GROUP BY ra.nome'
            . ' ORDER BY nome', FALSE);
        return $this->db->get()->result_array();
    }
        
    /*
     * function to add new carta_pedido
     */
    function add_carta_pedido($params)
    {
        $this->db->insert('carta',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update carta_pedido
     */
    function update_carta_pedido($id, $params)
    {
        $this->db->where('id', $id);
        return $this->db->update('carta', $params);
    }
    
    /*
     * function to delete carta_pedido
     */
    function delete_carta_pedido($id)
    {
        $this->db->where('id', $id);
        $params = array(
            'removida' => 1
        );
        return $this->db->update('carta', $params);
    }
    
    function get_cartas_por_parametros($limit, $start, $numero_carta, $idCarteiro, $idRegiaoAdministrativa, $idMobilizador, $nomeCrianca, $nomeResponsavel, $situacao, $campanha, $instituicao, $removida, $ordem, $direcao)
    {
        $this->db->limit($limit, $start);
        $this->db->select('carta.*, beneficiado.nome as beneficiado_nome, beneficiado.data_nascimento as beneficiado_data, responsavel.nome as responsavel_nome, adotante.nome as adotante_nome, carteiro.first_name as carteiro_nome, mobilizador.first_name as mobilizador_nome');
        $this->db->from('carta');
        $this->db->join('beneficiado', 'carta.beneficiado = beneficiado.id');
        $this->db->join('responsavel', 'beneficiado.responsavel = responsavel.id');
        $this->db->join('usuario carteiro', 'carteiro.id = carta.carteiro_associado', 'left');
        $this->db->join('usuario mobilizador', 'mobilizador.id = carta.mobilizador', 'left');
        $this->db->join('adotante', 'carta.adotante = adotante.id', 'left');
        if ($idCarteiro) {
            $this->db->where('carteiro_associado', $idCarteiro);
        }
        if ($nomeCrianca) {
            $this->db->like('beneficiado.nome', $nomeCrianca);
        }
        if ($nomeResponsavel) {
            $this->db->like('responsavel.nome', $nomeResponsavel);
        }
        if ($idMobilizador) {
            $this->db->where('carta.mobilizador', $idMobilizador);
        }
        if ($numero_carta) {
            $this->db->where('carta.numero', $numero_carta);
        }
        if ($idRegiaoAdministrativa) {
            $this->db->where('regiao_administrativa', $idRegiaoAdministrativa);
        }
        if ($situacao == 'SEM_CARTEIRO_VINCULADO') {
            $this->db->where('carteiro_associado IS NULL');
        }
        if ($situacao == 'SEM_MOBILIZADOR_VINCULADO') {
            $this->db->where('carta.mobilizador IS NULL');
        }
        if ($situacao == 'AGUARDANDO_ADOCAO') {
            $this->db->where('adotante IS NULL');
        }
        if ($campanha) {
            $this->db->where("LEFT(carta.numero, 4) = " . $campanha);
        }
        if ($instituicao) {
            $this->db->join('TBC02_ABRANGENCIA_INSTITUICAO', 'carta.NU_TBC02 = TBC02_ABRANGENCIA_INSTITUICAO.NU_TBC02', 'INNER');
            $this->db->where('TBC02_ABRANGENCIA_INSTITUICAO.NU_TBP01', $instituicao);
        }
        $this->db->where('carta.removida', $removida);
        
        $this->db->order_by(($ordem ? $ordem : 'id'), ($direcao ? $direcao : 'desc'));

        return $this->db->get()->result_array();
    }
    
    function contar_cartas_por_parametros($numero_carta, $idCarteiro, $idRegiaoAdministrativa, $idMobilizador, $nomeCrianca, $nomeResponsavel, $situacao, $campanha, $instituicao, $removida) 
    {
        $this->db->select('*');
        $this->db->from('carta');
        $this->db->join('beneficiado', 'carta.beneficiado = beneficiado.id');
        $this->db->join('responsavel', 'beneficiado.responsavel = responsavel.id');
        if ($idCarteiro) {
            $this->db->where('carteiro_associado', $idCarteiro);
        }
        if ($nomeCrianca) {
            $this->db->like('beneficiado.nome', $nomeCrianca);
        }
        if ($nomeResponsavel) {
            $this->db->like('responsavel.nome', $nomeResponsavel);
        }
        if ($idMobilizador) {
            $this->db->where('mobilizador', $idMobilizador);
        }
        if ($numero_carta) {
            $this->db->where('carta.numero', $numero_carta);
        }
        if ($idRegiaoAdministrativa) {
            $this->db->where('regiao_administrativa', $idRegiaoAdministrativa);
        }
        if ($situacao == 'SEM_CARTEIRO_VINCULADO') {
            $this->db->where('carteiro_associado IS NULL');
        }
        if ($situacao == 'SEM_MOBILIZADOR_VINCULADO') {
            $this->db->where('carta.mobilizador IS NULL');
        }
        if ($situacao == 'AGUARDANDO_ADOCAO') {
            $this->db->where('adotante IS NULL');
        }
        if ($campanha) {
            $this->db->where("LEFT(carta.numero, 4) = " . $campanha);
        }
        if ($instituicao) {
            $this->db->join('TBC02_ABRANGENCIA_INSTITUICAO', 'carta.NU_TBC02 = TBC02_ABRANGENCIA_INSTITUICAO.NU_TBC02', 'INNER');
            $this->db->where('TBC02_ABRANGENCIA_INSTITUICAO.NU_TBP01', $instituicao);
        }
        $this->db->where('carta.removida', $removida);

        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function contar_todas_cartas($campanha='') {
        $this->db->where('removida', false);
        if ($campanha)
            $this->db->where('LEFT(carta.numero, 4) = ', $campanha);
        $this->db->from('carta');
        return $this->db->count_all_results();
    }
    
    function pesquisar_por_ano_adotante($anoEvento, $idAdotante) {
        $this->db->select('carta.*, beneficiado.nome as beneficiado_nome, responsavel.nome as responsavel_nome, beneficiado.data_nascimento');
        $this->db->join('beneficiado', 'carta.beneficiado = beneficiado.id');
        $this->db->join('responsavel', 'beneficiado.responsavel = responsavel.id');
        $this->db->like('carta.numero', $anoEvento, 'after');
        $this->db->where('carta.adotante', $idAdotante);
        $this->db->where('carta.removida', false);
        $this->db->order_by('id', 'asc');
        return $this->db->get('carta')->result_array();
    }

    function get_carta_by_numeroCarta($numeroCarta) {
        return $this->db->get_where('carta',array('carta.numero'=>$numeroCarta))->row_array();
    }

    function get_dados_complementares_carta_por_id($idCarta)
    {
        $this->db->select('carta.*, beneficiado.nome as beneficiado_nome, responsavel.nome as responsavel_nome, beneficiado.data_nascimento');
        $this->db->from('carta');
        $this->db->join('beneficiado', 'carta.beneficiado = beneficiado.id');
        $this->db->join('responsavel', 'beneficiado.responsavel = responsavel.id');
        $this->db->where('carta.id', $idCarta);
        $this->db->where('carta.removida', false);
        // echo "<pre>"; print_r($this->db->get_compiled_select()); exit();
        return $this->db->get()->row_array();
    }
    
    function pesquisar_por_regiao($idRegiaoAdministrativa) {
        $this->db->select('carta.numero, carta.removida, beneficiado.nome as beneficiado_nome, responsavel.nome as responsavel_nome'.
            ', carta.adotante, carta.credenciado, presente.situacao as presente_situacao');
        $this->db->join('beneficiado', 'carta.beneficiado = beneficiado.id');
        $this->db->join('responsavel', 'beneficiado.responsavel = responsavel.id');
        $this->db->join('presente', 'presente.carta = carta.id');
        $this->db->order_by('responsavel.nome', 'asc');
        $this->db->order_by('beneficiado.nome', 'asc');
        $this->db->where('carta.regiao_administrativa', $idRegiaoAdministrativa);
        return $this->db->get('carta')->result_array();
    }
    
    function get_total_cartas_por_regiao() {
        $this->db->select('ra.id, ra.nome, COUNT(1) as total');
        $this->db->join('regiao_administrativa ra', 'ra.id=carta.regiao_administrativa');
        $this->db->group_by('ra.id');
        $this->db->group_by('ra.nome');
        $this->db->order_by('ra.nome', 'asc');
        $this->db->where('carta.removida', false);
        return $this->db->get('carta')->result_array();
    }

    function get_total_cartas_por_instituicao_campanha($id) {
        $this->db->select('COUNT(1) as total');
        $this->db->where('carta.NU_TBC02', $id);
        return $this->db->get('carta')->row_array();
    }

    function get_galeria($id='')
    {
        $this->db->select('*');
        $this->db->from('galeria');
        $this->db->where('carta_id', NULL);
        if ($id) {
            $this->db->where('enviado_por', $id);
            $query = $this->db->get();
            $result = $query->result_array();
        }
        else
        {
            $this->db->order_by('enviado_em','desc');
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return !empty($result) ? $result : false;
    }

    function inserir_galeria($data = array())
    {
        $insert = $this->db->insert_batch('galeria', $data);
        return $insert ? true : false;
    }

    function get_galeria_by_carta($id)
    {
        return $this->db->get_where('galeria', array('carta_id'=>$id))->result_array();
    }

    function get_categorias_galeria()
    {
        return $this->db->get('categoria_galeria')->result_array();
    }
}
