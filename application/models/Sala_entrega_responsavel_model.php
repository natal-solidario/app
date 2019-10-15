<?php
 
class Sala_entrega_responsavel_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function get_por_sala_entrega($idSalaEntrega, $idRegiaoAdministrativa)
    {        
        $sql = 'SELECT r.id, UPPER(r.nome) as nome, (SELECT COUNT(1) FROM carta c JOIN beneficiado b ON b.id=c.beneficiado
            WHERE c.regiao_administrativa = '. $idRegiaoAdministrativa .' AND b.responsavel=r.id) as total_criancas
            FROM sala_entrega_responsavel
            JOIN responsavel r ON sala_entrega_responsavel.responsavel = r.id
            WHERE sala_entrega_presente = '. $idSalaEntrega .'
            ORDER BY r.nome';
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}