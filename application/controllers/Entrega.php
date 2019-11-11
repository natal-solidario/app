<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Entrega extends MY_Controller{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Sala_entrega_presente_model');
        $this->load->model('Sala_entrega_responsavel_model');
        $this->load->model('Local_entrega_regiao_model');
        $this->load->model('Carta_model');
        $this->load->model('Regiao_administrativa_model');
    }
    
    /*
     * Listing of beneficiados
     */
    function index()
    {
        $data['salas'] = $this->Sala_entrega_presente_model->get_por_ano(date("Y"));
        
        $data['_view'] = 'entrega/index';
        $this->load->view('layouts/main',$data);
    }
    
    function inscritos($idSalaPalestra)
    {
        
        
        $data['salaSelecionada'] = $this->Sala_entrega_presente_model->get_por_id($idSalaPalestra);
        
        if($data['salaSelecionada'])
        {
            $data['responsaveis'] = $this->Sala_entrega_responsavel_model->get_por_sala_entrega(
                $idSalaPalestra, $data['salaSelecionada']['regiao_administrativa_id']);
            
            $data['total'] = 0;
            foreach($data['responsaveis'] as $item) {
                $data['total'] = $data['total'] + $item['total_criancas']; 
            }
            
            $data['_view'] = 'entrega/inscritos';
            $this->load->view('layouts/main',$data);
        }
        else {
            show_error('A sala de palestra informada não foi encontrada.');
        }
    }
    
    function listagem_local_entrega()
    {
        $data['locaisEntrega'] = $this->Local_entrega_regiao_model->get_local_entrega_familias();
        $data['_view'] = 'entrega/listagem_local_entrega';
        $this->load->view('layouts/main',$data);
    }
    
    function cartas($idRegiaoAdministrativa)
    {
        $data['regiao_administrativa'] = $this->Regiao_administrativa_model->get_por_id($idRegiaoAdministrativa);
        
        $data['cartas'] = $this->Carta_model->pesquisar_por_regiao($idRegiaoAdministrativa);
        $data['_view'] = 'entrega/cartas';
        $this->load->view('layouts/main',$data);
    }
}