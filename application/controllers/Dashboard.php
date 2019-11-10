<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Dashboard extends MY_Controller
{
    function __construct()
    {
        parent::__construct();        
		$this->load->model('Carta_model');
		$this->load->model('Campanha_model');
    }

    function index()
    {
        $data['all_campanhas'] = $this->Campanha_model->get_all();

        $data['campanha'] = $this->input->get('campanha');
        if (!array_key_exists('campanha', $this->input->get()))
            $data['campanha'] = $this->Campanha_model->get_campanha_atual()['AA_CAMPANHA'];

        $data['total_cartas'] = $this->Carta_model->contar_todas_cartas($data['campanha']);
        
        $data['total_responsaveis'] = $this->Carta_model->get_total_responsaveis_por_regiao($data['campanha']);
        $data['total_responsaveis_somatorio'] = 0;
        foreach ($data['total_responsaveis'] as $item) {
            $data['total_responsaveis_somatorio'] = $data['total_responsaveis_somatorio'] + $item['total'];
        }
        
        $data['total_por_carteiro'] = $this->Carta_model->get_total_cartas_por_carteiro($data['campanha']);
        $data['total_por_carteiro_somatorio'] = 0;
        foreach ($data['total_por_carteiro'] as $item) {
            $data['total_por_carteiro_somatorio'] = $data['total_por_carteiro_somatorio'] + $item['total'];
        }
        
        $data['total_por_mobilizador'] = $this->Carta_model->get_total_cartas_por_mobilizador($data['campanha']);
        $data['total_por_mobilizador_somatorio'] = 0;
        foreach ($data['total_por_mobilizador'] as $item) {
            $data['total_por_mobilizador_somatorio'] = $data['total_por_mobilizador_somatorio'] + $item['total'];
        }
        
        $data['total_cartas_adotadas'] = $this->Carta_model->get_total_cartas_adotadas_por_regiao($data['campanha']);
        $data['total_cartas_adotadas_somatorio'] = 0;
        foreach ($data['total_cartas_adotadas'] as $item) {
            $data['total_cartas_adotadas_somatorio'] = $data['total_cartas_adotadas_somatorio'] + $item['total'];
        }
        
        $data['total_cartas_aguardando_adocao'] = $this->Carta_model->get_total_cartas_aguardando_adocao_por_regiao($data['campanha']);
        $data['total_cartas_aguardando_adocao_somatorio'] = 0;
        foreach ($data['total_cartas_aguardando_adocao'] as $item) {
            $data['total_cartas_aguardando_adocao_somatorio'] = $data['total_cartas_aguardando_adocao_somatorio'] + $item['total'];
        }

        $data['_view'] = 'dashboard';
        $this->load->view('layouts/main',$data);
    }
}
