<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Dashboard extends CI_Controller{
    function __construct()
    {
        parent::__construct();

		if (!$this->ion_auth->logged_in())
		{
			$this->session->set_flashdata('message', 'You must be an admin to view this page');
			redirect('login');
		} else {
			$user = $this->ion_auth->user()->row();
			$user_groups = $this->ion_auth->get_users_groups()->result();

			$grupos = array();
	        foreach ($user_groups as $grupo) {
	            array_push($grupos, $grupo->name);
	        }
	        $this->session->set_userdata('grupos_usuario', $grupos);
			$this->session->set_userdata('usuario_logado', $user->email);
			
		}
        
		$this->load->model('Carta_model');
    }

    function index()
    {
        $data['total_cartas'] = $this->Carta_model->contar_todas_cartas();
        
        $data['total_responsaveis'] = $this->Carta_model->get_total_responsaveis_por_regiao();
        $data['total_responsaveis_somatorio'] = 0;
        foreach ($data['total_responsaveis'] as $item) {
            $data['total_responsaveis_somatorio'] = $data['total_responsaveis_somatorio'] + $item['total'];
        }
        
        $data['total_por_carteiro'] = $this->Carta_model->get_total_cartas_por_carteiro();
        $data['total_por_carteiro_somatorio'] = 0;
        foreach ($data['total_por_carteiro'] as $item) {
            $data['total_por_carteiro_somatorio'] = $data['total_por_carteiro_somatorio'] + $item['total'];
        }
        
        $data['total_por_mobilizador'] = $this->Carta_model->get_total_cartas_por_mobilizador();
        $data['total_por_mobilizador_somatorio'] = 0;
        foreach ($data['total_por_mobilizador'] as $item) {
            $data['total_por_mobilizador_somatorio'] = $data['total_por_mobilizador_somatorio'] + $item['total'];
        }
        
        $data['total_cartas_adotadas'] = $this->Carta_model->get_total_cartas_adotadas_por_regiao();
        $data['total_cartas_adotadas_somatorio'] = 0;
        foreach ($data['total_cartas_adotadas'] as $item) {
            $data['total_cartas_adotadas_somatorio'] = $data['total_cartas_adotadas_somatorio'] + $item['total'];
        }
        
        $data['total_cartas_aguardando_adocao'] = $this->Carta_model->get_total_cartas_aguardando_adocao_por_regiao();
        $data['total_cartas_aguardando_adocao_somatorio'] = 0;
        foreach ($data['total_cartas_aguardando_adocao'] as $item) {
            $data['total_cartas_aguardando_adocao_somatorio'] = $data['total_cartas_aguardando_adocao_somatorio'] + $item['total'];
        }

        $data['_view'] = 'dashboard';
        $this->load->view('layouts/main',$data);
    }
}
